<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title ?></title>
    <!-- Bootstrap -->
    <link href="<?= Yii::app()->params['baseUrl']?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?= Yii::app()->params['baseUrl']?>/js/bootstrap.min.js"></script>

<?= $this->renderPartial('block/header'); ?>


<style>
    .block {min-height:500px; background-color: #EEEEEE; }
    .block2 {  height:20px; background-color: #EEEEEE; margin-top:5px; }
    .main_content { padding:5px; background-color: #F1F1F1;  }
</style>

<div class="container" style="margin-top: 55px;">
    <div class="row">

        <?= $this->renderPartial('block/navigation'); ?>

        <div class="col-md-9 col-sm-9 block">

        <?= $content?>

        </div>
    </div>

</div>
<script src="<?= Yii::app()->params['baseUrl']?>/js/main.js"></script>
<hr>
<p class="pull-right">Тема <a href="javascript:void(0);" onclick="document.cookie = 'awersome=; path=/; expires=-1'; document.location.href='';">Старая</a>, <a href="javascript:void(0);" onclick="document.cookie = 'awersome=1; path=/;'; document.location.href='';">новая</a></p>
</body>
</html>
