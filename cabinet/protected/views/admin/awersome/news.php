<div class="row">
    <div class="col-sm-9">
        <h2>Новости</h2>
        <a href="<?= Yii::app()->params['baseUrl'] . '/admin/addNew'?>" class="btn btn-success">Добавить</a>
        <br />
        <br />
        <? if (empty($news) === false):?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Тема</th>
                        <th>Дата</th>
                        <th>Тип</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <? foreach ($news as $key => $item):?>
                    <tr>
                        <td>
                            <?= $key + 1?>
                        </td>
                        <td>
                            <?= $item->title;?>
                        </td>
                        <td>
                            <?= $item->date;?>
                        </td>
                        <td>
                            <?= $item->type;?>
                        </td>
                        <td>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/editNew/' . $item->id?>" >Редактировать</a>
                            <a href="<?= Yii::app()->params['baseUrl'] . '/admin/editNew/'  . $item->id . '?remove=true'?>" >Удалить</a>
                        </td>
                    </tr>
                <? endforeach;?>
                </tbody>
            </table>
        <? endif;?>
    </div>
</div>
