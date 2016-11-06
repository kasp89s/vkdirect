<div class="row">
    <div class="navbar-collapse collapse">
        <div id="main-menu">

            <ul class="nav nav-tabs hidden-xs">
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=processing'?>"><i class="icon-dashboard"></i> <span>Редиректы</span></a></li>
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=buy'?>" ><i class="icon-bar-chart"></i> <span>Софт</span></a></li>
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/delivery'?>" ><i class="icon-cogs"></i> <span>Сделать рассылку</span></a></li>
                <li class="active"><a href="<?= Yii::app()->params['baseUrl'] . '/parser'?>"><i class="icon-magic"></i> <span>Заказать парсинг</span></a></li>
            </ul>

        </div>
    </div>
    <div class="col-sm-12">
        <br />
            <a class="btn btn-success" href="<?= Yii::app()->params['baseUrl'] . '/createPurchase'?>" >Создать</a>
        <br />
        <br />

        <? if(empty($models) === false):?>
        <table class="table table-first-column-number">
            <thead>
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
            </thead>
            <tbody>
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
            </tbody>
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
