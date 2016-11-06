<div class="row">
    <div class="col-sm-12">
        <h2>Пополнить счёт</h2>
        <? if ($action == 1) { ?>
            <div class="alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Ваш баланс успешно пополнен! Спасибо!
            </div>
        <? } ?>
        <? if ($action == 2) { ?>
            <div class="alert alert-error fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Извените платеж отменен!
            </div>
        <? } ?>
        </br>

        <form class="form-inline" id="payment-form" role="form" action="" method="post" accept-charset="UTF-8">
        <div class="pricing non-spaced three hidden-xs">
            <div class="popular product">
                <h2 class="text-info">Выбор платежной системы</h2>
                <ul>
                    <li>
                        <img name="imgthumb14" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJcAAAAtCAMAAACUEAlYAAAAb1BMVEX///8AarQAW64AaLMAXq8AVqwAYLAAZrIAVKsAYrEAWK0AZLLq8ffL2+sAUqr7/f7c5vE1dLhfj8W2yuIXcLedtNfx9vrU4O6Ss9dplsgAS6h3nszF1OekvtyduNmtxN9Igb41eruIqtJPh8EARqZYRqAQAAAEU0lEQVRYhe2YaZOjOAyG5YOYw2Cu5ginzf7/37iSkzTJdk/SXTU9ma2KPlApwPJj6ZVsAvCyl73sZcaYZyN8sNZtKgiDyPbVs1GubKlloqKEMcGrnrvm2TwnywspmJDVJMUhBehr/WwibxMXGCg5AnQypxsG2vzZUACOM8aUyhEHGmgY6mvk6ukhmwkrKTQ09YwpFYqnMMd8eTJWS1jR2kBeK15BkaD0G3BPL8oataV6gPRA0k8boYLxC8N+2ehc+VuwZklZdAAD/VABaNE+mNlbxQe86pgoGhXsL4fF+UcqLxodZfJttTJvEsH6iKn6VI4UsJHdbWI6tEQnFV7b2O4P+M51mE+/SvVtrlGewSaATVqPYlbMZJsl9m7ERIIvDwnH6C7cfcol2GkJUnyba0hOXAwlbwZoMC26VixOwYXp3ZF9gEQ1izp0wn2A54Vm57ZZ5tFz1dIrdRaF58qn+eyyXU7vgvav6pziYfKrnmnFmYtlOEazw4btArlwtgeddYpn0HxSKzo5YJOxwSZinEQKLqIA15eGk/Q1UHc2QgoXsiLEuoepziIVS00+6jVcYTz2tK7jsHvnFyzVY5OPBIswaOwrzavlPVRZPkSNOdSooRDDZ5UBjho1GyohzdIywMnbTNfINYY4eYUXE4vWYIwnaEPkrrIZCo6SGeI9Eia4cEXY6QMKnhwgPzeK6q7yI4YqQLdjjqWpOYWmytqTvtJ4IK4xwLj3KxDXxmna4rwMGOM3GAgbig3mANulvCoeHV+4RG3QG8ZNeOoZkbrgrvI32bASgVwVLJByW5blGlYnLo2RSLMRRA0mqzwXo8pFlHzn2hIcUzKGESkp7bvvPV5MrQbLPil8jIYYkXop72ms40uMrqx1YY4batmRtbdcXTguifFc6szVwjvXqvwY7CYlb1x8nR35zsUSzMRssSzwNcmSDTNwV/opr0kRLimYgTy+tIpTHgPnuTC9Gz4gLhvRvBvXe7x6fkEZw6W42SdWtYNFVBVNgT4WjoX56EjdJMojcEUeWeLvmRPXgNVNXNAnoT5xzSEWUxPgwt+5ltA3Xlp9UvObHdklt1x5ohQ2+vm6Zn9lVtJCjOKzn4d183DUECbd1Gc4PD2O1Cw2guYajA3cXGMbNpza7Zi9YVTCfup8oLpI3vhu90T6zVvSLo4aGx/tj2jL4NvkPPh0t4O1dCOfN1vS2nN/39E7jg7mZl4t3TLO+adU9NNWbFRiqIP/BKIQu8BG3+uZONDO3a2PI/b7bMna2xvVe2fFc1cL+iCUoK7iuJfbnzEzhh9OR1fKF4cccumb1pIxFrtPXPyIvf2zflCNlnsmBdPQorgQ3slD+cc+cvPPjghXmcQDmKFDFe5F0H+hIn/WlniPmLK4yeOp5+3ZUGRjoq4iFlFCj+3jYT9vTSnVrjH8/Cj+Ciy0tJQH7PRCCBVJ+/SPtCvT1bCymtl++gv+AnjZy172P7V/AaamQ8wPj0XcAAAAAElFTkSuQmCC" height="45" style="margin-top:0px;margin-right:0px;margin-bottom:0;margin-left:0px" title="webmoney" width="151" alt="webmoney" align="middle" border="0" >
                        <br />
                        <label>WMZ <input type="radio" name="system" value="<?= Interkassa::WM_SYSTEM?>" checked="" /></label> <br/>
                        <label>WMR (курс: <?= $currencyCash['USD_RUR']?>)<input type="radio" name="system" value="<?= Interkassa::WM_SYSTEM_RUR?>" /></label> <br/>
                        <label>WMU (курс: <?= $currencyCash['USD_UAH']?>)<input type="radio" name="system" value="<?= Interkassa::WM_SYSTEM_UAH?>" /></label> <br/>
                    </li>
                    <li>
                        <img src="https://support.interkassa.com/logo_interkassa.jpg" width="151">
                        <br />
                        <label>
                        RUR (курс: <?= $currencyCash['USD_RUR']?>)
                        <input type="radio" name="system" value="<?= Interkassa::INTERKASSA_SYSTEM_RUR?>" />
                        </label>
                        <br />
                        <label>
                        UAH (курс: <?= $currencyCash['USD_UAH']?>)
                        <input type="radio" name="system" value="<?= Interkassa::INTERKASSA_SYSTEM_UAH?>" />
                        </label>
                    </li>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <div class="input-group">
                                <span class="input-group-addon">Сумма</span>
                                <input class="form-control" type="text" name="amount" value="10">
                            </div>
                        </div>
                    </li>
                </ul>
                <p class="call-to-action"><button type="button" id="payment-form-submit" class="btn btn-success"><i class="icon-ok"></i> Оплатить</button></p>
            </div>
            <div style="clear: both;"></div><!--Leave this here-->
            <div style="height: 2em"></div><!--Remove me when you choose a table-->
        </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h3>Пополнение баланса и бонусы за отзывы</h3>
        <ol>
            <li>При пополнении от 25$ <b> - бонус 2%</b></li>
            <li>При пополнении от 50$ <b> - бонус 5%</b></li>
            <li>При пополнении от 100$ <b> - бонус 10%</b></li>
        </ol>
    </div>
</div>

<? if (empty($error) === false) : ?>
    <div class="alert alert-warning" role="alert"><?= var_dump($error) ?></div>
<? endif; ?>
<script type="text/javascript">
    var currencyCash = {
        USD_RUR: '<?= $currencyCash['USD_RUR']?>',
        USD_UAH: '<?= $currencyCash['USD_UAH']?>'
    }

    $('#payment-form-submit').click(
        function(){
            var system = $('input[name="system"]:checked').val();
            var payAmount = $('input[name="amount"]').val();
            var submit = true;
            if (system == '1.1' || system == '2.1') {
                var amount = parseFloat(payAmount) / parseFloat(currencyCash.USD_RUR);
                submit = confirm('Вам будет начислено ' + parseFloat(amount).toFixed(2) + '$');
            }
            if (system == '1.2' || system == '2.2') {
                var amount = parseFloat(payAmount) / parseFloat(currencyCash.USD_UAH);
                submit = confirm('Вам будет начислено ' + parseFloat(amount).toFixed(2) + '$');
            }

            if(submit) $('#payment-form').submit();
        }
    );
</script>
