<?php

class AdminController extends CController
{
    public $title = 'Админпанель';

    public $user = false;
    public $settings = array();

    /**
     * Лейаут по умолчанию, в отличии от оффициальной документации.
     *
     * @var string
     */
    public $layout = '//layouts/admin';

    public $theme = '';

    public $menu = array(
        '/admin/settings' => array('class' => '', 'title' => 'Настройки', 'icon' => 'icon-gears'),
        '/admin' => array('class' => '', 'title' => 'Товары', 'icon' => 'icon-dropbox'),
        '/admin/orders' => array('class' => '', 'title' => 'Заказы', 'icon' => 'icon-suitcase'),
        '/admin/delivery' => array('class' => '', 'title' => 'Заказы рассылка', 'icon' => 'icon-envelope'),
        '/admin/parser' => array('class' => '', 'title' => 'Заказы парсер', 'icon' => 'icon-magic'),
        '/admin/refillOrders' => array('class' => '', 'title' => 'Пополнения пользователей', 'icon' => 'icon-money'),
        '/admin/user' => array('class' => '', 'title' => 'Пользователи', 'icon' => 'icon-user'),
        '/admin/coupon' => array('class' => '', 'title' => 'Купоны', 'icon' => 'icon-copy'),
        '/admin/softCode' => array('class' => '', 'title' => 'Ключи софта', 'icon' => 'icon-save'),
        '/admin/statistics' => array('class' => '', 'title' => 'Статистика', 'icon' => 'icon-signal'),
        '/admin/refill' => array('class' => '', 'title' => 'Бонусы пополнения', 'icon' => 'icon-ticket'),
        '/admin/userQuestion' => array('class' => '', 'title' => 'Вопросы пользователей', 'icon' => 'icon-comments'),
        '/admin/news' => array('class' => '', 'title' => 'Новости', 'icon' => 'icon-calendar'),
        '/admin/currency' => array('class' => '', 'title' => 'Обмен валют i.ua', 'icon' => 'icon-refresh'),
    );

    public function init()
    {
        //if(isset($_REQUEST['awersome']) && $_REQUEST['awersome'] == 1) {
            $this->layout = '//layouts/awersome';
            $this->theme = 'awersome/';
        //}

        if (Yii::app()->user->isGuest === false) {
            $this->user = User::model()->findByPk(Yii::app()->user->id);
            if ($this->user->role == 0) $this->redirect(Yii::app()->params['baseUrl']);
            foreach (Setting::model()->findAll() as $setting) {
                $this->settings[$setting->title] = $setting;
            }
        } else {
            $this->redirect(Yii::app()->params['baseUrl']);
        }
    }

	public function actionCurrency()
	{
		$this->menu['/admin/currency']['class'] = 'active';
		if (Yii::app()->request->isPostRequest === true) {
			$command = Yii::app()->db->createCommand();
			$command->update('i', array(
				'buyAmount' => $_POST['buyAmount'],
				'buyPrice' => $_POST['buyPrice'],
				'sellAmount' => $_POST['sellAmount'],
				'sellPrice' => $_POST['sellPrice'],
				'district' => $_POST['district'],
				'comment' => $_POST['comment'],
				'start' => $_POST['start'],
				'live' => $_POST['live'],
				'login' => $_POST['login'],
				'password' => $_POST['password'],
			), 'id=:id', array(':id' => 1));
			
			@file_get_contents('http://877670.mz226779.web.hosting-test.net/i.php?action=update');
			@file_get_contents('http://877670.mz226779.web.hosting-test.net/minfin.php?action=update');
		}
		$trade = Yii::app()->db->createCommand("SELECT * FROM `i` WHERE `id` = 1")->queryRow();

		$statistic = json_decode(file_get_contents('http://877670.mz226779.web.hosting-test.net/i.php?action=getListInfo'));

		$this->render($this->theme . 'currency', array('statistic' => $statistic, 'trade' => $trade));
	}

    public function actionSettings()
    {
        $this->menu['/admin/settings']['class'] = 'active';
        if (Yii::app()->request->isPostRequest === true) {
            foreach ($_POST as $title => $record){
                $setting = Setting::model()->find('title = :title', array(':title' => $title));
                if(isset($setting->id)) {
                    $setting->key = $record['key'];
                    $setting->value = $record['value'];
                    $setting->save();
                }
            }
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/settings');
        }

        $this->render($this->theme . 'settings', array());
    }

