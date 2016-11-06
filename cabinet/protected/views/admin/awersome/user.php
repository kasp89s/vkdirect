<div class="row">
    <div class="col-sm-9">
        <h2>Пользователи</h2>
        <center>
            <form  role="form" action="" method="get">
                <table>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">id</div>
                                <input class="form-control" type="text" name="id" style="width: 126px;">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">логин</div>
                                <input class="form-control" type="text" name="username" style="width: 126px;">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">email</div>
                                <input class="form-control" type="text" name="email" style="width: 126px;">
                            </div>
                        </td>
                        <td><button type="submit" class="btn btn-default">Найти</button></td>
                    </tr>
                </table>
            </form>
        </center>

        <? if(empty($users) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Почта</th>
                    <th>Имя</th>
                    <th>Скайп</th>
                    <th>Ася</th>
                    <th>Баланс</th>
                    <th>Роль</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($users as $item):?>
                    <tr>
                        <td><?= $item->id?></td>
                        <td><?= $item->username?></td>
                        <td><?= $item->email?></td>
                        <td><?= $item->name?></td>
                        <td><?= $item->skype?></td>
                        <td><?= $item->icq?></td>
                        <td><?= $item->balance?></td>
                        <td><?= ($item->role == 0) ? 'user' : 'admin' ?></td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/edituser/' . $item->id?>" class="btn btn-primary btn-xs">Редактировать</a>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/deleteuser/' . $item->id?>" class="btn btn-danger btn-xs">Удалить</a>
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
