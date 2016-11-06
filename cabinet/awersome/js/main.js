/**
 * Created with JetBrains PhpStorm.
 * User: turbo
 * Date: 22.09.14
 * Time: 11:25
 * To change this template use File | Settings | File Templates.
 */
$('.by-processing').click(
    function () {
        var elementId = $(this).attr('id');

        var pID = $('#' + elementId + '-id').val();
        var count = $('#' + elementId + '-count').val();
        var url = $('#' + elementId + '-url').val();
        var generate = $('#generate-' + elementId + '-url').is(":checked");

        if (pID == '' || count == '' || url == '') return;

        $.post(
            '/cabinet/default/byProcessing',
            {id: pID, count: count, url:url, generate: generate},
            function (data)
            {
                if (data.error == 0) {
                    alert('Спасибо за покупку Ваш номер заказа - ' + data.id);
                    location.href = '/cabinet/purchase';
                } else {
                    alert(data.error);
                }
            },
            'json'
        );
    }
);
$('.site-url').change(
    function() {
        var id = $(this).attr('id');
        if ($(this).val() == '') {
            $('#generate-' + id).attr('disabled', true);
        } else {
            $('#generate-' + id).attr('disabled', false);
        }
    }
);

$('.generate-link').change(
    function() {
        var action = $(this).is(":checked");

        var url = $('#' + $(this).data('id'));

        if(url.val() != null && url.val() != '') {
            $.post(
                '/cabinet/default/generateLink',
                {url: url.val(), action: action},
                function (data)
                {
                    if (data.link != null) {
                        url.val(data.link);
                    } else {
                        alert(data.error);
                    }
                },
                'json'
            );
        }
    }
);

$('.status-selector').change(
    function () {
        var elementId = $(this).attr('data-id');
        var value = $(this).val();

        $.post(
            '/cabinet/admin/selectStatusOrder',
            {id: elementId, value: value}
        );
    }
);
$('#delivery-submit').click(
    function () {
        $('#body_html').val(CKEDITOR.instances['body_html'].getData());
        var formData = $('#delivery-form').serialize();
        $.ajax({
            url: '/cabinet/default/validateDelivery/',
            type: 'post',
            data: formData,
            dataType: "json",
            success: function (result)
            {
                if(result.errors === false) {
                    $('#delivery-form').submit();
                } else {
                    $('.error-area').html(result.render);
                    $('body,html').animate({scrollTop: 0}, 500);
                }
            }
        });
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

function removePurchase(id)
{
    $.ajax({
        url: '/cabinet/default/removePurchase/',
        type: 'post',
        data: {id: id},
        dataType: "json",
        success: function (result)
        {
            if (result.remove != null && result.remove == 1) location.reload();
        }
    });
}

function runPurchase(id)
{
    $.ajax({
        url: '/cabinet/default/runPurchase/',
        type: 'post',
        data: {id: id},
        dataType: "json",
        success: function (result)
        {
            if (result.run != null && result.run == 1) location.reload();

            if (result.not_enough_money == 1) {
                alert('У Вас не достаточно денег! Цена ' + result.amount + '$')
            }
        }
    });
}

function removeDelivery(id)
{
    $.ajax({
        url: '/cabinet/default/removeDelivery/',
        type: 'post',
        data: {id: id},
        dataType: "json",
        success: function (result)
        {
            if (result.remove != null && result.remove == 1) location.reload();
        }
    });
}

function runDelivery(id)
{
    $.ajax({
        url: '/cabinet/default/runDelivery/',
        type: 'post',
        data: {id: id},
        dataType: "json",
        success: function (result)
        {
            if (result.run != null && result.run == 1) location.reload();

            if (result.not_enough_money == 1) {
                alert('У Вас не достаточно денег! Цена рассылки ' + result.amount + '$')
            }
        }
    });
}

function loadDeliveryBody(deliveryId)
{
    $.ajax({
        url: '/cabinet/default/loadDeliveryBody/',
        type: 'post',
        data: {deliveryId: deliveryId},
        dataType: "json",
        success: function (result)
        {
            if(result.body != null) {
                $('.modal-body').html(result.body);
                $('#open-body').trigger('click');
            } else {
                alert('Вы пытаетесь сделать хрень!');
            }
        }
    });
}

function fileSelect(id) {
    if ($('#' + id + 'Link').val() == null || $('#' + id + 'Link').val() == '') {
        $('#' + id).trigger('click');
    } else {
        if (confirm('Удалить загруженый файл?')){
            $('#' + id + 'Link').val('');
            $('#' + id).replaceWith($('#' + id).val('').clone(true));
            if (id == 'emailBase') {
                $('.amount').hide();
            }

            $('#' + id + '-upload').addClass('btn-primary');
            $('#' + id + '-upload').removeClass('btn-success');
            $('#' + id + '-upload').find('span').text('Загрузить базу');
        }
    }
}

function fileUpload(name)
{
    var formData = new FormData;
    $.each($('#' + name)[0].files, function (i, file){
        formData.append(name, file);
    });

    $.ajax({
        url: '/cabinet/default/uploader/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (result)
        {
            if (result.file != null) {
                updateDelivery(result, name);
            }

            if (result.body != null) {
                updateEditor(result);
            }
        }
    });
}

function updateEditor(result) {
    CKEDITOR.instances['body_html'].setData(result.body);
}

function updateDelivery(result, name) {
    if (result.file != null) {
        $('#' + name + 'Link').val(result.file);
        $('#' + name + '-upload').removeClass('btn-primary');
        $('#' + name + '-upload').addClass('btn-success');
        $('#' + name + '-upload').find('span').text('Загружена база');
    }

    if (result.info != null) {
        $('#emailCountInfo').text(result.info);
        $('#emailCount').val(result.info);
        var amount = parseInt(parseInt(result.info) / parseInt(delivery.nonMacros.countOnPrice));
        if (amount < 1) {
            amount = 1;
        } else {
            if (amount != parseInt(result.info) / parseInt(delivery.nonMacros.countOnPrice)) {
                amount+= 1;
            }
        }

        var macrosAmount = parseInt(parseInt(result.info) / parseInt(delivery.macros.countOnPrice));
        if (macrosAmount < 1) {
            macrosAmount = 1;
        } else {
            if (macrosAmount != parseInt(result.info) / parseInt(delivery.macros.countOnPrice)) {
                macrosAmount+= 1;
            }
        }


        $('#deliveryPrice').text(parseInt(delivery.nonMacros.price) * macrosAmount + '$');
        $('#deliveryMacrosPrice').text(parseInt(delivery.macros.price) * macrosAmount + '$');
        $('.amount').show();
    }
}
