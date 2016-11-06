<h3>Редактировать пользователя</h3>
<? if (empty($errors) === false) :?>
    <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
<? endif;?>
<? if (empty($save) === false) :?>
    <div class="alert alert-success" role="alert">Запись сохранена!</div>
<? endif;?>
<div class="main_content">
    <form role="form" action="" method="post">
        <div class="form-group">
            <label for="role">Роль</label>
            <select name="role" id="role" class="form-control">
                <option value="0" <?= ($model->role == 0) ? 'selected' : ''?>>user</option>
                <option value="1" <?= ($model->role == 1) ? 'selected' : ''?>>admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="username">Логин</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $model->username?>"/>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= $model->email?>"/>
        </div>
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $model->name?>"/>
        </div>
        <div class="form-group">
            <label for="skype">Skype</label>
            <input type="text" class="form-control" id="skype" name="skype" value="<?= $model->skype?>"/>
        </div>
        <div class="form-group">
            <label for="icq">icq</label>
            <input type="text" class="form-control" id="icq" name="icq" value="<?= $model->icq?>"/>
        </div>
        <div class="form-group">
            <label for="balance">Баланс</label>
            <input type="text" class="form-control" id="balance" name="balance" value="<?= $model->balance?>"/>
        </div>

        <button type="submit" class="btn btn-default">Сохранить</button>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/user'?>" >Назад</a>
    </form>

</div>
