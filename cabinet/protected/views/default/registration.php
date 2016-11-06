<? if (empty($errors) === false):?>
    <?php var_dump($errors); ?>
<? endif;?>
<? if (empty($success) === false):?>
	<div class="alert alert-success" role="alert">
		Спасибо за регистрацию. Для активации Вашей учетной записе перейдите по ссылке в письме отправленом на почту указаную при регистрации.
	</div>
<? endif;?>
<style type="text/css">
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        background-color: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        margin: 0 auto 20px;
        max-width: 600px;
        padding: 19px 29px 29px;
    }

    .form-control {
        width: 95%;
        display: inline;
    }

</style>


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




<div class="container">
    <form class="form-signin" method="post" action="" id="form-signin">
        <h2 class="form-signin-heading">Регистрация</h2>
        <div class="control-group">
            <label class="control-label" for="name">Имя:</label>
            <div class="controls">
                <input size="50" name="name" id="name" type="text" class="form-control" placeholder="Ваше имя">
                <span id="valid_name">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="email">e-mail:</label>
            <div class="controls">
                <input size="40" name="email" id="validate" type="text" class="form-control" placeholder="e-mail">
                <span id="validEmail">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="username">Логин:</label>
            <div class="controls">
                <input size="50" name="username" id="login" type="text" class="form-control" placeholder="Login">
                <span id="valid_login">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="pass">Пароль:</label>
            <div class="controls">
                <input size="50" name="password" id="pass" type="password" class="form-control" placeholder="Password">
                <span id="valid_pass">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="skype">Skype:</label>
            <div class="controls">
                <input size="50" name="skype" id="skype" type="text" class="form-control">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="icq">icq:</label>
            <div class="controls">
                <input size="50" name="icq" id="icq" type="text" class="form-control">
            </div>
        </div><br />
        <button type="button" class="btn btn-large btn-warning btn-block" id="check_before_send">Регистрация</button><br />
        <a href="<?= Yii::app()->params['baseUrl']?>">Вернутся назад</a>
    </form>
</div>
