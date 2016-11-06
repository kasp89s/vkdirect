<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="<?= Yii::app()->params['baseUrl'] . '/admin'?>"><?= $this->title?></a>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= Yii::app()->params['baseUrl']?>">Привет <?= $this->user->name?> (ваш баланс - <?= $this->user->balance?><?= Yii::app()->params['currency']?>)</a></li>
                <li><a href="<?= Yii::app()->params['baseUrl'] . '/default/logout'?>">Выход <span class="glyphicon glyphicon-log-out"></span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div><!-- /.container-fluid -->
</nav>
