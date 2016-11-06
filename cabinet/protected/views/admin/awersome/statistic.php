<div class="row">
    <div class="col-sm-9">
        <h2>Статистика</h2>

        <? if(empty($links) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Сылка redirekt.center</th>
                    <th>Текущая итоговая</th>
                    <th>Статистика (итоги)</th>
                    <th>Статистика (общая)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($links as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= 'http://' . $_SERVER['HTTP_HOST'] . '/' . $item->link?></td>
                        <td>
                            <? foreach($item->statistic as $statistic):?>
                                <? if ($statistic->active == 1):?>
                                    <?= $statistic->url?>
                                <? endif;?>
                            <? endforeach;?>
                        </td>
                        <td>
                            <? foreach($item->statistic as $statistic):?>
                                <?= $statistic->url?> (<?= $statistic->count?>) <br />
                            <? endforeach;?>
                        </td>
                        <td><?= $item->count?></td>
                        <td><a href="<?= Yii::app()->params['baseUrl'] . '/admin/changeLink/' . $item->id?>" class="btn btn-primary btn-xs">Редактировать</a></td>
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
