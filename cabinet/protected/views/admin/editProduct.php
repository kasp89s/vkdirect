<h3>Редактировать товар</h3>
<? if (empty($errors) === false) :?>
    <div class="alert alert-warning" role="alert"><?= var_dump($errors)?></div>
<? endif;?>
<? if (empty($save) === false) :?>
    <div class="alert alert-success" role="alert">Запись сохранена!</div>
<? endif;?>
<div class="main_content">
    <form role="form" action="" method="post">
        <div class="form-group">
            <label for="type">Тип товара</label>
            <select name="type" id="type" class="form-control">
                <option value="buy" <?= ($product->type == 'buy') ? 'selected' : ''?>>покупка</option>
                <option value="processing" <?= ($product->type == 'processing') ? 'selected' : ''?>>обработка</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $product->title?>"/>
        </div>
        <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= $product->price?>"/>
        </div>
        <div class="form-group">
            <label for="countPrice">Количество по цене</label>
            <input type="text" class="form-control" id="countPrice" name="countPrice" value="<?= $product->countPrice?>"/>
        </div>
        <div class="form-group">
            <label for="productUrl">Ссылка на продукт</label>
            <input type="text" class="form-control" id="productUrl" name="productUrl" value="<?= $product->productUrl?>"/>
        </div>
        <div class="form-group">
            <label for="url">Ссылка загрузки (если тип товара "buy")</label>
            <input type="text" class="form-control" id="url" name="url" value="<?= $product->url?>"/>
        </div>
        <div class="form-group">
            <label for="url">Ключи продукта (если тип товара "buy")</label>
            <textarea class="form-control" rows="3" name="keys"><?php
            $keys = array();
            foreach ($product->keys as $pKey) {
                $keys[] = $pKey->code;
            }
            echo implode(',', $keys);
            ?></textarea>
        </div>
        <div class="form-group">
            <label for="url">Описание</label>
            <textarea class="form-control" rows="3" name="description"><?= $product->description?></textarea>
        </div>
        <div class="form-group">
            <label for="productUrl">Число порядка</label>
            <input type="text" class="form-control" id="sort" name="sort" value="<?= $product->sort?>"/>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="status" <?= ($product->status == 1) ? 'checked' : ''?>> в наличии
            </label>
        </div>
        <button type="submit" class="btn btn-default">Сохранить</button>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin'?>" >Назад</a>
    </form>

</div>
