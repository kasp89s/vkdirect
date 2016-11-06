<div class="col-md-3 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="list-group">
        <? foreach ($this->menu as $link => $item):?>
            <a href="<?= Yii::app()->params['baseUrl']?><?= $link?>" class="list-group-item <?= $item['class']?>"><?= $item['title']?></a>
        <? endforeach; ?>
        <?php if ($this->user->role == 1):?>
            <a href="<?= Yii::app()->params['baseUrl'] . '/admin'?>" class="list-group-item">Админ панель</a>
        <?php endif?>
    </div>
<!--<div class="btn-group btn-group-justified">-->
<!--        <div class="btn-group">-->
    <div class="well">
        <form role="form" action="" method="post">
            <div class="form-group">
                <center><label for="codeCoupon">Активация купона</label></center>
                <input type="text" class="form-control" name="codeCoupon" id="codeCoupon" placeholder="Ваш код купона">
            </div>
                <center><button type="submit" class="btn btn-default btn-xs">Активировать</button></center>
            </form>
        <? if (empty($this->couponError) === false):?>
            <?= $this->couponError;?>
        <? endif;?>

        <? if (empty($this->couponAmount) === false):?>
            <?= $this->couponAmount;?>
        <? endif;?>
    </div>

<!--        </div>-->
<!--    </div>-->
</div>
