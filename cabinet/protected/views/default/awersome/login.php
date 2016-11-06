  
    <div class="login">
    <div class="dialog">
        <p class="brand"><img src="/img/logo_nobg.png" alt="" style="width: 180px"></p>
        <div class="block">
            <div class="block-header">
                <h2>Авторизация</h2>
            </div>
            <? if (empty($error) === false):?>
            <div class="col-sm-12">
                <div class="alert alert-error fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?= $error;?>
                </div>
                </div>
            <? endif;?>
            <form method="post" action="<?= Yii::app()->params['baseUrl'] . '/login'?>">
                <div class="form-group">
                    <label>Логин</label>
                    <input type="text" name="username" class="form-control">
                </div>

                <div class="form-group">
                    <label>Пароль</label>
                    <a class="reset-password pull-right" href="<?= Yii::app()->params['baseUrl'] . '/registration'?>">Регистрация</a>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-actions">
					<input type="submit" class="btn btn-success pull-right" value="Войти"/>
                    <!--You can have a remember me or sign up here-->
                    <!--<label class="remember-me"><input type="checkbox"> Remember me</label>-->
                    <!--<a href="sign-up.html" class="sign-up">Sign Up</a>-->
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>
