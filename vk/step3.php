<?php
global $base_url;
$remoteip = $_SERVER['REMOTE_ADDR'];

$myistest = 0;
$mynid = (int)$_POST['nid'];
$mygid = (int)$_POST['gid'];
$mymt = (int)$_POST['mt'];
$mycookieid = (int)$_POST['ckid'];


$mylink = 'https://api.vk.com/method/groups.getMembers?group_id='.$mygid;
$myjs1 = file_get_contents($mylink);
$myvk1 = json_decode($myjs1);
$mycc = $myvk1->response->count;
$my1000 = floor(((int)$mycc)/1000);

$myidarrs = array();
$myii = 0;
for ($i=0; $i <= $my1000 ; $i++) { 
  $mylink = 'https://api.vk.com/method/groups.getMembers?group_id='.$mygid.'&offset='.(1000*$i);
  $myjs1 = file_get_contents($mylink);
  $myvk1 = json_decode($myjs1);
  $myits = $myvk1->response->users;
  $myidarrs = array_merge($myidarrs,$myits);
}

if ($mymt == 0) {
  db_truncate('vk'.$mynid)->execute();
  foreach ($myidarrs as $key => $value) {
    $id = db_insert('vk'.$mynid)
	  ->fields(array('id' => $value))
	  ->execute();
  }  
}

if ($mymt == 1) {
  $myidarrs0 = array();

  	$query = db_select('vk'.$mynid, 'v');
	$query->fields('v');
	$import = $query->execute();

	foreach ($import as $val) {
	  $myidarrs0[] = (int)$val->id;
	}

  $mydiff = array_diff($myidarrs,$myidarrs0);

  if ($myistest == 1) {
      print_r($mydiff);
  }

  db_truncate('vk'.$mynid)->execute();

  foreach ($myidarrs as $key => $value) {
    $id = db_insert('vk'.$mynid)
	  ->fields(array('id' => $value))
	  ->execute();
  }

  if (count($mydiff) > 0) {
    foreach ($mydiff as $key => $value) {
      $myid = $value;
    }
    $mylink = 'https://api.vk.com/method/users.get?lang=ru&user_ids='.$myid.'&fields=sex,bdate,city,country,photo_50,interests,domain,has_mobile,contacts,connections,activities';
    $myjs1 = file_get_contents($mylink);
    
    $myvkuser = json_decode($myjs1);
    if ($myistest == 1) {
      print $myid.' ';
      print $myjs1.' ';
      print_r($myvkuser).' ';
      print $mycookieid.' '; 
    }
    
    $query = db_select('node', 'n');
	$query->fields('n');
	$query->condition('n.nid', $mynid);
	$import = $query->execute();

	foreach ($import as $val) {
	  $myuid = $val->uid;
	}


    $mycity = '';
    $mylink3 = 'https://api.vk.com/method/database.getCitiesById?lang=ru&city_ids='.$myvkuser->response[0]->city;
    $myjs3 = file_get_contents($mylink3);
    $myvkcity = json_decode($myjs3);
    $mycity = $myvkcity->response[0]->name;

    $id = db_insert('myvk')
	  ->fields(array('uid' => $myuid,
	  					'uid' => $myuid,
	  					'nid' => $mynid,
	  					'cookid' => $mycookieid,
	  					'vkid' => $myid,
	  					'vkname' => $myvkuser->response[0]->first_name ? $myvkuser->response[0]->first_name : '',
	  					'lname' => $myvkuser->response[0]->last_name ? $myvkuser->response[0]->last_name : '',
	  					'sex' => $myvkuser->response[0]->sex,
	  					'domain' => $myvkuser->response[0]->domain ? $myvkuser->response[0]->domain : '',
	  					'bdate' => $myvkuser->response[0]->bdate ? $myvkuser->response[0]->bdate : '',
	  					'city' => $myvkuser->response[0]->city,
	  					'citytxt' => $mycity ? $mycity : '',
	  					'photo_50' => $myvkuser->response[0]->photo_50 ? $myvkuser->response[0]->photo_50 : '',
	  					'interests' => $myvkuser->response[0]->interests ? $myvkuser->response[0]->interests : '',
	  					'activities' => $myvkuser->response[0]->activities ? $myvkuser->response[0]->activities : '',
	  					'contacts' => $myvkuser->response[0]->contacts ? $myvkuser->response[0]->contacts : '',
	  					'remoteid' => $remoteip

	  	))
	  ->execute();


    $mylink = '<?=$base_url?>/mymodule/checknew';
    $myjs1 = file_get_contents($mylink);
  }
}







