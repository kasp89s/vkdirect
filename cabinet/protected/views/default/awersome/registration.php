<script type="text/javascript">
    $(document).ready(function(){
        var error_email=1;
        var error_name=1;
        var error_login=1;
        var error_pass=1;

//$("#validate").keyup(function(){
        $("#validate").bind('change click keyup', function(){
            var email = $("#validate").val();
            if(email != 0) {
                if(isValidEmailAddress(email)) {
                    $("#validEmail").css({ "background-image": "url('img/validyes.png')" });
                    error_email=0;
                } else {
                    $("#validEmail").css({ "background-image": "url('img/validno.png')" });
                    error_email=1;
                }
            } else {
                $("#validEmail").css({ "background-image": "none" });
            }
        });

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        }

        $("#name").bind('change click keyup', function(){
            var name = $("#name").val();
            if(name != 0) {
                $("#name").val(name.replace(/[^\w]/ig,""));
                if(name.length < 3) {
                    $("#valid_name").css({ "background-image": "url('img/validno.png')" });
                    error_name=1;
                } else {
                    $("#valid_name").css({ "background-image": "url('img/validyes.png')" });
                    error_name=0;
                }
            } else {
                $("#valid_name").css({ "background-image": "none" });
            }
        });

        $("#login").bind('change click keyup', function(){
            var login = $("#login").val();
            if(login != 0) {
                if(login.length < 3) {
                    $("#valid_login").css({ "background-image": "url('img/validno.png')" });
                    error_login=1;
                } else {
                    $("#valid_login").css({ "background-image": "url('img/validyes.png')" });
                    error_login=0;
                }
            } else {
                $("#valid_login").css({ "background-image": "none" });
            }
        });

        $("#pass").bind('change click keyup', function(){
            var pass = $("#pass").val();
            //$("#len").text(pass.length);
            if(pass != 0) {
                if(pass.length < 6) {
                    $("#valid_pass").css({ "background-image": "url('img/validno.png')" });
                    error_pass=1;
                } else {
                    $("#valid_pass").css({ "background-image": "url('img/validyes.png')" });
                    error_pass=0;
                }
            } else {
                $("#valid_pass").css({ "background-image": "none" });
            }

        });

        $("#check_before_send").click(function(){
            if(error_name == 1) {
                alert('Укажите поле "Имя" !');
                $("#valid_name").css({ "background-image": "url('img/validno.png')" });
            }
            if(error_email == 1 || $('input[name=email]').val() == '') {
                alert('Укажите валидный email !');
                $("#validEmail").css({ "background-image": "url('img/validno.png')" })
            }
            if(error_login == 1) {
                alert('Укажите поле "Логин" !');
                $("#valid_login").css({ "background-image": "url('img/validno.png')" });
            }
            if(error_pass == 1) {
                alert('Пароль должен быть больше 6 символов !');
                $("#valid_pass").css({ "background-image": "url('img/validno.png')" });
            }
            if(error_name == 0 & (error_email == 0 & $('input[name=email]').val() != '') & (error_login == 0 & $('input[name=login]').val() != '') & error_pass == 0) {
                $('#form-signin').trigger("submit");
            }
        });


    });
</script>

<div class="row-fluid login">
    <div class="dialog">
        <p class="brand"><img src="/img/logo_nobg.png" alt="" style="width: 180px"></p>
        <div class="block">
            <div class="block-header">
                <h2>Регистрация</h2>
            </div>
            <? if (empty($errors) === false):?>
                <div class="col-sm-12">
                    <div class="alert alert-error fade in">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <? foreach ($errors as $error):?>
                            <?= $error[0];?> <br />
                        <? endforeach;?>
                    </div>
                </div>
            <? endif;?>
			<? if (empty($success) === false):?>
			<form>
				<div class="alert alert-success" role="alert">
					Спасибо за регистрацию. Для активации Вашей учетной записе перейдите по ссылке в письме отправленом на почту указаную при регистрации.
				</div>
			</form>
			<?else:?>
            <form method="post" action="">
                <div class="form-group">
                    <label>Имя</label>
                    <input name="name" id="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>e-mail</label>
                    <input type="text" name="email" id="validate" class="form-control">
                </div>
                <div class="form-group">
                    <label>Логин</label>
                    <input type="text" name="username" id="login" class="form-control">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" id="pass" class="form-control">
                </div>
				<div class="form-group">
                    <label>Skype</label>
                    <input type="text" name="skype" id="skype" class="form-control">
                </div>
				<div class="form-group">
                    <label>Icq</label>
                    <input type="text" name="icq" id="icq" class="form-control">
                </div>
                <div class="form-actions">
					<input type="submit" class="btn btn-success pull-right" value="Регистрация"/>
                    <div class="clearfix"></div>
                </div>
            </form>
			<? endif;?>
        </div>
    </div>
</div>
