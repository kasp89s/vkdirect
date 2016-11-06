<div class="row">
    <div class="col-sm-6">
        <h2>Редактировать новость</h2>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <form class="form" role="form" method='POST' action=''>
            <div class="form-group">
                <label class="control-label" for="input01">Тип</label>
                <div class="controls">
                    <select name="type" class="form-control">
                        <option value="slider" <?= ($new->type == 'slider') ? 'selected' : ''?>>Слайдер</option>
                        <option value="new" <?= ($new->type == 'new') ? 'selected' : ''?>>Новость</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="input01">Тема</label>
                <div class="controls">
                    <input type="text" name="title" class="form-control" value="<?= $new->title?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Контент</label>
                <div class="controls">
                    <div class="textarea">
                        <textarea  name="content" type="" class="form-control" rows="5"><?= $new->content?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input class="btn" type="submit" value="Coхранить">
            </div>
        </form>
    </div>
</div>
