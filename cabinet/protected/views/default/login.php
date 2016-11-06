<style type="text/css">
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        margin-bottom: 10px;
    }
    .form-signin label {
        font-weight: normal;
    }
    .error {
        color: #b94a48;
    }

    .form-signin {
        background-color: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        margin: 0 auto 20px;
        max-width: 400px;
        padding: 19px 29px 29px;
    }
</style>

<div class="container">
    <form class="form-signin" method="post" action="<?= Yii::app()->params['baseUrl'] . '/login'?>" id="form-signin">
        <h2 class="form-signin-heading">Авторизация</h2>
        <? if (empty($error) === false):?>
            <center><span style="color: #ac2925"> <?= $error;?></span></center>
        <? endif;?>
        <div class="control-group">
            <label class="control-label" for="login">Логин:</label>
            <div class="controls">
                <input size="50" name="username" id="login" value="" type="text" class="form-control" placeholder="Login">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password">Пароль:</label>
            <div class="controls">
                <input size="50" name="password" id="password" value="" type="password" class="form-control" placeholder="Password">
            </div>
        </div>
        <button  name="submit" id="submit" value="" type="submit" class="btn btn-large btn-success btn-block">Войти</button>
        <a href="<?= Yii::app()->params['baseUrl'] . '/registration'?>" class="btn btn-large btn-primary btn-block">Регистрация</a>
    </form>
</div>
