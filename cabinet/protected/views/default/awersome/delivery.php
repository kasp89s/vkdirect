<style>
    .modal-dialog {
        width: 800px;
        margin: 30px auto;
    }
</style>

<div class="row">
    <div class="navbar-collapse collapse">
        <div id="main-menu">

            <ul class="nav nav-tabs hidden-xs">
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=processing'?>"><i class="icon-dashboard"></i> <span>Редиректы</span></a></li>
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=buy'?>" ><i class="icon-bar-chart"></i> <span>Софт</span></a></li>
                <li class="active"><a href="<?= Yii::app()->params['baseUrl'] . '/delivery'?>" ><i class="icon-cogs"></i> <span>Сделать рассылку</span></a></li>
                <li ><a href="<?= Yii::app()->params['baseUrl'] . '/parser'?>"><i class="icon-magic"></i> <span>Заказать парсинг</span></a></li>
            </ul>

        </div>
    </div>
    <div class="col-sm-9">
        <br />
        <a class="btn btn-success" href="<?= Yii::app()->params['baseUrl'] . '/createDelivery'?>" >Создать</a>
        <br />
        <? if (empty($delivery) === false):?>
            <h2>Мои рассылки</h2>
            <table class="table table-first-column-number">
                <thead>
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
                </thead>
                <tbody>
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
                            <? if ($item->status == Delivery::STATUS_ERROR):?>
                                <a href="<?= Yii::app()->params['baseUrl'] . '/refactorDelivery/' . $item->id?>">Изменить</a><br />
<!--                                <a href="javascript:if (confirm('Точно удалить?'))removeDelivery(--><?//= $item->id?><!--);">Удалить</a><br />-->
                                <a href="javascript:if (confirm('Точно запустить?'))runDelivery(<?= $item->id?>);">Запустить</a>
                            <? endif;?>
                        </td>
                    </tr>
                <? endforeach;?>
                </tbody>
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
