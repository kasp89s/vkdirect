<div class="main_content">
    <? if (empty($errors) === false) :?>
        <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
    <? endif;?>
    <h3>Редактировать новость:</h3>
    <!--    <div class="panel panel-default">-->
    <form class="form" role="form" method='POST' action=''>
	    <div class="form-group">
            <select name="type" class="form-control">
				<option value="slider" <?= ($new->type == 'slider') ? 'selected' : ''?>>Слайдер</option>
				<option value="new" <?= ($new->type == 'new') ? 'selected' : ''?>>Новость</option>
			</select>
        </div>
        <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Тема" value="<?= $new->title?>"/>
        </div>
        <div class="form-group">
            <textarea name="content" style="width: 100%; height: 100px;" placeholder="Контент"><?= $new->content?></textarea>
            <div class="input-group">
                <input class="btn" type="submit" value="Coхранить">
            </div>
        </div>
    </form>
    <!--    </div>-->
</div>
