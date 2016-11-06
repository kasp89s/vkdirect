<div class="row">
    <div class="navbar-collapse collapse">
        <div id="main-menu">

            <ul class="nav nav-tabs hidden-xs">
                <li class="<?= ($type == 'processing') ? 'active' : ''?>">
                    <a href="<?= Yii::app()->params['baseUrl'] . '/purchase?type=processing'?>">Редиректы</a>
                </li>
                <li class="<?= ($type == 'buy') ? 'active' : ''?>">
                    <a href="<?= Yii::app()->params['baseUrl'] . '/purchase?type=buy'?>">Софт</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-sm-9">
        <h2>Список покупок</h2>
        <? if(empty($orders) === false):?>
        <table class="table table-first-column-number">
            <thead>
            <? if ($type == 'processing'):?>
                <tr>
                    <th>#</th>
                    <th>Тип заказа</th>
                    <th width="55px">Количество</th>
                    <th width="55px">Цена</th>
                    <th>Ссылка</th>
                    <th>Статус</th>
                    <th>Заказ</th>
                </tr>
            <? else:?>
                <tr>
                    <th>#</th>
                    <th>Тип заказа</th>
                    <th>Ссылка загрузки</th>
                    <th>Ключ</th>
                </tr>
            <? endif;?>
            </thead>
            <tbody>
            <? if ($type == 'processing'):?>
                <? foreach ($orders as $order):?>
                    <? if (empty($order->product)) continue;?>
                    <tr>
                        <td><?= $order->ID?></td>
                        <td><?= $order->product->title ?></td>
                        <td><?= $order->RUN_COUNT?></td>
                        <td><?= $order->RUN_COUNT / $order->product->countPrice * $order->product->price?><?= Yii::app()->params['currency']?></td>
                        <td><?= ($order->ORDER_STATE != 2) ? $order->URL : $order->product->productUrl?></td>
                        <td><?= Orders::$status[$order->ORDER_STATE]?></td>
                        <td>
                            <? if (empty($order->URL_RESULT) === false):?>
                                <a href="<?= $order->URL_RESULT?>" target="_blank">скачать</a>
                            <? endif;?>
                        </td>
                    </tr>
                <? endforeach;?>
            <? else:?>
                <? foreach ($orders as $order):?>
                    <tr>
                        <td><?= $order->id?></td>
                        <td><?= $order->product->title?></td>
                        <td><?= $order->product->url?></td>
                        <td><?= $order->code?></td>
                    </tr>
                <? endforeach;?>
            <? endif;?>
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
