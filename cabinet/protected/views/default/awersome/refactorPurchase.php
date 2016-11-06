<div class="row">
    <div class="col-sm-9">
        <h2>Редактирование заказа</h2>
        <div class="error-area">
            <? if (empty($errors) === false) :?>
                <div class="alert alert-warning" role="alert">
                    <? foreach ($errors as $key => $error):?>
                        <?= $error?> <br />
                    <? endforeach;?>
                </div>
            <? endif;?>
        </div>
        <? if (empty($save) === false) :?>
            <div class="alert alert-success" role="alert">
                Сохранено!
            </div>
        <? endif;?>

        <form role="form" action="" method="post" id="purchase-form" style="margin: 5px; padding: 5px;" >
            <div class="form-group">
                <label for="sex">Пол</label>
                <select name="sex" class="form-control" style="width: 150px;">
                    <option value="all" <?= ($purchase->sex == 'all') ? 'selected' : ''?>>Любой</option>
                    <option value="male" <?= ($purchase->sex == 'male') ? 'selected' : ''?>>Мужской</option>
                    <option value="female" <?= ($purchase->sex == 'female') ? 'selected' : ''?>>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">Возраст</label>
                <table>
                    <tr>
                        <td>
                            <div class="input-group">
                                <input class="form-control" type="text" name="age[from]" style="width: 126px;" value="<?= $purchase->from?>">
                                <div class="input-group-addon">от</div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">до</div>
                                <input class="form-control" type="text" name="age[to]" style="width: 126px;" value="<?= $purchase->to?>">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <label for="online">Только "онлайн" пользователи</label>
                <br />
                Да <input name="online" type="radio" value="1" <?= ($purchase->online == 1) ? 'checked' : ''?>>
                Нет <input name="online" type="radio" value="0" <?= ($purchase->online == 0) ? 'checked' : ''?>>
            </div>
            <div class="form-group">
                <label for="region">Регион</label>
                <select name="region" class="form-control">
                    <? foreach(Purchase::getRegionList() as $item):?>
                        <?php
                        $region = explode(';', $item);
                        $name = $region[1];
                        ?>
                        <option value="<?= str_replace("\n", '', $item)?>" <?= ($purchase->region == str_replace("\n", '', $item)) ? 'selected' : ''?>><?= $name?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="count">Количество адресов</label>
                <table>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">от 1000</div>
                                <input class="form-control" type="text" name="count" id="count" style="width: 126px;" value="<?= $purchase->count?>">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">цена $</div>
                                <input class="form-control" type="text" name="price" id="price" style="width: 126px;" readonly="true" value="<?= $purchase->price?>">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <input type="button" class="btn btn-success" id="purchase-submit" value="Изменить" />
            </div>
        </form>

    </div>
</div>


<script type="text/javascript">
    var price1000 = <?= $this->settings['purchasePrice']->key?>;

    $('#count').change(
        function(){
            var count = $('#count');
            if(parseInt(count.val()) < 1000) {
                count.val(1000);
            }

            var amount = parseInt(count.val() / 1000);
            if (amount * 1000 < parseInt(count.val())) {
                amount+=1;
            }
            $('#price').val(amount * price1000);
        }
    );
    $('#purchase-submit').click(
        function () {
            var formData = $('#purchase-form').serialize();
            $.ajax({
                url: '/cabinet/default/validatePurchase/',
                type: 'post',
                data: formData,
                dataType: "json",
                success: function (result)
                {
                    if(result.errors === false) {
                        $('#purchase-form').submit();
                    } else {
                        $('.error-area').html(result.render);
                        $('body,html').animate({scrollTop: 0}, 500);
                    }
                }
            });
        }
    );
</script>
