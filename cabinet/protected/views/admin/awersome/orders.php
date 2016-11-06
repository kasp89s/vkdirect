<div class="row">
    <div class="col-sm-9">
        <h2>Заказы</h2>

        <? if(empty($orders) === false):?>
            <table class="table table-first-column-number">
                <thead>
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
                </thead>
                <tbody>
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
