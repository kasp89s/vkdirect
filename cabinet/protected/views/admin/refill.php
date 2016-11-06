<div class="main_content">
    <div class="panel panel-default" style="margin-top: 50px;">
        <!-- Default panel contents -->
        <div class="panel-heading">Бонусы пополнения</div>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <br />
        <center>
            <form class="form-inline" role="form" action="" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">От</div>
                        <input class="form-control" type="text" name="min" style="width: 126px;">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">До</div>
                        <input class="form-control" type="text" name="max" style="width: 126px;">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">Бонус %</div>
                        <input class="form-control" type="text" name="bonus" style="width: 126px;">
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
                    <th>От</th>
                    <th>До</th>
                    <th>Бонус</th>
                    <th></th>
                </tr>
                <? foreach ($models as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->min?></td>
                        <td><?= $item->max?></td>
                        <td><?= $item->bonus?> %</td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/deleterefill/' . $item->id?>" class="btn btn-danger btn-xs">Удалить</a>
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
