<div class="row">
    <div class="col-sm-9">
        <h2>Ключи софта</h2>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <center>
            <!--            <form class="form-inline" role="form" action="" method="post">-->
            <!--                <div class="form-group">-->
            <!--                    <div class="input-group">-->
            <!--                        <div class="input-group-addon">Код</div>-->
            <!--                        <input class="form-control" type="text" name="code">-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <button type="submit" class="btn btn-default">Добавить</button>-->
            <!--            </form>-->
        </center>
        <br />
        <? if(empty($models) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Товар</th>
                    <th>Код</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($models as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->product->title?></td>
                        <td><?= $item->code?></td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/deletesoftcode/' . $item->id?>" class="btn btn-danger btn-xs">Удалить</a>
                        </td>
                    </tr>
                <? endforeach;?>
                <tbody>
            </table>
        <? endif;?>

        <? $this->widget('CLinkPager', array(
                'pages' => $pages,
                'selectedPageCssClass' => 'active',
                'header' => '',
                'htmlOptions' => array(
                    'class' => 'pagination'
                )
            ))?>
    </div>
</div>
