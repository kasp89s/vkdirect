<style>
    .modal-dialog {
        width: 800px;
        margin: 30px auto;
    }
</style>
<div class="row">
    <div class="col-sm-9">
        <h2>Рассылки</h2>
        <? if (empty($delivery) === false): ?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Пользователь</th>
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
                <? foreach ($delivery as $item): ?>
                    <tr>
                        <td><?= $item->id ?></td>
                        <td><?= $item->user->username ?></td>
                        <td><?= $item->email ?></td>
                        <td><a href="javascript:loadDeliveryBody(<?= $item->id ?>)">Показать</a></td>
                        <td><?= $item->count ?></td>
                        <td><?= Delivery::calculateDeliveryPrice($item->count, $this->settings, $item->file); ?></td>
                        <td>
                            <span id="state-<?= $item->id ?>"
                                  class="state"><?= Delivery::$statusTranslate[$item->status] ?></span><br/>
                            <a href="javascript:void(0)" id="change-state-<?= $item->id ?>" class="change-state"
                               data-id="<?= $item->id ?>" data-state="<?= $item->status ?>">[изменить]</a>
                            <select id="state-selector-<?= $item->id ?>" class="state-selector"
                                    data-id="<?= $item->id ?>" style="display: none;">
                                <? foreach (Delivery::$statusTranslate as $key => $value): ?>
                                    <option
                                        value="<?= $key ?>" <?= ($item->status == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                        <td><?= $item->date ?></td>
                        <td>
                            <a href="<?= Yii::app(
                            )->params['baseUrl'] . '/refactorDelivery/' . $item->id ?>">Изменить</a><br/>
                            <a href="javascript:if (confirm('Точно удалить?'))removeDelivery(<?= $item->id ?>);">Удалить</a><br/>
                        </td>
                    </tr>
                <? endforeach; ?>
                <tbody>
            </table>
        <? endif; ?>
    </div>
</div>

<input type="button" data-toggle="modal" id="open-body" data-target="#load-body" value="" style="display: none;">
<div class="modal fade" id="load-body" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
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
<script type="text/javascript">
    $('.change-state').click(
        function () {
            $('#state-' + $(this).data('id')).hide();
            $('.state-selector').hide();
            $('#state-selector-' + $(this).data('id')).show();
            $(this).hide();
        }
    );
    $('.state-selector').change(
        function () {
            var element = $(this);
            $.post(
                '/cabinet/default/changeState',
                {id: element.data('id'), status: element.val()},
                function (data) {
                    if (data.status != null) {
                        $('#state-' + element.data('id')).text(data.status);
                        $('#state-' + element.data('id')).show();
                        $('#change-state-' + element.data('id')).show();
                        element.hide();
                    }
                },
                'json'
            );
        }
    );
</script>
