<div class="col-md-3 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="list-group">
        <? foreach ($this->menu as $link => $item):?>
            <a href="<?= Yii::app()->params['baseUrl']?><?= $link?>" class="list-group-item <?= $item['class']?>"><?= $item['title']?></a>
        <? endforeach; ?>
    </div>
</div>
