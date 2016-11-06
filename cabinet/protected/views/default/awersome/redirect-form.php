<? if(empty($system) === false):?>
    <? if($system == 'webmoney'):?>
        <form id="payment_redirect_form" role="form" accept-charset='cp1251' method='POST' action='https://merchant.webmoney.ru/lmi/payment.asp'>
                    <input type='hidden' class="form-control" name='LMI_PAYMENT_AMOUNT' value='<?= $transaction->payAmount?>'>
                    <input type='hidden' name='LMI_PAYMENT_DESC_BASE64' value='<?= $transaction->description ?>'>
                    <input type='hidden' name='LMI_PAYMENT_NO' value='<?= $transaction->id ?>'>
                    <input type='hidden' name='LMI_PAYEE_PURSE' value='<?= $settings['keeper'] ?>'>
                    <input type='hidden' name='LMI_SIM_MODE' value='0'>
        </form>
    <? endif;?>
    <? if($system == 'interkassa'):?>
        <form id="payment_redirect_form" role="form" name="payment" method="post" action="<?= Interkassa::PAY_URL ?>" accept-charset="UTF-8">
                    <input type="hidden" name="ik_co_id" value="<?= $settings['shopId'] ?>"/>
                    <input type="hidden" name="ik_pm_no" value="<?= $transaction->id ?>"/>
                    <input type="hidden" name="ik_am" value="<?= $transaction->payAmount ?>"/>
                    <input type="hidden" name="ik_desc" value="<?= $transaction->description ?>"/>
        </form>
    <? endif;?>
    <script type="text/javascript">
        document.getElementById("payment_redirect_form").submit();
    </script>
<? endif;?>