    public function actionDelivery()
    {
        $this->menu['/admin/delivery']['class'] = 'active';

        $criteria = new CDbCriteria();
        $criteria->order = 't.date DESC';
        $count = Delivery::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $delivery = Delivery::model()->findAll($criteria);

        $this->render($this->theme . 'delivery', array('delivery' => $delivery, 'pages' => $pages));
    }

    public function actionParser()
    {
        $this->menu['/admin/parser']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->order = 't.date DESC';
        $count = Purchase::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $models = Purchase::model()->findAll($criteria);

        $this->render($this->theme . 'parser', array('models' => $models, 'pages' => $pages));
    }

    public function actionIndex()
    {
        $this->menu['/admin']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->order = 't.sort ASC';
        $count = Product::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $products = Product::model()->findAll($criteria);

        $this->render($this->theme . 'index', array('products' => $products, 'pages' => $pages));
    }

    public function actionRefillOrders()
    {
        $this->menu['/admin/refillOrders']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->condition = 't.status = 1';
        $criteria->order = 't.id DESC';
        $count = Interkassa::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $orders = Interkassa::model()->findAll($criteria);

        $this->render($this->theme . 'refillOrders', array('orders' => $orders, 'pages' => $pages));
    }

    public function actionOrders()
    {
        $this->menu['/admin/orders']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = Orders::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $orders = Orders::model()->findAll($criteria);

        $this->render($this->theme . 'orders', array('orders' => $orders, 'pages' => $pages));
    }

    public function actionSelectStatusOrder()
    {
        if (empty($_POST['id']) === true || isset($_POST['value']) === false) {
            exit;
        }

        $order = Orders::model()->findByPk($_POST['id']);
        if (empty($order->ID) === true) {
            exit;
        }

        $order->ORDER_STATE = $_POST['value'];
        $order->save();
        exit;
    }

    /**
     * добавление продукта
     */
    public function actionAddProduct()
    {
        $this->menu['/admin']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $product = new Product($_POST['type']);
            $product->attributes = $_POST;
            $product->status = isset($_POST['status']) ? 1 : 0;

            if (isset($_POST['keys']) && $_POST['keys'] != '') {
                $keys = explode(',', $_POST['keys']);
                unset($_POST['keys']);
            }

            if ($product->validate()) {
                $product->save();
                if (isset($keys)) {
                    foreach ($keys as $key) {
                        if ($key == '') continue;
                        $softCode = new SoftCode();
                        $softCode->productId = $product->id;
                        $softCode->code = $key;
                        $softCode->save();
                    }
                }
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin');
            } else {
                $errors = $product->getErrors();
            }
        }

