<div class="main_content">
    <? if (empty($errors) === false) :?>
        <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
    <? endif;?>
    <h3>Добавить новость:</h3>
<!--    <div class="panel panel-default">-->
        <form class="form" role="form" method='POST' action=''>
            <div class="form-group">
                <select name="type" class="form-control">
					<option value="slider">Слайдер</option>
					<option value="new">Новость</option>
				</select>
            </div>
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Тема"/>
            </div>
            <div class="form-group">
                <textarea name="content" style="width: 100%; height: 100px;" placeholder="Контент"></textarea>
                <div class="input-group">
                    <input class="btn" type="submit" value="Добавить">
                </div>
            </div>
        </form>
<!--    </div>-->
</div>
