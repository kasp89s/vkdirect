<div class="row">
    <div class="col-sm-9">
        <h2>Бонусы пополнения</h2>

        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <center>
            <form  role="form" action="" method="post">
                <table>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">От</div>
                                <input class="form-control" type="text" name="min" style="width: 126px;">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">До</div>
                                <input class="form-control" type="text" name="max" style="width: 126px;">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">Бонус %</div>
                                <input class="form-control" type="text" name="bonus" style="width: 126px;">
                            </div>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-default">Добавить</button>
                        </td>
                    </tr>
                </table>
            </form>
        </center>
        <br />
        <? if(empty($models) === false):?>
                <table class="table table-first-column-number">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>От</th>
                        <th>До</th>
                        <th>Бонус</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
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
                    </tbody>
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
