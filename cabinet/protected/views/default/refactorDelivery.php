<script src="//cdn.ckeditor.com/4.4.6/standard/ckeditor.js"></script>
<h3>Изменить рассылку</h3>
<div class="main_content">
    <div class="error-area">
        <? if (empty($errors) === false) :?>
            <div class="alert alert-warning" role="alert">
                <? foreach ($errors as $key => $error):?>
                    <?= $error?> <br />
                <? endforeach;?>
            </div>
        <? endif;?>
        <? if (empty($save) === false) :?>
            <div class="alert alert-success" role="alert">
                Сохранено!
            </div>
        <? endif;?>
    </div>
    <br />
    <div class="panel panel-default">
        <form role="form" id="delivery-form" action="" method="post" style="margin: 5px;" enctype="multipart/form-data">
            <div class="form-group amount">
                <table class="table">
                    <tr>
                        <th>Адресов загружено</th>
                        <th>Стоимость рассылки без воложения</th>
                        <th>Стоимость рассылки с воложением</th>
                    </tr>
                    <tr>
                        <td id="emailCountInfo"><?= $delivery->count?></td>
                        <td id="deliveryPrice"><?= Delivery::calculateDeliveryPrice($delivery->count, $this->settings, null)?>$</td>
                        <td id="deliveryMacrosPrice"><?= Delivery::calculateDeliveryPrice($delivery->count, $this->settings, true)?>$</td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <table class="table">
                    <tr>
                        <td>
                            <input type="file"  id="senderBase" name="senderBase" style="display: none;" onchange="fileUpload('senderBase');"/>
                            <a class="btn btn-success" id="senderBase-upload" href="javascript:fileSelect('senderBase');" ><span>Загружена база</span> отправителей</a>
                        </td>
                        <td>
<!--                            <input type="file"  id="titleBase" name="titleBase" style="display: none;" onchange="fileUpload('titleBase');"/>-->
<!--                            <a class="btn --><?//= ($delivery->titleBase != '') ? 'btn-success' : 'btn-primary'?><!--" id="titleBase-upload" href="javascript:fileSelect('titleBase');"><span>--><?//= ($delivery->titleBase != '') ? 'Загружена база' : 'Загрузить темы'?><!--</span> рассылки</a>-->
                            <input type="hidden"  id="titleBase" name="titleBase" onchange="" value="<?= isset($macros['title1']) ? $macros['title1'] : '' ?>"/>
                            <a class="btn <?= isset($macros['title1']) ? 'btn-success' : 'btn-primary' ?>" id="titleBase-upload" data-toggle="modal" data-target="#add-title"><span><?= isset($macros['title1']) ? 'Загружена база' : 'Загрузить темы' ?></span> рассылки</a>
                        </td>
                        <td>
                            <input type="file"  id="emailBase" name="emailBase" style="display: none;" onchange="fileUpload('emailBase');"/>
                            <a class="btn btn-success" id="emailBase-upload" href="javascript:fileSelect('emailBase');"><span>Загружена база</span> получателей</a>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="senderBaseLink" id="senderBaseLink" value="<?= $delivery->senderBase?>"/>
                <input type="hidden" name="titleBaseLink" id="titleBaseLink" value="<?= $delivery->titleBase?>"/>
                <input type="hidden" name="emailBaseLink" id="emailBaseLink" value="<?= $delivery->emailBase?>"/>
                <input type="hidden" name="emailCount" id="emailCount" value="<?= $delivery->count?>"/>
            </div>
            <div class="form-group">
                <label for="email">Контрольная почта</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $delivery->email?>"/>
            </div>
            <div class="form-group">
                <label for="title">Тема</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $delivery->title?>"/>
            </div>
            <div class="form-group">
                HTML: <input type="radio" name="type" value="html" class="checker" <?= ($delivery->type == 'html') ? 'checked' : ''?>/>
                TEXT: <input type="radio" name="type" value="text" class="checker" <?= ($delivery->type == 'text') ? 'checked' : ''?>/>
            </div>
            <div class="form-group editor" id="html-editor" <?= ($delivery->type == 'text') ? 'style="display: none;"' : ''?>>
                <label for="body_html">Текст письма (<a href="javascript:fileSelect('loadBody');">Загрузить из файла</a>)</label>
                <input type="file"  id="loadBody" name="loadBody" style="display: none;" onchange="fileUpload('loadBody');"/>
                <textarea class="form-control" id="body_html" rows="5" name="body_html"><?= ($delivery->type == 'html') ? file_get_contents($delivery->body) : ''?></textarea>
            </div>
            <div class="form-group editor" id="text-editor" <?= ($delivery->type == 'html') ? 'style="display: none;"' : ''?>>
                <label for="body_text">Текст письма</label>
                <textarea class="form-control" id="body_text" rows="8" name="body_text"><?= ($delivery->type == 'text') ? file_get_contents($delivery->body) : ''?></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">Файл рассылки (добавить/заменить)</label>
                <input type="file"  id="attachment" name="attachment" />
            </div>
            <div class="form-group">
                <label for="url">Макросы</label>
                <table>
                    <tr>
                        <td>
                            <textarea class="form-control" id="macros-list" rows="8" name="macrosList" style="width: 200px;">
