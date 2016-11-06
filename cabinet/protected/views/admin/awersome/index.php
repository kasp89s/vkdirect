<div class="row">
    <div class="col-sm-12">
        <h2>Товары</h2>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/addproduct'?>" class="btn btn-success">Добавить</a>
        <br />
        <br />
        <? if(empty($products) === false):?>
            <table class="table table-first-column-number">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Порядок</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество по цене</th>
                    <th>Описание</th>
                    <th>Ссылка</th>
                    <th>Тип</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($products as $product):?>
                    <tr>
                        <td><?= $product->id?></td>
                        <td><?= $product->sort?></td>
                        <td><?= $product->title?></td>
                        <td><?= $product->price?></td>
                        <td><?= $product->countPrice?></td>
                        <td><?= $product->description?></td>
                        <td><?= $product->url?></td>
                        <td><?= $product->type?></td>
                        <td><?= $product->status?></td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/editproduct/' . $product->id?>" class="btn btn-primary btn-xs">Редактировать</a>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/deleteproduct/' . $product->id?>" class="btn btn-danger btn-xs">Удалить</a>
                        </td>
                    </tr>
                <? endforeach;?>
                <tbody>
            </table>
        <? endif;?>
    <? $this->widget('CLinkPager', array(
            'pages' => $pages,
            'selectedPageCssClass' => 'active',
            'header' => '',
            'htmlOptions' => array(
                'class' => 'pagination'
            )
        ))?>
</div>
</div>
