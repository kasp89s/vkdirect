<div class="row">
    <div class="col-sm-6">
        <h2>Добавить новость</h2>
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
        <? endif;?>
        <form class="form" role="form" method='POST' action=''>
            <div class="form-group">
                <label class="control-label" for="input01">Тип</label>
                <div class="controls">
                    <select name="type" class="form-control">
                        <option value="slider">Слайдер</option>
                        <option value="new">Новость</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="input01">Тема</label>
                <div class="controls">
                    <input type="text" name="title" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Контент</label>
                <div class="controls">
                    <div class="textarea">
                        <textarea  name="content" type="" class="form-control" rows="5"> </textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input class="btn" type="submit" value="Добавить">
            </div>
        </form>
    </div>
</div>
