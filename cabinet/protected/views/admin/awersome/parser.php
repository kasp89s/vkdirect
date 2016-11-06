<div class="row">
    <div class="col-sm-9">
        <h2>Парсинг mail.ru</h2>
        <a class="btn btn-primary" href="<?= Yii::app()->params['baseUrl'] . '/createPurchase'?>" >Создать</a>
        <br />
        <br />
        <? if(empty($models) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <th>#</th>
                <th>Юзер</th>
                <th>Регион</th>
                <th width="55px">Возраст</th>
                <th width="55px">Пол</th>
                <th width="55px">Онлайн</th>
                <th width="55px">Цена</th>
                <th>Дата</th>
                <th>Статус</th>
                <th></th>
                </thead>
                <tbody>
                <? foreach ($models as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->user->username?></td>
                        <td><?= $item->region ?></td>
                        <td><?= $item->from?> - <?= $item->to?></td>
                        <td><?= Purchase::$sex[$item->sex] ?></td>
                        <td><?= Purchase::$online[$item->online] ?></td>
                        <td><?= $item->price ?> <?= Yii::app()->params['currency']?></td>
                        <td><?= $item->date ?></td>
                        <td>
                            <span id="state-<?= $item->id?>" class="state"><?= Purchase::$status[$item->status]?></span><br />
                            <a href="javascript:void(0)" id="change-state-<?= $item->id?>" class="change-state" data-id="<?= $item->id?>" data-state="<?= $item->status?>">[изменить]</a>
                            <select id="state-selector-<?= $item->id?>" class="state-selector" data-id="<?= $item->id?>" style="display: none;">
                                <? foreach(Purchase::$status as $key => $value):?>
                                    <option value="<?= $key?>" <?= ($item->status == $key) ? 'selected' : ''?>><?= $value?></option>
                                <? endforeach;?>
                            </select>
                        </td>

                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/refactorPurchase/' . $item->id?>">Изменить</a><br />
                            <a href="javascript:if (confirm('Точно удалить?'))removePurchase(<?= $item->id?>);">Удалить</a><br />
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

<script type="text/javascript">
    $('.change-state').click(
        function(){
            $('#state-' + $(this).data('id')).hide();
            $('.state-selector').hide();
            $('#state-selector-' + $(this).data('id')).show();
            $(this).hide();
        }
    );
    $('.state-selector').change(
        function() {
            var element = $(this);
            $.post(
                '/cabinet/default/changeStatePurchase',
                {id: element.data('id'), status: element.val()},
                function (data)
                {
                    if(data.status != null){
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
