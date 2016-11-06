<?php
class DefaultController extends CController
{
    public $title = 'Кабинет';

    public $keywords;

    public $description;

    public $user = false;

    public $couponError = false;

    public $couponAmount = false;

    public $menu = array(
        '/' => array('class' => '', 'title' => 'Выбрать и купить'),
        '/balance' => array('class' => '', 'title' => 'Пополнить баланс'),
        '/news' => array('class' => '', 'title' => 'Правила!!!!'),
        '/purchase' => array('class' => '', 'title' => 'Мои покупки'),
    );

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions'=>array('index', 'ByProcessing', 'BuySoft', 'Purchase', 'News', 'Balance'),
                'users'=>array('?'),
            ),
            array('allow',
                'actions'=>array('delete'),
                'roles'=>array('admin'),
            ),
            array('allow',
                'actions'=>array('delete'),
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Лейаут по умолчанию, в отличии от оффициальной документации.
     *
     * @var string
     */
    public $layout = '//layouts/default';

    public function init()
    {
        if (Yii::app()->user->isGuest === false) {
            $this->user = User::model()->findByPk(Yii::app()->user->id);

            if (empty($this->user->id) === true) {
                Yii::app()->user->logout();
            }
        }

        $this->couponWidget();
    }
    /**
     * Login
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest === false) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        $error = false;
        $this->layout = '//layouts/login';
        if (Yii::app()->request->isPostRequest === true) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $identity=new UserIdentity($username,$password);

            if($identity->authenticate() == true) {
                Yii::app()->user->login($identity);
                $this->redirect(Yii::app()->params['baseUrl']);
            } else {
                $error = $identity->errorMessage;
            }
        }

        if (Yii::app()->request->isAjaxRequest && $error != false) {
            echo $error;
        }
        $this->render('login', array('error' => $error));
    }

    /*
    * Регистрация
    *
    * @param
    * @return
    */
    public function actionRegistration() {
        if (Yii::app()->user->isGuest === false) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        $errors = false;
        $this->layout = '//layouts/login';
        if (Yii::app()->request->isPostRequest === true) {

            $user = new User();
            $user->attributes = $_POST;

            if (empty($_POST['password']) === false && $_POST['password'] != '') {
                $user->password = User::hashPassword($_POST['password']);
            }

            if ($user->validate()) {
                $user->save();
                if (Yii::app()->request->isAjaxRequest) {
                    echo 'Спасибо за регистрацию';
                    exit;
                } else {
                    $this->redirect(Yii::app()->params['baseUrl']);
                }

            }

            $errors = $user->getErrors();

            if (Yii::app()->request->isAjaxRequest) {
                if ($errors != false){
                    $output = '';
                    foreach ($errors as $error) {
                        $output.= $error[0] . '<br />';
                    }
                    echo $output;
                } else {
                    echo 'Спасибо за регистрацию';
                }
                exit;
            }
        }


        $this->render('registration', array('errors' => $errors));
    }

    public function actionIndex()
    {
        $this->menu['/']['class'] = 'active';

        $type = (empty($_GET['type']) === false) ? $_GET['type'] : 'processing';

        $criteria = new CDbCriteria();
        $criteria->order = 't.sort ASC';
        $criteria->condition = 't.type = :type';
        $criteria->params = array(':type' => $type);
        $count = Product::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $products = Product::model()->findAll($criteria);

        $this->render('index', array('type' => $type, 'products' => $products, 'pages' => $pages));
    }

    public function actionByProcessing()
    {
        if (empty($_POST['id']) === true || empty($_POST['count']) === true || empty($_POST['url']) === true) {
            exit;
        }

        $product = Product::model()->findByPk($_POST['id']);
        if (empty($product->id) === true) {
            exit;
        }

        $order = new Orders();
        $order->USER_LOGIN = $this->user->username;
        $order->ORDER_TYPE = $product->id;
        $order->RUN_COUNT = $_POST['count'] * $product->countPrice;
        $order->URL = $_POST['url'];
        $order->DATE_TIME = date('Y-m-d H;i:s', time());
        $order->URL_RESULT = NULL;
        $order->ORDER_STATE = Orders::STATUS_NEW;

        if ($order->validate()) {
            if ($this->user->buy($product->price * $_POST['count'])) {
                $order->save();
                $error = 0;
            } else {
                $error = Orders::ERROR_MONEY;
            }

        } else {
            $error = var_export($order->getErrors(), true);
        }

        echo json_encode(array('error' => $error, 'id' => (isset($order->ID)) ? $order->ID : 0));
        exit;
    }

    public function actionBuySoft($id)
    {
        $this->menu['/']['class'] = 'active';

        $product = Product::model()->findByPk($id);
        if (empty($product->id) === true) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }
        $generator = SoftCode::model()->find('productId = :productId', array(':productId' => $product->id));
        if (empty($generator->id) === true) {
            $error = SoftCode::ERROR_EMPTY_CODE;
        }

        if (isset($generator->id) && $this->user->buy($product->price)) {

            $code = $generator->code;
            $generator->delete();

            $order = new SoftOrders();
            $order->productId = $product->id;
            $order->userId = $this->user->id;
            $order->code = $code;
            $order->date = date('Y-m-d H;i:s', time());
            $order->save();
        } elseif(empty($error)) {
            $error = Orders::ERROR_MONEY;
        }

        $this->render('buySoft', array('error' => isset($error) ? $error : false, 'product' => $product, 'code' => isset($code) ? $code : false,));
    }

    public function actionPurchase()
    {
        $this->menu['/purchase']['class'] = 'active';

        $type = (empty($_GET['type']) === false) ? $_GET['type'] : 'processing';

        if ($type == 'processing') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.ID DESC';
            $criteria->condition = 't.USER_LOGIN = :username';
            $criteria->params = array(':username' => $this->user->username);
            $count = Orders::model()->count($criteria);

            $pages = new CPagination($count);
            // элементов на страницу
            $pages->pageSize = 25;
            $pages->applyLimit($criteria);

            $orders = Orders::model()->findAll($criteria);
        }

        if ($type == 'buy') {
            $criteria = new CDbCriteria();
            $criteria->order = 't.id DESC';
            $criteria->condition = 't.userId = :userId';
            $criteria->params = array(':userId' => $this->user->id);
            $count = SoftOrders::model()->count($criteria);

            $pages = new CPagination($count);
            // элементов на страницу
            $pages->pageSize = 25;
            $pages->applyLimit($criteria);

            $orders = SoftOrders::model()->findAll($criteria);
        }
        $this->render('purchase', array('type' => $type, 'orders' => $orders, 'pages' => $pages));
    }

    public function actionNews()
    {
        $this->menu['/news']['class'] = 'active';
        $this->render('news');
    }

    public function actionBalance()
    {
        $this->menu['/balance']['class'] = 'active';

        $transaction = false;
        $error = false;
        $action = false;
        if (isset($_POST['amount']) && (float) $_POST['amount'] > 0)
        {
            $transaction = new Interkassa();
            $transaction->amount = round((float)$_POST['amount'], 2);
            $transaction->userId = $this->user->id;
            $transaction->description = 'Пополнение баланса на сайте ' . Yii::app()->params['baseUrl'] . ' на сумму '
            . $transaction->amount . Yii::app()->params['currency'];
            $transaction->status = Interkassa::STATUS_NEW;
            $transaction->date = date('Y-m-d H:i:s', time());
            if ($transaction->validate()) {
                $transaction->save();
            } else {
                $error = $transaction->getErrors();
                $transaction = false;
            }
        }

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
		

        $this->render('balance', array('transaction' => $transaction, 'error' => $error, 'action' => $action));
    }

    public function actionRefill($id)
    {
   // if (empty($_POST) === false) {
            switch ($id) {
                case 1: $this->redirect(Yii::app()->params['baseUrl'] . '/balance?action=1');
                    break;
                case 2: $this->redirect(Yii::app()->params['baseUrl'] . '/balance?action=2');
                    break;
                case 3: Interkassa::result($_POST);
                    break;
                case 4: 
				
				$transaction = new Interkassa();
				$transaction->amount = 222;
				$transaction->userId = 49;
				$transaction->status = Interkassa::STATUS_NEW;
				$transaction->save();
                    break;
                default: Interkassa::result($_POST);
            }
        //} else  { echo 'no';}
        exit;
    }

    /**
     * Exit
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->params['baseUrl']);
    }

    /**
     * Обработка действий с купоном.
     */
    protected function couponWidget()
    {
        if (empty($_POST['codeCoupon']) === false) {
            $coupon = Coupon::model()->find('code = :code', array(':code' => $_POST['codeCoupon']));

            if (empty($coupon->id) === true) {
                $this->couponError = 'Не верный код купона!';
                return;
            }

            $this->user->balance+= $coupon->amount;
            $this->user->save();
            $coupon->delete();
            $this->couponAmount = 'Ваш счет пополнен на ' . $coupon->amount . Yii::app()->params['currency'];
            return;
        }
    }
}
