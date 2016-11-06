<style>
    .table td {
        border: none;
    }
</style>
<div class="row">
    <div class="col-sm-9">
        <h2>Активируйте новый сайт</h2>
        <div class="error-area">
            <? if (empty($errors) === false) :?>
                <div class="alert alert-warning" role="alert">
                    <? var_dump($errors)?>
                </div>
            <? endif;?>
        </div>
        <form role="form" action="" method="post" style="margin: 5px;" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Адресс сайта</label>
                <input type="text" class="form-control" value="<?= $model->url?>"/>
            </div>
            <div class="form-group">
                <label for="email">Вставьте код Witget на Ваш сайт перед тегом <?= htmlspecialchars('</body>')?></label>
                <textarea class="form-control" id="script-text" style="height: 300px"><?= UserSite::getUserScript($this->user->id);?></textarea>
            </div>
            <div class="form-group">
                <input type="button" class="btn activate-site btn-success" value="Активировать" />
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.activate-site').on('click',
        function(){
            $.post(
                '/cabinet/default/activateSite',
                {id: '<?= $model->id?>', script: $('#script-text').val()},
                function (data)
                {
                    if (data.error == 0) {
                        location.href = '/cabinet';
                    } else {
						alert(data.error);
						if (confirm('Я уверен в наличии кода на сайте!')) {
							$.post('/cabinet/default/activateSite', {id: '<?= $model->id?>', force: 1}, function(data){location.href = '/cabinet';});
						}
                    }
                },
                'json'
            );
        }
    );
</script>
