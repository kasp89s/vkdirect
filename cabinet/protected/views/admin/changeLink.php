<h3>Редактировать итоговую ссылку</h3>
<? if (empty($errors) === false) :?>
    <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
<? endif;?>
<? if (empty($save) === false) :?>
    <div class="alert alert-success" role="alert">Запись сохранена!</div>
<? endif;?>
<?php
foreach ($link->statistic as $statistic){
    if ($statistic->active == 1) {
        $currentLink = $statistic;
        break;
    }
}
?>
<div class="main_content">
    <form role="form" action="" method="post">
        <div class="form-group">
            <label for="username">Ссылка редиректа</label>
            <input type="text" class="form-control" id="link" name="link" value="<?= $link->link?>"/>
        </div>
        <div class="form-group">
            <label for="username">Текущая ссылка</label>
            <input type="text" class="form-control" id="currentLink" name="currentLink" value="<?= $currentLink->url?>"/>
            <input type="hidden" name="oldId" value="<?= $currentLink->id?>">
        </div>

        <button type="submit" class="btn btn-default">Сохранить</button>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/statistics'?>" >Назад</a>
    </form>

</div>
