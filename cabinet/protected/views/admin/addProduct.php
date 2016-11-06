<h3>Добавить товар</h3>
<? if (empty($errors) === false) :?>
    <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
<? endif;?>
<div class="main_content">
    <form role="form" action="" method="post">
        <div class="form-group">
            <label for="type">Тип товара</label>
            <select name="type" id="type" class="form-control">
                <option value="buy">покупка</option>
                <option value="processing">обработка</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" />
        </div>
        <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" class="form-control" id="price" name="price" />
        </div>
        <div class="form-group">
            <label for="countPrice">Количество по цене</label>
            <input type="text" class="form-control" id="countPrice" name="countPrice" />
        </div>
        <div class="form-group">
            <label for="productUrl">Ссылка на продукт</label>
            <input type="text" class="form-control" id="productUrl" name="productUrl" />
        </div>
        <div class="form-group">
            <label for="url">Ссылка загрузки (если тип товара "buy")</label>
            <input type="text" class="form-control" id="url" name="url" />
        </div>
        <div class="form-group">
            <label for="url">Ключи продукта (если тип товара "buy")</label>
            <textarea class="form-control" rows="3" name="keys"></textarea>
        </div>
        <div class="form-group">
            <label for="url">Описание</label>
            <textarea class="form-control" rows="3" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="productUrl">Число порядка</label>
            <input type="text" class="form-control" id="sort" name="sort" />
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="status"> в наличии
            </label>
        </div>
        <button type="submit" class="btn btn-default">Добавить</button>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin'?>" >Назад</a>
    </form>

</div>
