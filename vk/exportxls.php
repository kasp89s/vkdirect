<?php
global $user;
ini_set('memory_limit', '-1');
$user = user_load($user->uid);
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
    header("Content-Transfer-Encoding: binary ");
$view = views_get_view('_user');
$view->set_display('block_1');
$view->set_arguments(array($user->uid));
$view->is_cacheable = FALSE;
$view->pre_execute();
$view->execute();
$view->render();
//krumo($view);exit;

echo '
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="zabey" />
        <title>Export XLS</title>
    </head>
    <body>
';    

echo '<table><tr>
        <td colspan="7" style="background:#66abb3; color: #fff;font-weight: bold; font-size: 18px;">Заголовок</td>
      </tr></table>';

echo '
  <table border="1">
    <tr>
        <th>Имя</th>
        <th>Фамилия</th> 
        <th>Профиль ВК</th> 
        <th>Город</th> 
        <th>Пол</th>
        <th>Сайт</th> 
        <th>Время</th> 
    </tr>
';

foreach ($view->result as $key => $value) {
    $mypol = $value->field_field_vkuser_pol[0]['raw']['value'] == 2 ? 'М' : 'Ж';
    print '<tr><td>'.$value->field_field_vkuser_name[0]['raw']['value'].'</td>'.
    '<td>'.$value->field_field_vkuser_lname[0]['raw']['value'].'</td>'.
    '<td><a href="http://vk.com/id'.$value->field_field_vkuser_vkid[0]['raw']['value'].'">http://vk.com/id'.$value->field_field_vkuser_vkid[0]['raw']['value'].'</a></td>'.
    '<td>'.$value->field_field_vkuser_citytxt[0]['raw']['value'].'</td>'.
    '<td>'.$mypol .'</td>'.
    '<td>'.$value->field_field_vkuser_site[0]['raw']['value'].'</td>'.
    '<td>'.date('H:i:s d/m/Y',$value->field_field_vkuser_data[0]['raw']['value']+($user->field_mytimezone['und'][0]['value'])*3600).'</td>'.
    '</tr>';
}

echo '</table>';
echo '</body></html>';
