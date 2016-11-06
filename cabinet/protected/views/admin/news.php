<div class="main_content">
    <a href="<?= Yii::app()->params['baseUrl'] . '/admin/addNew'?>" class="btn btn-success">Добавить</a>
    <h3>Новости:</h3>
    <div class="panel panel-default">
    <? if (empty($news) === false):?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Тема</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th></th>
                </tr>
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
            </table>
    <? endif;?>
    </div>
</div>
