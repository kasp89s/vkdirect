<?php
Yii::app()->clientScript->registerPackage('awersome');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?= $this->title ?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- For sample logo only-->
    <!--Remove if you no longer need this font-->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Aguafina+Script">
    <!--For sample logo only-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
	  <div class="alert alert-success fade in" style="margin: 0; display:none;" id="info-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<div id="info-message-place"></div>
	  </div>
    <?= $this->renderPartial('awersome/block/header'); ?>

    <?= $this->renderPartial('awersome/block/navigation'); ?>

    
    <div class="content" style="min-height: 600px">

	        <?= $content?>

        <?= $this->renderPartial('awersome/block/rightSidebar'); ?>
        <footer>
            <hr>
            <!-- <p class="pull-right">Тема <a href="javascript:void(0);" onclick="document.cookie = 'awersome=; path=/; expires=-1';  document.location.href='';">Старая</a>, <a href="javascript:void(0);" onclick="document.cookie = 'awersome=1; path=/;';  document.location.href='';">новая</a></p> -->
            <p>&copy; 2014 <a href="/">Vk direct.</a></p>
        </footer>
        
    </div>
    <script src="<?= Yii::app()->params['baseUrl']?>/js/main.js"></script>

		<script type="text/javascript">
            var sound = {
                // На сообщения
                question: '<?= Yii::app()->params['baseUrl']?>/js/af068fe9cc3bcb4e8d10e23f3ef4c330.mp3',
                // На заказ редиректов
                order: '<?= Yii::app()->params['baseUrl']?>/js/af068fe9cc3bcb4e8d10e23f3ef4c330.mp3',
                // На заказ парсинга
                purchase: '<?= Yii::app()->params['baseUrl']?>/js/af068fe9cc3bcb4e8d10e23f3ef4c330.mp3',
                // На заказ рассылки
                delivery: '<?= Yii::app()->params['baseUrl']?>/js/af068fe9cc3bcb4e8d10e23f3ef4c330.mp3',
                // На уведомление пользователя о выполнение заказа парсинга
                informed: '<?= Yii::app()->params['baseUrl']?>/js/af068fe9cc3bcb4e8d10e23f3ef4c330.mp3'
            }

//			setInterval(
//			checkNewEvent,
//			5000
//			);
			
			function checkNewEvent()
			{
				$.post(
					'/cabinet/default/checkNewEvent',
					{},
					function (data)
					{
						if (data != null && data.question != null) {
							$('#info-message-place').html('<strong>Новый вопрос!</strong> "' + data.question + '..."');
							$('#info-block').slideDown("slow");
                            play(sound.question);
						}

						if (data != null && data.order != null) {
							$('#info-message-place').html('<strong>Новый заказ!</strong> От пользователя ' + data.order);
							$('#info-block').slideDown("slow");
                            play(sound.order);
						}

                        if (data != null && data.delivery != null) {
							$('#info-message-place').html('<strong>Новый заказ на рассылку!</strong> От пользователя ' + data.delivery);
							$('#info-block').slideDown("slow");
                            play(sound.delivery);
						}

                        if (data != null && data.purchase != null) {
							$('#info-message-place').html('<strong>Новый заказ на парсинг!</strong> От пользователя ' + data.purchase);
							$('#info-block').slideDown("slow");
                            play(sound.purchase);
						}
                        if (data != null && data.informed != null) {
							$('#info-message-place').html('<strong>Ваш заказ на редиректы выполнен!</strong> ' + data.informed);
							$('#info-block').slideDown("slow");
                            play(sound.informed);
						}
					},
					'json'
				);
			}

			function play(mp3){
				$('#music').html('<audio src="' + mp3 + '" autoplay></audio>')
			};
			
			 $(".count").bind('change click keyup', function(){
				 var name = $(this).val();
				 $(this).val(name.replace(/[^\w]/ig,""));
			});
		</script>

	<div id="music" style="display: none;"></div>
  </body>
</html>


