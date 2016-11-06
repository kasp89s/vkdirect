<div class="row-fluid login">
    <div class="dialog">
        <p class="brand">Redirekt center.</p>
        <div class="block">
            <div class="block-header">
                <h2>Авторизация</h2>
            </div>
			<form>
            <? if (empty($error) === false):?>
                <div class="col-sm-12">
                    <div class="alert alert-error fade in">
                            <?= $error;?> <br />
                    </div>
                </div>
            <? endif;?>
			<? if (empty($success) === false):?>
				<div class="alert alert-success" role="alert">
					Спасибо Ваша учетная запись активирована.
				</div>
				<div class="form-actions">
					<a href="/cabinet/login" class="btn btn-success pull-right" >Войти</a>
                    <!--You can have a remember me or sign up here-->
                    <!--<label class="remember-me"><input type="checkbox"> Remember me</label>-->
                    <!--<a href="sign-up.html" class="sign-up">Sign Up</a>-->
                    <div class="clearfix"></div>
                </div>
   			<? endif;?>
		    </form>
        </div>
    </div>
</div>