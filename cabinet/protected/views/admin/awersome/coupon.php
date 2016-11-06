<div class="row">
    <div class="col-sm-9">
        <h2>Купоны</h2>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <center>
            <form role="form" action="" method="post">
                <table>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">Код</div>
                                <input class="form-control" type="text" name="code">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">Сумма</div>
                                <input class="form-control" type="text" name="amount">
                            </div>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-default">Добавить</button>
                        </td>
                    </tr>
                </table>
            </form>
        </center>

        <? if(empty($models) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($models as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->code?></td>
                        <td><?= $item->amount?><?= Yii::app()->params['currency']?></td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/deletecoupon/' . $item->id?>" class="btn btn-danger btn-xs">Удалить</a>
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
