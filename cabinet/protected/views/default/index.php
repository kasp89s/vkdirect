            <h3>Выбрать и купить</h3>
            <div class="main_content">
                <ul class="nav nav-pills">
                    <li class="<?= ($type == 'processing') ? 'active' : ''?>"><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=processing'?>" class="btn btn-default">Редиректы</a></li>
                    <li class="<?= ($type == 'buy') ? 'active' : ''?>"><a href="<?= Yii::app()->params['baseUrl'] . '/list?type=buy'?>" class="btn btn-default">Софт</a></li>
                    <li><a href="<?= Yii::app()->params['baseUrl'] . '/delivery'?>" class="btn btn-default">Сделать рассылку</a></li>
                    <!--<li><a class="btn btn-default" href="<?= Yii::app()->params['baseUrl'] . '/parser'?>">Заказать парсинг</a></li>-->
                </ul>
                <br />
                <div class="panel panel-default">
                <a style="float: right; display: block" href="<?= Yii::app()->params['baseUrl'] . '/default/addsite'?>" class="btn btn-success">Добавить</a>
                <? if(empty($products) === false):?>
                <table class="table">
                    <? if ($type == 'processing'):?>
                    <tr>
                        <th>#</th>
                        <th>Тип заказа</th>
                        <th width="55px">Количество</th>
                        <th>Ссылка</th>
                        <th></th>
                    </tr>
                    <? else:?>
                        <tr>
                            <th>#</th>
                            <th>Тип заказа</th>
                            <th width="55px">Цена</th>
                            <th></th>
                        </tr>
                    <? endif;?>
                    <? if ($type == 'processing'):?>
                        <? foreach ($products as $product):?>
                        <tr>
                            <td><?= $product->id?></td>
                            <td>
                                <?= $product->title?><br />
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#product_description_<?= $product->id?>">Подробнее</button>
                            </td>
                            <td><input class="form-control input-sm site-url" id="buy-<?= $product->id?>-count" type="text" placeholder="">
                                <input type="hidden" id="buy-<?= $product->id?>-id" value="<?= $product->id?>" />
                            </td>
                            <td>
                                <input class="form-control input-sm site-url" id="buy-<?= $product->id?>-url" type="text" placeholder="http://">
                                <span class="open-buy-<?= $product->id?>-url">Генерировать ссылку <input type="checkbox" class="generate-link" data-id="buy-<?= $product->id?>-url" id="generate-buy-<?= $product->id?>-url" disabled=""/></span>
                            </td>
                            <td><button type="button" id="buy-<?= $product->id?>" class="btn btn-default btn-xs by-processing">Купить</button></td>
                        </tr>
                        <? endforeach;?>
                    <? else:?>
                        <? foreach ($products as $product):?>
                            <tr>
                                <td><?= $product->id?></td>
                                <td>
                                    <?= $product->title?><br />
                                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#product_description_<?= $product->id?>">Подробнее</button>
                                </td>
                                <td><?= $product->price?><?= Yii::app()->params['currency']?></td>
                                <td><a href="<?= Yii::app()->params['baseUrl'] . '/default/buySoft/' . $product->id?>" class="btn btn-default btn-xs">Купить</a></td>
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
            <!-- Modals -->
            <? if(empty($products) === false):?>
                <? foreach ($products as $product):?>
                    <div class="modal fade" id="product_description_<?= $product->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?= $product->title?></h4>
                                </div>
                                <div class="modal-body">
                                    <? if ($product->type == 'processing'):?>
                                        <p>Цена: <?= $product->price?> <?= Yii::app()->params['currency']?></p>
                                        <p>Количество по цене: <?= $product->countPrice?></p>
                                        <hr>
                                        <h4>Описание</h4>
                                    <? endif;?>
                                    <p><?= $product->description?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <? endforeach;?>
            <? endif;?>
