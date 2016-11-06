<?php
global $user, $base_url;
include 'DB.php';

$db = DB::instance();
$userHost = 'http://'.$_POST['host']; 
$mynid = $_POST['nid'];
$remoteip = $_SERVER['REMOTE_ADDR'];
$myid = $db->select("SELECT `value` FROM `setting` WHERE `title` = 'vk_app_id'")->find()->value;
$identifyPrice = $db->select("SELECT `value` FROM `setting` WHERE `title` = 'identify_price'")->find()->value;
$myguid = $_POST['guid'];
$userId = $_POST['userId'];

$mycookieid = (int)$_POST['ckid'];

// Ищем юзера.
$user = $db->select("SELECT * FROM `user` WHERE `id` = :userId", array(':userId' => $userId))->find();

if (empty($user->id) || $user->balance < $identifyPrice) {
	die('no money no honey!');
}

// Ищем сайт пользователя.
$site = $db->select("SELECT * FROM `user_sites` WHERE `userId` = :userId AND `url` = :url",
 array(':userId' => $userId, ':url' => $userHost))->find();

if (empty($site->id)) {
	die('no site!');
}

$db->update('user_log', $mycookieid, array('isAuth' => 1));

$mylink = 'https://api.vk.com/method/likes.getList?type=sitepage&owner_id='.$myid.'&page_url='.$userHost.'?mypp='.$myguid;
//print $mylink;
$myjs1 = file_get_contents($mylink);
$myvk1 = json_decode($myjs1);
$mycc = $myvk1->response->users[0];

//print $mycc;

$mylink = 'https://api.vk.com/method/users.get?lang=ru&user_ids='.$mycc.'&fields=sex,bdate,city,country,photo_50,interests,domain,has_mobile,contacts,connections,activities';
    $myjs1 = file_get_contents($mylink);
    
    $myvkuser = json_decode($myjs1);

    $mycity = '';
    $mylink3 = 'https://api.vk.com/method/database.getCitiesById?lang=ru&city_ids='.$myvkuser->response[0]->city;
    $myjs3 = file_get_contents($mylink3);
    $myvkcity = json_decode($myjs3);
    $mycity = $myvkcity->response[0]->name;

    $userData = array(
                        'siteId' => $site->id,
                        'uid' => $user->id,
	  					'nid' => $mynid,
	  					'cookid' => $mycookieid,
	  					'vkid' => $mycc,
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
	  	);

    // Ищем может юзер уже был.
    $oldIdentify = $db->select("SELECT `id`, `count` FROM `user_identifying` WHERE `siteId` = :siteId AND `uid` = :uid AND `vkid` = :vkid",
    array(':siteId' => $site->id, ':uid' => $user->id, ':vkid' => $mycc))->find();

    if(isset($oldIdentify->id)) {
        $db->update('user_identifying', $oldIdentify->id, array('count' => $oldIdentify->count + 1, 'time' => date('Y-m-d H:i:s', time())));
    } else {
        $db->create('user_identifying', $userData);
        $db->update('user', $user->id, array('balance' => $user->balance - $identifyPrice));
    }
?>
