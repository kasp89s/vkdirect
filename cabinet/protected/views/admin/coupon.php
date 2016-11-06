<div class="main_content">
    <div class="panel panel-default" style="margin-top: 50px;">
        <!-- Default panel contents -->
        <div class="panel-heading">Купоны</div>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <br />
        <center>
        <form class="form-inline" role="form" action="" method="post">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Код</div>
                    <input class="form-control" type="text" name="code">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Сумма</div>
                    <input class="form-control" type="text" name="amount">
                </div>
            </div>
            <button type="submit" class="btn btn-default">Добавить</button>
        </form>
        </center>
        <br />
        <? if(empty($models) === false):?>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
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
            </table>
        <? endif;?>
    </div>

    <? $this->widget('CLinkPager', array(
            'pages' => $pages,
            'selectedPageCssClass' => 'active',
            'header' => '',
            'htmlOptions' => array(
                'class' => 'pagination'
            )
        ))?>
</div>
