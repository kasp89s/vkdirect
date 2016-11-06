<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'kvWyDdQP4J';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<? if ($action == 11) {?>
    <div class="alert alert-success" role="alert">Ваш баланс успешно пополнен! Спасибо!</div>
<? } ?>
<? if ($action == 12) {?>
    <div class="alert alert-warning" role="alert">Извените платеж отменен!</div>
<? } ?>
</br>
<? if ($action < 10) {

//$this->user->balance = 0;

?>
<h4>Оплата через WebMoney</h4>	
<form class="form-inline" role="form" accept-charset='cp1251' method='POST' action='https://merchant.webmoney.ru/lmi/payment.asp'>
 <div class="form-group">
    <div class="input-group">
		<div class="input-group-addon">Сумма</div>
			<input type='text' class="form-control" name='LMI_PAYMENT_AMOUNT' value='10'>
			<input type='hidden' name='LMI_PAYMENT_DESC_BASE64' value='Пополнение счета'>
			<input type='hidden' name='LMI_PAYMENT_NO' value='<?= $this->user->id?>'>
			<input type='hidden' name='LMI_PAYEE_PURSE' value='Z402918174009'>
			<input type='hidden' name='LMI_SIM_MODE' value='0'>
		</div>
    </div>
	<button type="submit" class="btn btn-default">Пополнить</button>
</form>
<br/>
<h4>Другие способы оплаты</h4>
<? if (empty($error) === false) :?>
    <div class="alert alert-warning" role="alert"><?= var_dump($error)?></div>
<? endif;?>
<? if (empty($transaction) === true):?>
    <? if (empty($action) === true):?>
        <form class="form-inline" role="form" action="" method="post" accept-charset="UTF-8">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Сумма</div>
                    <input class="form-control" type="text" name="amount" value="10">
                </div>
            </div>
            <button type="submit" class="btn btn-default">Пополнить</button>
        </form>
    <? else:?>
        <? if ($action == 1):?>
            <div class="alert alert-success" role="alert">Ваш баланс успешно пополнен! Спасибо!</div>
        <? endif;?>
        <? if ($action == 2):?>
            <div class="alert alert-warning" role="alert">Извените платеж отменен!</div>
        <? endif;?>
    <? endif;?>
<? else:?>
    <form class="form-horizontal" role="form" name="payment" method="post" action="<?= Interkassa::PAY_URL?>" accept-charset="UTF-8">
        <div class="form-group">
            <label class="col-sm-2 control-label">Сумма</label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $transaction->amount?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $transaction->description?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                    <input type="hidden" name="ik_co_id" value="<?= Interkassa::SHOP_ID?>" />
                    <input type="hidden" name="ik_pm_no" value="<?= $transaction->id?>" />
                    <input type="hidden" name="ik_am" value="<?= $transaction->amount?>" />
                    <input type="hidden" name="ik_desc" value="<?= $transaction->description?>" />
                    <button type="submit" class="btn btn-default">Оплатить</button>
            </div>
        </div>
		
		
    </form>
	
<? endif;?>

<? }?>

<h3>Пополнение баланса и бонусы за отзывы</h3>
<p><b>1. </b>При пополнении от 25$ <b>  - бонус 2%</b></p>
<p><b>2. </b>При пополнении от 50$ <b>  - бонус 5%</b></p>
<p><b>3. </b>При пополнении от 100$ <b> - бонус 10%</b></p>

<h3>Бонусы пользователям сайта при положительных отзывах о сервисе на следующих ресурсах:</h3>
<p><b>http://exploit.in/forum/index.php?showtopic=83260 Эксплоит - бонус 3$</b></p>
<p><b>http://forum.antichat.ru/thread418285.html Античат - бонус 3$</b></p>
<p><b>http://www.nulled.cc/threads/256467/ Нулед - 3$</b></p>
<p><b>http://blackboxs.biz/showthread.php?t=11008 - Секретный форум)) - 3$</b></p>
<p><b>http://zismo.biz/forum/11-536558-1  - Зисмо - 1$</b></p>
<p><b>http://webmasters.ru/forum/f92/redirekty-ssylok-kartinok-vip-domeny-avtomatom-61371/ - 3$ - Вебмастерс</b></p>

<p><b>Также другие нормальные ресурсы если какие-то упустил</b></p>

<br/>