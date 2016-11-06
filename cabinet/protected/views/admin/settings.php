<div class="main_content">
    <div class="panel panel-default" style="margin-top: 50px;">
        <!-- Default panel contents -->
        <div class="panel-heading">Настройки</div>
        <? if(empty($this->settings) === false):?>
            <form action="" method="post">
                <table class="table">
                    <tr>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>За количество</th>
                    </tr>
                    <? foreach ($this->settings as $key => $item):?>
                        <tr>
                            <td><?= Setting::$translate[$key]?></td>
                            <td><input type="text" class="form-control" name="<?= $key?>[key]" value="<?= $item->key?>" /></td>
                            <td><input type="text" class="form-control" name="<?= $key?>[value]" value="<?= $item->value?>" /></td>
                        </tr>
                    <? endforeach;?>
                    <tr>
                        <td>
                            <input type="submit" class="btn btn-success" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </form>
        <? endif;?>
    </div>
</div>



