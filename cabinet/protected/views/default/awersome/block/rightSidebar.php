<div class="col-sm-3 sidebar well blog-sidebar">
<!--    <br />-->
<!--    <br />-->
<!--    <br />-->
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button"><i class="icon-search"></i></button>
                </span>
    </div>
    <br />
    <div class="row pricing">
        <div class="col-sm-12">
            <div class="product">
                <h2 class="text-info">Активация купона</h2>
                <div class="col-sm-12">
                    <br />
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="codeCoupon" id="codeCoupon" placeholder="Ваш код купона">
                    </div>
                    <? if (empty($this->couponError) === false):?>
                        <div class="alert alert-error fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?= $this->couponError;?>
                        </div>
                    <? endif;?>

                    <? if (empty($this->couponAmount) === false):?>
                        <div class="alert alert-success fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?= $this->couponAmount;?>
                        </div>
                    <? endif;?>
                </div>
                <p class="call-to-action"><button class="btn btn-success" type="submit"><i class="icon-ok"></i> Активировать</button></p>
                </form>
            </div>

            <div class="widget">
                <ul id="myTab" class="nav nav-tabs three-tabs fancy">
                    <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Стоимость услуг</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="home">
                        <ul class="list-group cards">
                            <li class="list-group-item">
                                <p class="pull-right text-error">$0.00</p>
                                <a href="#"><p class="title">Добавление нового сайта</p></a>
                            </li>
                            <li class="list-group-item">
                                <p class="pull-right text-info">$<?= $this->settings['identify_price']->value?></p>
                                <a href="#"><p class="title">Уникальная идентификация пользователя</p></a>
                            </li>
                            <li class="list-group-item">
                                <p class="pull-right text-success">$0.01</p>
                                <a href="#"><p class="title">Рассылка ВК за 1 пользователя (в разработке)</p></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="promotions">
                    </div>
                    <div class="tab-pane fade" id="deals">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
