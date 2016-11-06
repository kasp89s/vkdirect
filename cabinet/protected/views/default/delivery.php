<style>
    .modal-dialog {
        width: 800px;
        margin: 30px auto;
    }
</style>

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
        <li class="active"><a href="<?= Yii::app()->params['baseUrl'] . '/delivery'?>" class="btn btn-default">Сделать рассылку</a></li>
        <li><a href="<?= Yii::app()->params['baseUrl'] . '/parser'?>" class="btn btn-default">Заказать парсинг</a></li>
    </ul>
    <br />
    <a class="btn btn-success" href="<?= Yii::app()->params['baseUrl'] . '/createDelivery'?>" >Создать</a>
    <br />
    <br />
    <div class="panel panel-default">
        <? if (empty($delivery) === false):?>
            <table class="table">
                <tr>
                    <th>Название</th>
                    <th>Контрольная почта</th>
                    <th>Письмо</th>
                    <th>Количество писем</th>
                    <th>Цена рассылки</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                <? foreach ($delivery as $item):?>
                    <tr>
                        <td><?= $item->title?></td>
                        <td><?= $item->email?></td>
                        <td><a href="javascript:loadDeliveryBody(<?= $item->id?>)">Показать</a></td>
                        <td><?= $item->count?></td>
                        <td><?= Delivery::calculateDeliveryPrice($item->count, $this->settings, $item->file);?></td>
                        <td><?= Delivery::$statusTranslate[$item->status]?></td>
                        <td><?= $item->date?></td>
                        <td>
                            <? if ($item->status == Delivery::STATUS_NEW):?>
                                <a href="<?= Yii::app()->params['baseUrl'] . '/refactorDelivery/' . $item->id?>">Изменить</a><br />
                                <a href="javascript:if (confirm('Точно удалить?'))removeDelivery(<?= $item->id?>);">Удалить</a><br />
                                <a href="javascript:if (confirm('Точно запустить?'))runDelivery(<?= $item->id?>);">Запустить</a>
                            <? endif;?>
							<? if ($item->status == Delivery::STATUS_ERROR):?>
							    <a href="<?= Yii::app()->params['baseUrl'] . '/refactorDelivery/' . $item->id?>">Изменить</a><br />
							<? endif;?>
							<?= $item->status?>
                        </td>
                    </tr>
                <? endforeach;?>
            </table>
        <? endif;?>
    </div>
</div>
<input type="button" data-toggle="modal" id="open-body" data-target="#load-body" value="" style="display: none;">
<div class="modal fade" id="load-body" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Тело письма</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