<? if (empty($macros) === false):?>
<? foreach($macros as $name => $item):?>
<? if ($name == 'title1') continue;?>
<?= "%$name% \n"?>
<? endforeach;?>
<? endif;?>
</textarea>
                        </td>
                        <td style="vertical-align: bottom; padding-left: 10px;">
                            <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-macros" value="Добавить" >
                        </td>
                    </tr>
                </table>
            </div>
            <div id="macros-area" style="display: none !important;">
                <? if (empty($macros) === false):?>
                    <? foreach($macros as $name => $text):?>
                        <? if ($name == 'title1') continue;?>
                        <textarea name="macros[<?= $name?>]"><?= $text?></textarea>
                    <? endforeach;?>
                <? endif;?>
            </div>
            <div class="form-group">
                <input type="button" id="delivery-submit" class="btn btn-success" value="Сохранить рассылку" />
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="add-macros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Новый макрос</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="macros-name">Имя</label>
                    <input type="text" class="form-control" id="macros-name" />
                </div>
                <div class="form-group">
                    <label for="url">Текст</label>
                    <textarea class="form-control" id="macros-text" rows="8" ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save-macros" data-dismiss="modal">Создать</button>
            </div>
        </div>
    </div>
</div>

<!-- add title base -->
<div class="modal fade" id="add-title" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">База тем для рассылки</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="url">Список тем</label>
                    <textarea class="form-control" id="title-text" rows="8" ><?= isset($macros['title1']) ? $macros['title1'] : '' ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save-title" data-dismiss="modal">Добавить</button>
            </div>
        </div>
    </div>
</div>
<!-- add title base -->

<script>
    var delivery = {
        nonMacros: {
            price: <?= $this->settings['deliveryPrice']->key?>,
            countOnPrice: <?= $this->settings['deliveryPrice']->value?>
        },
        macros: {
            price: <?= $this->settings['deliveryMacrosPrice']->key?>,
            countOnPrice:<?= $this->settings['deliveryMacrosPrice']->value?>
        }

    };

    $('.checker').on('change',
        function () {
            var type = $(this).val();

            $('.editor').hide();
            $('#' + type + '-editor').show();
        }
    );
    $('.save-macros').on('click',
        function(){
            var name = $('#macros-name').val();
            var text = $('#macros-text').val();
            var list = $('#macros-list').val();

            $('#macros-name').val('');
            $('#macros-text').val('');
            $('#macros-area').append('<textarea name="macros[' + name + ']">' + text + '</textarea>');
            $('#macros-list').val(list + '%' + name + '%' + "\n");
        }
    );
    $('.save-title').on('click',
        function(){
            var text = $('#title-text').val();
            if (text != null && text != ''){
                $('#titleBase').val(text);
                $('#titleBase-upload').removeClass('btn-primary');
                $('#titleBase-upload').addClass('btn-success');
                $('#titleBase-upload').find('span').text('Загружена база');
            } else {
                $('#titleBase').val('');
                $('#titleBase-upload').addClass('btn-primary');
                $('#titleBase-upload').removeClass('btn-success');
                $('#titleBase-upload').find('span').text('Загрузить базу');
            }

        }
    );
    CKEDITOR.replace('body_html');
    //CKEDITOR.appendTo('html-editor');
</script>
