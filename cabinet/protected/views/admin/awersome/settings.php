<div class="row">
    <div class="col-sm-9">
        <h2>Настройки</h2>
        <? if(empty($this->settings) === false):?>
            <form action="" method="post">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>За количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($this->settings as $key => $item):?>
                        <tr>
                            <td><?= Setting::$translate[$key]?></td>
                            <td><input type="text" class="form-control" name="<?= $key?>[key]" value="<?= $item->key?>" /></td>
                            <td><input type="text" class="form-control" name="<?= $key?>[value]" value="<?= $item->value?>" /></td>
                        </tr>
                    <? endforeach;?>
                    </tbody>
                </table>
                <input type="submit" class="btn btn-success" value="Сохранить" />
            </form>
        <? endif;?>
    </div>
</div>




