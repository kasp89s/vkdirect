<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'kvWyDdQP4J';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<h3>Мои покупки</h3>
<div class="main_content">
    <ul class="nav nav-pills">
        <li class="<?= ($type == 'processing') ? 'active' : ''?>"><a href="<?= Yii::app()->params['baseUrl'] . '/purchase?type=processing'?>">Редиректы</a></li>
        <li class="<?= ($type == 'buy') ? 'active' : ''?>"><a href="<?= Yii::app()->params['baseUrl'] . '/purchase?type=buy'?>">Софт</a></li>
    </ul>
    <br />
    <div class="panel panel-default">
        <? if(empty($orders) === false):?>
            <table class="table">
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
