<div class="main_content">
    <? if (empty($error) === false):?>
        <div class="alert alert-danger"><?= $error?> <a href="<?= Yii::app()->params['baseUrl'] . '/list?type=buy'?>">Назад</a></div>
    <? else:?>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= $product->title?></h4>
            </div>
            <div class="modal-body">
                    <p>Спасибо за покупку!</p>
                    <p>Ваша ссылка на загрузку: <?= $product->url?></p>
                    <p>Ключ для загрузки: <?= $code?></p>
            </div>
            <div class="modal-footer">
                <a href="<?= Yii::app()->params['baseUrl'] . '/purchase?type=buy'?>" class="btn btn-default">Мои покупки</a>
            </div>
        </div>
    <?endif;?>
</div>
