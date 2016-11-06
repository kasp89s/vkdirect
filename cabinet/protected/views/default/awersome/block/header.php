<div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-reorder"></span>
          </button>
          <a class="navbar-brand" href="/" style="padding-top: 0px"><img src="/img/logo_nobg.png" alt="" style="width: 120px"></a>
        </div>
        
        <div class="hidden-xs">
                <ul class="nav navbar-nav pull-right">
                    
                    <!-- <li class="hidden-phone"><a href="#" role="button">Settings</a></li> -->
                    <li id="fat-menu" class="dropdown">
                        <a href="<?= Yii::app()->params['baseUrl']?>" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?= $this->user->name?> (ваш баланс - <?= $this->user->balance?><?= Yii::app()->params['currency']?>)
							<i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?= Yii::app()->params['baseUrl']?>">Мой аккаунт</a></li>
							<?php if ($this->user->role == 1):?>
							    <li class="divider visible-phone"></li>
								<li><a tabindex="-1" href="<?= Yii::app()->params['baseUrl'] . '/admin'?>">Админ панель</a></li>
							<?php endif?>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="<?= Yii::app()->params['baseUrl'] . '/default/logout'?>">Выход</a></li>
                        </ul>
                    </li>
                    
                </ul>
        </div><!--/.navbar-collapse -->
    </div>
