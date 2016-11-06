<script src="//cdn.ckeditor.com/4.4.6/standard/ckeditor.js"></script>
<style>
    .table td {
        border: none;
    }
</style>
<div class="row">
    <div class="col-sm-9">
        <h2>Создать рассылку</h2>
        <div class="error-area">
            <? if (empty($errors) === false) :?>
                <div class="alert alert-warning" role="alert">
                    <? foreach ($errors as $key => $error):?>
                        <?= $error?> <br />
                    <? endforeach;?>
                </div>
            <? endif;?>
        </div>
        <form role="form" id="delivery-form" action="" method="post" style="margin: 5px;" enctype="multipart/form-data">
            <div class="form-group amount" style="display: none">
                <table class="table" style="border: none;">
                    <tr>
                        <th>Адресов загружено</th>
                        <th>Стоимость рассылки без воложения</th>
                        <th>Стоимость рассылки с воложением</th>
                    </tr>
                    <tr>
                        <td id="emailCountInfo"></td>
                        <td id="deliveryPrice"></td>
                        <td id="deliveryMacrosPrice"></td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <table class="table" style="border: none;">
                    <tr>
                        <td>
                            <input type="file"  id="senderBase" name="senderBase" style="display: none;" onchange="fileUpload('senderBase');"/>
                            <a class="btn btn-primary" id="senderBase-upload" href="javascript:fileSelect('senderBase');" ><span>Загрузить базу</span> отправителей</a>
                            <br />
                            Генерировать <input type="checkbox" name="generateSender" value="1" onclick="javascript: if($(this).is(':checked')){$('#generateDomain').show()} else {$('#generateDomain').hide()}"/>
                            <br />
                            <input type="text" id="generateDomain" name="generateDomain" value="" style="display: none" placeholder="@domain.com"/>
                        </td>
                        <td>
                            <input type="hidden"  id="titleBase" name="titleBase" onchange=""/>
                            <a class="btn btn-primary" id="titleBase-upload" data-toggle="modal" data-target="#add-title"><span>Загрузить темы</span> рассылки</a>
                        </td>
                        <td>
                            <input type="file"  id="emailBase" name="emailBase" style="display: none;" onchange="fileUpload('emailBase');"/>
                            <a class="btn btn-primary" id="emailBase-upload" href="javascript:fileSelect('emailBase');"><span>Загрузить базу</span> получателей</a>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="senderBaseLink" id="senderBaseLink" />
                <input type="hidden" name="titleBaseLink" id="titleBaseLink" />
                <input type="hidden" name="emailBaseLink" id="emailBaseLink" />
                <input type="hidden" name="emailCount" id="emailCount" />
            </div>
            <div class="form-group">
                <label for="email">Контрольная почта</label>
                <input type="text" class="form-control" id="email" name="email" />
            </div>
            <div class="form-group">
                <label for="title">Тема</label>
                <input type="text" class="form-control" id="title" name="title" />
            </div>
            <div class="form-group">
                HTML: <input type="radio" name="type" value="html" checked="true" class="checker" /> TEXT: <input type="radio" name="type" value="text" class="checker"/>
            </div>
            <div class="form-group editor" id="html-editor">
                <label for="body_html">Текст письма (<a href="javascript:fileSelect('loadBody');">Загрузить из файла</a>)</label>
                <input type="file"  id="loadBody" name="loadBody" style="display: none;" onchange="fileUpload('loadBody');"/>
                <textarea class="form-control" id="body_html" rows="5" name="body_html"></textarea>
            </div>
            <div class="form-group editor" id="text-editor" style="display: none;">
                <label for="body_text">Текст письма</label>
                <textarea class="form-control" id="body_text" rows="8" name="body_text"></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">Файл рассылки</label>
                <input type="file"  id="attachment" name="attachment" />
            </div>
            <div class="form-group">
                <label for="url">Макросы</label>
                <table>
                    <tr>
                        <td>
                            <textarea class="form-control" id="macros-list" rows="8" name="macrosList" style="width: 200px;"></textarea>
                        </td>
                        <td style="vertical-align: bottom; padding-left: 10px;">
                            <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-macros" value="Добавить" >
                        </td>
                    </tr>
                </table>
            </div>
            <div id="macros-area" style="display: none !important;"></div>
            <div class="form-group">
                <input type="button" id="delivery-submit" class="btn btn-success" value="Создать рассылку" />
            </div>
        </form>

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
                            <textarea class="form-control" id="title-text" rows="8" ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save-title" data-dismiss="modal">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- add title base -->
    </div>
</div>
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
