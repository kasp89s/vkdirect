<div class="row">
    <div class="col-sm-9">
        <h2>Транзакции пополнения</h2>
        <? if(empty($orders) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>ID (свой)</th>
                    <th>ID (интеркасса)</th>
                    <th>Пользователь</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($orders as $item):?>
                    <tr>
                        <? if (empty($item->user)) continue;?>
                        <td><?= $item->id?></td>
                        <td><?= $item->systemId?></td>
                        <td><?= $item->user->username?></td>
                        <td><?= $item->amount?><?= Yii::app()->params['currency']?></td>
                        <td><?= $item->date?></td>
                        <td>
                            <?php
                            switch((int) $item->status) {
                                case 0 : echo 'Не оплачен';
                                    break;
                                case 1 : echo 'Оплачен';
                                    break;
                                case 2 : echo 'Ошибка';
                                    break;
                                default: echo 'Не оплачен';
                                break;
                            }
                            ?>
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
