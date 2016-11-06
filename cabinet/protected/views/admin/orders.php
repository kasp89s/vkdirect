<div class="main_content">
    <div class="panel panel-default" style="margin-top: 50px;">
        <!-- Default panel contents -->
        <div class="panel-heading">Заказы</div>
        <? if(empty($orders) === false):?>
            <table class="table" style="font-size: 11px;">
                <tr>
                    <th>ID</th>
                    <th>Товар</th>
                    <th>Пользователь</th>
                    <th>Количество</th>
                    <th>Ссылка сайта</th>
                    <th>Дата</th>
                    <th>Результат</th>
                    <th>Статус</th>
                </tr>
                <? foreach ($orders as $item):?>
                    <tr>
                        <? if (empty($item->product)) continue;?>
                        <td><?= $item->ID?></td>
                        <td><?= $item->product->title?></td>
                        <td><?= $item->USER_LOGIN?></td>
                        <td><?= $item->RUN_COUNT?></td>
                        <td><?= $item->URL?></td>
                        <td><?= $item->DATE_TIME ?></td>
                        <td><?= $item->URL_RESULT?></td>
                        <td>
                            <select class="status-selector" data-id="<?= $item->ID?>">
                                <? foreach (Orders::$status as $key => $status):?>
                                    <option value="<?= $key?>" <?= ($key == $item->ORDER_STATE) ? 'selected' : ''?>><?= $status?></option>
                                <?endforeach;?>
                            </select>
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
