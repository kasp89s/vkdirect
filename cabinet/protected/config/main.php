<?php

// This is the main Web application configuration. Any writable
// application properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'GuruAdult',
    'defaultController' => 'default',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
	),

	// application components
	'components'=> array(
        'user'=>array(
            'loginUrl'=>array('default/login'),
        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=mz226779.mysql.ukraine.com.ua;dbname=mz226779_db',
            'emulatePrepare' => true,
            'username' => 'mz226779_db',
            'password' => 'jqnt3fpu',
            'charset' => 'utf8'
        ),
        'request' => array('enableCsrfValidation' => false),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(
                'registration'=>'default/registration',
                'login'=>'default/login',
                'confirm'=>'default/confirm',
                'list'=>'default/index',
                'purchase'=>'default/purchase',
                'news'=>'default/news',
                'help'=>'default/help',
                'balance'=>'default/balance',
                'statistics'=>'default/statistics',
                'referrals'=>'default/referrals',
                'questions'=>'default/questions',
                'refill/<id:\d+>'=>'default/refill',
                'changeLink/<id:\d+>'=>'default/changeLink',
                'messageList/<id:\d+>'=>'default/messageList',

                // Спамер
                'delivery'=>'default/delivery',
                'parser'=>'default/parser',
                'createDelivery'=>'default/createDelivery',
                'refactorDelivery/<id:\d+>'=>'default/refactorDelivery',
                'createPurchase'=>'default/createPurchase',
                'refactorPurchase/<id:\d+>'=>'default/refactorPurchase',

                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            ),
        ),
        'clientScript'=>array(
            //'scriptMap'=>array(
            //    'jquery.min.js'=>'/js/jquery-1.8.3.min.js',
            //    'main.js'=>'/js/main.js',
             //   'pie.js'=>'/js/pie.js',
            //),
		'packages' => array(
			'awersome' => array(
				'baseUrl' => '/cabinet/awersome/',
				'js' => array(
                    'js/jquery-1.7.2.min.js',
					'js/bootstrap.js',
					'js/site.js',
					'js/main.js',
				),
				'css' => array(
				    'css/bootstrap.css',
				    'css/font-awesome.css',
				    'css/theme.css',
				),
			),
        )
        ),
	),
    'params' => array(
        'cacheDuration' => 1,
        'useCache' => false,
        'currency' => '$',
        'baseUrl' => 'http://' . $_SERVER['HTTP_HOST'] . '/cabinet',
    ),

);
