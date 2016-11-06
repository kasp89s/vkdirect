<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'kvWyDdQP4J';
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<h3>Выбрать и купить</h3>
<div class="main_content">
    <ul class="nav nav-pills">
        <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=processing'?>" class="btn btn-default">Редиректы</a></li>
        <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=buy'?>" class="btn btn-default">Софт</a></li>
        <li><a href="<?= Yii::app()->params['baseUrl'] . '/delivery'?>" class="btn btn-default">Сделать рассылку</a></li>
        <li class="active"><a href="<?= Yii::app()->params['baseUrl'] . '/parser'?>" class="btn btn-default">Заказать парсинг</a></li>
    </ul>
    <br />
    <a class="btn btn-success" href="<?= Yii::app()->params['baseUrl'] . '/createPurchase'?>" >Создать</a>
    <br />
    <br />
    <div class="panel panel-default">
        <? if(empty($models) === false):?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Регион</th>
                    <th width="55px">Возраст</th>
                    <th width="55px">Пол</th>
                    <th width="55px">Онлайн</th>
                    <th width="55px">Цена</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                <? foreach ($models as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->region ?></td>
                        <td><?= $item->from?> - <?= $item->to?></td>
                        <td><?= Purchase::$sex[$item->sex] ?></td>
                        <td><?= Purchase::$online[$item->online] ?></td>
                        <td><?= $item->price ?> <?= Yii::app()->params['currency']?></td>
                        <td><?= $item->date ?></td>
                        <td><?= Purchase::$status[$item->status] ?></td>

                        <td>
                            <? if ($item->status == Purchase::STATUS_NEW):?>
                                <a href="<?= Yii::app()->params['baseUrl'] . '/refactorPurchase/' . $item->id?>">Изменить</a><br />
                                <a href="javascript:if (confirm('Точно удалить?'))removePurchase(<?= $item->id?>);">Удалить</a><br />
                                <a href="javascript:if (confirm('Точно запустить?'))runPurchase(<?= $item->id?>);">Запустить</a>
                            <? endif;?>
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