        $this->render($this->theme . 'addProduct', array('errors' => $errors));
    }

    /**
     * редактирование
     */
    public function actionEditProduct($id)
    {
        $this->menu['/admin']['class'] = 'active';
        $product = Product::model()->with('keys')->findByPk($id);

        if (empty($product->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin');
        }
        $errors = false;
        $save = false;
        if (Yii::app()->request->isPostRequest === true) {
            $product->attributes = $_POST;
            $product->status = isset($_POST['status']) ? 1 : 0;

            if (isset($_POST['keys']) && $_POST['keys'] != '') {
                $keys = explode(',', $_POST['keys']);
                SoftCode::model()->deleteAll('productId = :pid', array(':pid' => $product->id));
                foreach ($keys as $key) {
                    if ($key == '') continue;
                    $softCode = new SoftCode();
                    $softCode->productId = $product->id;
                    $softCode->code = $key;
                    $softCode->save();
                }
                unset($_POST['keys']);
            }

            if ($product->validate()) {
                $product->save();
                $save = true;
            } else {
                $errors = $product->getErrors();
            }
        }

        $this->render($this->theme . 'editProduct', array('product' => $product, 'errors' => $errors, 'save' => $save));
    }

    /**
     * удаление
     */
    public function actionDeleteProduct($id)
    {
        $product = Product::model()->findByPk($id);
        if (empty($product->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin');
        }

        $product->delete();
        $this->redirect(Yii::app()->params['baseUrl'] . '/admin');
    }

    public function actionUser()
    {
        $this->menu['/admin/user']['class'] = 'active';

        $criteria = new CDbCriteria();
		if (empty($_GET['id']) === false || empty($_GET['username']) === false || empty($_GET['email']) === false) {
			$condition = '';
			if (empty($_GET['id']) === false) {
				$condition = "t.id = {$_GET['id']}";
			}

			if (empty($_GET['username']) === false) {
				$condition = ($condition == '') ? "t.username like '%{$_GET['username']}%'" : " OR t.username like '%{$_GET['username']}%'";
			}
			
			if (empty($_GET['email']) === false) {
				$condition = ($condition == '') ? "t.email like '%{$_GET['email']}%'" : " OR t.email like '%{$_GET['email']}%'";
			}
			
			$criteria->condition = $condition;
		}

        $criteria->order = 't.id DESC';
        $count = User::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $users = User::model()->findAll($criteria);

        $this->render($this->theme . 'user', array('users' => $users, 'pages' => $pages));
    }

    public function actionEditUser($id)
    {
        $this->menu['/admin/user']['class'] = 'active';
        $model = User::model()->findByPk($id);

        if (empty($model->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/user');
        }
        $errors = false;
        $save = false;
        if (Yii::app()->request->isPostRequest === true) {
            $model->attributes = $_POST;

            if ($model->validate()) {
                $model->save();
                $save = true;
            } else {
                $errors = $model->getErrors();
            }
        }

        $this->render($this->theme . 'editUser', array('model' => $model, 'errors' => $errors, 'save' => $save));
    }

    public function actionDeleteUser($id)
    {
        $model = User::model()->findByPk($id);
        if (empty($model->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/user');
        }

        $model->delete();
        $this->redirect(Yii::app()->params['baseUrl'] . '/admin/user');
    }

    public function actionCoupon()
    {
        $this->menu['/admin/coupon']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $coupon = new Coupon();
            $coupon->attributes = $_POST;

            if ($coupon->validate()) {
                $coupon->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin/coupon');
            } else {
                $errors = $coupon->getErrors();
            }
        }

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = Coupon::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $models = Coupon::model()->findAll($criteria);

        $this->render($this->theme . 'coupon', array('models' => $models, 'pages' => $pages, 'errors' => $errors));
    }

    public function actionDeleteCoupon($id)
    {
        $model = Coupon::model()->findByPk($id);
        if (empty($model->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/coupon');
        }

        $model->delete();
        $this->redirect(Yii::app()->params['baseUrl'] . '/admin/coupon');
    }

    public function actionSoftCode()
    {
        $this->menu['/admin/softCode']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $softCode = new SoftCode();
            $softCode->attributes = $_POST;

            if ($softCode->validate()) {
                $softCode->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin/softCode');
            } else {
                $errors = $softCode->getErrors();
            }
        }

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = SoftCode::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $models = SoftCode::model()->findAll($criteria);

        $this->render($this->theme . 'softCode', array('models' => $models, 'pages' => $pages, 'errors' => $errors));
    }

    public function actionDeleteSoftCode($id)
    {
        $model = SoftCode::model()->findByPk($id);
        if (empty($model->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/softCode');
        }

        $model->delete();
        $this->redirect(Yii::app()->params['baseUrl'] . '/admin/softCode');
    }

    /**
     * Статистика.
     */
    public function actionStatistics()
    {
        $this->menu['/admin/statistics']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = GeneratedLink::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $links = GeneratedLink::model()->with('statistic')->findAll($criteria);

        $this->render($this->theme . 'statistic', array('links' => $links, 'pages' => $pages));
    }

    public function actionChangeLink($id)
    {
        $this->menu['/admin/statistics']['class'] = 'active';
        $save = false;

        if (Yii::app()->request->isPostRequest === true) {
            $url = StatisticsLink::model()->find(
                't.id = :id',
                array(':id' => $_POST['oldId'])
            );

            if ($url->url != $_POST['currentLink']) {
                $url->active = 0;
                $url->save();

                $statistic = new StatisticsLink();
                $statistic->linkId = $id;
                $statistic->url = $_POST['currentLink'];
                $statistic->active = 1;
                $statistic->save();
                $save = true;
            }

            $link = GeneratedLink::model()->find(
                't.id = :id',
                array(':id' => $id)
            );
            $link->link = $_POST['link'];
            $link->save();
            $save = true;
        }

        $link = GeneratedLink::model()->with('statistic')->find(
            't.id = :id',
            array(':id' => $id)
        );

        $this->render($this->theme . 'changeLink', array('link' => $link, 'save' => $save));
    }

    public function actionRefill()
    {
        $this->menu['/admin/refill']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $coupon = new Refill();
            $coupon->attributes = $_POST;

            if ($coupon->validate()) {
                $coupon->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin/refill');
            } else {
                $errors = $coupon->getErrors();
            }
        }

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = Refill::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $models = Refill::model()->findAll($criteria);

        $this->render($this->theme . 'refill', array('models' => $models, 'pages' => $pages, 'errors' => $errors));
    }

    public function actionDeleteRefill($id)
    {
        $model = Refill::model()->findByPk($id);
        if (empty($model->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/refill');
        }

        $model->delete();
        $this->redirect(Yii::app()->params['baseUrl'] . '/admin/refill');
    }

    public function actionUserQuestion()
    {
        $this->menu['/admin/userQuestion']['class'] = 'active';
        $criteria = new CDbCriteria();
        $criteria->condition = 't.active = 1';
        $criteria->order = 't.date DESC';
        $count = Question::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $userQuestion = Question::model()->findAll($criteria);

        $this->render($this->theme . 'userQuestion', array('questions' => $userQuestion, 'pages' => $pages));
    }

    public function actionMessageList($id)
    {
        $this->menu['/admin/userQuestion']['class'] = 'active';
        $question = Question::model()->findByPk($id);
        if (empty($_GET['active']) === false && $_GET['active'] == 'false') {
            $question->active = 0;
            $question->save();

            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/userQuestion');
        }

        if (empty($_POST['message']) === false) {
            $questionMessage = new QuestionMessage();
            $questionMessage->questionId = $question->id;
            $questionMessage->type = QuestionMessage::TYPE_ADMIN;
            $questionMessage->message = $_POST['message'];
            $questionMessage->date = date('Y-m-d H:i:s', time());
            $questionMessage->save();
        }

        $this->render($this->theme . 'messageList', array('question' => $question));
    }

    public function actionNews()
    {
        $this->menu['/admin/news']['class'] = 'active';
        $news = News::model()->findAll();

        $this->render($this->theme . 'news', array('news' => $news));
    }

    public function actionEditNew($id)
    {
        $this->menu['/admin/news']['class'] = 'active';
        $errors = false;
        $new = News::model()->findByPk($id);
        if (empty($_GET['remove']) === false && $_GET['remove'] == 'true') {
            $new->delete();
            $this->redirect(Yii::app()->params['baseUrl'] . '/admin/news');
        }

        if (Yii::app()->request->isPostRequest === true) {
            if (empty($_POST['title']) === true || $_POST['title'] == '') {
                $errors['title'] = 'Не заполено поле "Тема".';
            }

            if (empty($_POST['content']) === true || $_POST['content'] == '') {
                $errors['content'] = 'Не заполено поле "Контент".';
            }

            if ($errors === false) {
                $new->title = $_POST['title'];
                $new->content = $_POST['content'];
                $new->type = $_POST['type'];
                $new->date = date('Y-m-d H:i:s', time());
                $new->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin/news');
            }
        }

        $this->render($this->theme . 'editNew', array('new' => $new, 'errors' => $errors));
    }

    public function actionAddNew()
    {
        $this->menu['/admin/news']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            if (empty($_POST['title']) === true || $_POST['title'] == '') {
                $errors['title'] = 'Не заполено поле "Тема".';
            }

            if (empty($_POST['content']) === true || $_POST['content'] == '') {
                $errors['content'] = 'Не заполено поле "Контент".';
            }

            if ($errors === false) {
                $new = new News();
                $new->title = $_POST['title'];
                $new->content = $_POST['content'];
				$new->type = $_POST['type'];
                $new->date = date('Y-m-d H:i:s', time());
                $new->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/admin/news');
            }
        }

        $this->render($this->theme . 'addNew', array('errors' => $errors));
    }
}
