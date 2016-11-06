<div class="row">
    <div class="col-sm-9">
        <? if($this->user->balance < 1):?>
            <div class="alert fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Внимание!</strong> На Вашем счету мало средств, <a href="<?= Yii::app()->params['baseUrl'] . '/balance'?>">пополните</a> пожалуйста Вас счёт, что бы избедать приостановки услуг.
            </div>
        <? endif;?>
        <h2>База идентификаций</h2>
        <? if(empty($identify) === false):?>
            <div class="form-group">
                <!-- Select Basic -->
                <label class="control-label">Статистика по сайту</label>
                <div class="controls">
                    <table>
                    <tr>
                        <td>
                            <select class="form-control" id="site-id">
                                <? foreach ($sites as $item):?>
                                    <option value="<?= $item->id?>" <? if($item->id == $default->id):?>selected=""<?endif;?>><?= $item->url?></option>
                                <? endforeach;?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-success" onclick="javascript: location.href='/cabinet/default/statistics/' + $('#site-id').val();">Выбрать</button>
                        </td>
                    </tr>
                    </table>
                </div>

            </div>
        <table class="table table-first-column-number" style="overflow: visible;">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Профиль Вконтакте</th>
                <th>Город</th>
                <th>Пол</th>
                <th>Сайт</th>
                <th>Посещений</th>
                <th>Дата последнего</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($identify as $item):?>
                <tr>
                    <td><img src="<?= $item->photo_50?>" width="35" height="35"></td>
                    <td>
                        <div class="btn-group">
                            <a href="http://vk.com/<?= $item->domain?>" class="btn" target="_blank"><?= $item->vkname?> <?= $item->lname?></a>
                            <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="http://vk.com/<?= $item->domain?>" target="_blank">vk.com/<?= $item->domain?></a></li>
                                <li><a href="http://vk.com/im?sel=<?= $item->vkid?>" target="_blank">Послать сообщение</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><?= $item->citytxt?></td>
                    <td><?= ($item->sex == 2) ? 'М' : 'Ж';?></td>
                    <td><?= $item->site->url?></td>
                    <td><span class="badge badge-info"><?= $item->count?></span></td>
                    <td><?= $item->time?></td>
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
