<h3>Статистика</h3>
<div class="main_content">
    <div class="panel panel-default">
        <? if(empty($links) === false):?>
            <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Сылка redirekt.center</th>
                        <th>Текущая итоговая</th>
                        <th>Статистика (итоги)</th>
                        <th>Статистика (общая)</th>
                        <th></th>
                    </tr>
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

