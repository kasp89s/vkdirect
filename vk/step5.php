<?php
$query = db_select('myvk', 'v');
  $query->fields('v');
  $query->condition('v.myval', 0);
  $query->orderBy('v.mydate', 'DESC');
  $query->range(0, 10);
  $import = $query->execute();

  $myitems = array();
  $myind = 0;
  foreach ($import as $val) {
    $myitems[] = $val;
  }

  //krumo($myitems);

  foreach ($myitems as $key => $value) {

    print '1';

    //krumo($value);

    db_update('myvk')
    ->fields(array('myval' => 1))
    ->condition('id', $value->id)
    ->execute();


    $mynode = node_load($value->nid); //сайт сканера

    //krumo($mynode);
    $query = db_select('vkdata', 'v');
    $query->fields('v');
    $query->condition('v.uid', $value->uid);
    $query->condition('v.vkid', $value->vkid);
    $query->condition('v.scannid', $mynode->nid);
    
    $import4 = $query->execute();
    $mynid4 = 0;
    foreach ($import4 as $key4 => $value4) {
      $mynid4=$value4->nid_site;
    }
    if ($mynid4 > 0) {
      $node = node_load($mynid4);
      $node->field_vkuser_data[LANGUAGE_NONE][0]['value'] = (strtotime($value->mydate) - 6*3600);
      $node->field_vkuser_col[LANGUAGE_NONE][0]['value'] = $node->field_vkuser_col[LANGUAGE_NONE][0]['value'] +1;
      if($node = node_submit($node)) { // Подготовка к сохранению
          node_save($node); // Сохранение ноды, теперь доступен nid новой ноды $node->nid
      }
      $id = db_insert('vkdata')
        ->fields(array('uid' => $value->uid,
                  'vkid' => $value->vkid,
                  'scannid' => $mynode->nid,
                  'nid_site' => $mynid4,
                  'site' => mygetsitefromcoodie($value->cookid),
                  'cookieid' => $value->cookid
          ))
        ->execute();
    } else {
      $node = new stdClass(); 
      $node->type = "vkuser"; 
      node_object_prepare($node); 

      $node->language = LANGUAGE_NONE;

      $node->title    = $mynode->field_socscan_url['und'][0]['value']." и vk.com/id".$value->vkid; 

      $node->uid = $value->uid; 

      // Заполнение поля body
      $bodytext = '';
      $node->body[LANGUAGE_NONE][0]['value'] = $bodytext;
      $node->body[LANGUAGE_NONE][0]['summary'] = text_summary($bodytext);
      $node->body[LANGUAGE_NONE][0]['format']  = 'filtered_html';


      $node->status = 0; // Опуликовано (1) или нет (0)
      $node->promote = 0; // Размещено на главной  (1) или нет (0)
      $node->sticky = 0; // Закреплено вверху списков  (1) или нет (0)
      $node->comment = 1; // Комментарии включены  (2) или нет (1)

      $node->field_vkuser_vkid[LANGUAGE_NONE][0]['value'] = $value->vkid;
      $node->field_vkuser_cookie_id[LANGUAGE_NONE][0]['value'] = $value->cookid;
      $node->field_vkuser_name[LANGUAGE_NONE][0]['value'] = $value->vkname;
      $node->field_vkuser_lname[LANGUAGE_NONE][0]['value'] = $value->lname;

      $node->field_vkuser_pol[LANGUAGE_NONE][0]['value'] = $value->sex;
      $node->field_vkuser_city[LANGUAGE_NONE][0]['value'] = $value->city;
      $node->field_vkuser_citytxt[LANGUAGE_NONE][0]['value'] = $value->citytxt;
      $node->field_vkuser_data[LANGUAGE_NONE][0]['value'] = (strtotime($value->mydate) - 6*3600);
      $mysite = $mynode->field_socscan_url['und'][0]['value'];
      $pos = strpos($mysite, 'xn--');
        if ($pos === false) {

        } else {
          require_once('idna_convert.class.php');
          $idn = new idna_convert(array('idn_version'=>2008));
          $mysite = $idn->decode($mysite);
        }
      $node->field_vkuser_site[LANGUAGE_NONE][0]['value'] = $mysite;

      $data = file_get_contents($value->photo_50);
      $file = file_save_data($data,'public://vkopt/' .md5($data) . ".jpg");
      $node->field_vkuser_photo['und'][]['fid'] = $file->fid;

      if($node = node_submit($node)) { // Подготовка к сохранению
          node_save($node); // Сохранение ноды, теперь доступен nid новой ноды $node->nid
      }


      $id = db_insert('vkdata')
        ->fields(array('uid' => $value->uid,
                  'vkid' => $value->vkid,
                  'scannid' => $mynode->nid,
                  'nid_site' => $node->nid,
                  'site' => mygetsitefromcoodie($value->cookid),
                  'cookieid' => $value->cookid

          ))
        ->execute();
      setmymoney($value->uid,-1);
    }
    
    



  $user_fields = user_load($value->uid);
  $mynewphone = $user_fields->field_myphone['und'][0]['value'];
  
  if ($mynode->field_socscan_email['und'][0]['value'] != '') {
    mysendmail($mynode->field_socscan_email['und'][0]['value'],'Идентификация с сайта '.$mynode->field_socscan_url['und'][0]['value'],'Профиль идентифицирован: http://vk.com/id'.$value->vkid);
  }
  

  }

  function mygetsitefromcoodie($mycookie) {
    $query = db_select('mylog', 'm');
    $query->fields('m');
    $query->condition('m.cookid', $mycookie);
    $import = $query->execute();

    $mysite = '';
    foreach ($import as $val) {
      if ($mysite == '') {
        $mysite = $val->site;
      }
    }
    return $mysite;
  }