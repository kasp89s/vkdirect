<?php
class DefaultController extends CController
{
    public $title = 'Кабинет';

    public $keywords;

    public $description;

    public $user = false;

    public $couponError = false;

    public $couponAmount = false;

    public $settings = array();

    public $domain = false;

	public $theme = '';

    public $menu = array(
        '/' => array('class' => '', 'title' => 'Мои сайты', 'icon' => 'icon-shopping-cart'),
        '/statistics' => array('class' => '', 'title' => 'База идентификаций', 'icon' => 'icon-book'),
//        '/delivery' => array('class' => '', 'title' => 'База идентификаций', 'icon' => 'icon-book'),
//        '/parser' => array('class' => '', 'title' => 'Парсинг mail.ru'),
        '/balance' => array('class' => '', 'title' => 'Пополнить баланс', 'icon' => 'icon-money'),
//        '/news' => array('class' => '', 'title' => 'Правила!!!!', 'icon' => 'icon-info'),
//        '/purchase' => array('class' => '', 'title' => 'Мои покупки', 'icon' => 'icon-truck'),
//        '/statistics' => array('class' => '', 'title' => 'База идентификаций', 'icon' => 'icon-book'),
        '/referrals' => array('class' => '', 'title' => 'Мои рефералы', 'icon' => 'icon-group'),
        '/questions' => array('class' => '', 'title' => 'Мои вопросы', 'icon' => 'icon-comments'),
        '/help' => array('class' => '', 'title' => 'Помощь', 'icon' => 'icon-question-sign'),
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
                'actions'=>array('index', 'ByProcessing', 'BuySoft', 'Purchase', 'News', 'Balance', 'Delivery', 'Parser'),
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
		//if(isset($_REQUEST['awersome']) && $_REQUEST['awersome'] == 1) {
			$this->layout = '//layouts/awersome';
			$this->theme = 'awersome/';
		//}
        if (Yii::app()->user->isGuest === false) {
            $this->user = User::model()->findByPk(Yii::app()->user->id);

            if (empty($this->user->id) === true) {
                Yii::app()->user->logout();
            }

            if ($this->user->referralCode == null) {
                $this->user->referralCode = User::generateReferralCode($this->user->username, $this->user->id);
                $this->user->save();
            }

            foreach (Setting::model()->findAll() as $setting) {
                $this->settings[$setting->title] = $setting;
            }
            $this->domain = 'http://' . $_SERVER['HTTP_HOST'];
            User::checkMyFolder(Yii::app()->user->id);
        }

        $this->couponWidget();
    }
    // ПРЕНОС ПАРСЕРА!!!!
    public function actionDelivery()
    {
        $this->menu['/']['class'] = 'active';

        $criteria = new CDbCriteria();
        $criteria->condition = 't.userId = :userId';
        $criteria->params = array(':userId' => $this->user->id);
        $criteria->order = 't.date DESC';
        $count = Delivery::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $delivery = Delivery::model()->findAll($criteria);

        $this->render($this->theme . 'delivery', array('delivery' => $delivery, 'pages' => $pages));
    }
    public function actionLoadDeliveryBody()
    {
        if (Yii::app()->request->isPostRequest === true) {
            $delivery = Delivery::model()->findByPk($_POST['deliveryId']);

            if (empty($delivery->id) === false && $delivery->userId == $this->user->id || $this->user->role == 1) {
                echo json_encode(array('body' => file_get_contents($delivery->body)));
                Yii::app()->end();
            }
        }
    }

    /**
     * Валидация ajax.
     */
    public function actionValidateDelivery()
    {
        $errors = Delivery::customValidate($_POST);
        $money =  Delivery::validateAmount($_POST['emailCount'], $this->settings, $this->user);

        if (is_array($errors) && is_array($money)) {
            $errors = array_merge($errors, $money);
        }

        if (is_array($money) && $errors === false) {
            $errors = $money;
        }

        $render = $this->renderPartial('ajax-errors', array('errors' => $errors), true);
        echo json_encode(array('errors' => $errors, 'render' => $render));
        Yii::app()->end();
    }

    /**
     * Валидация ajax.
     */
    public function actionValidatePurchase()
    {
        $errors = Purchase::customValidate($_POST);

        $render = $this->renderPartial('ajax-errors', array('errors' => $errors), true);
        echo json_encode(array('errors' => $errors, 'render' => $render));
        Yii::app()->end();
    }

    public function actionCreateDelivery()
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $errors = Delivery::customValidate($_POST, $_FILES);
            $money =  Delivery::validateAmount($_POST['emailCount'], $this->settings, $this->user);

            if (is_array($errors) && is_array($money)) {
                $errors = array_merge($errors, $money);
            }

            if (is_array($money) && $errors === false) {
                $errors = $money;
            }

            if ($errors === false) {
                $delivery = new Delivery();
                $delivery->userId = $this->user->id;
                $delivery->emailBase = $_POST['emailBaseLink'];
                $delivery->senderBase = $_POST['senderBaseLink'];
                $delivery->titleBase = $_POST['titleBaseLink'];
                $delivery->title = $_POST['title'];
                $delivery->email = $_POST['email'];
                // $delivery->body = $_POST['body_' . $_POST['type']];
                $delivery->type = $_POST['type'];
                $delivery->count = $_POST['emailCount'];
                $delivery->save();

                $deliveryPath = USER_PATH . DIRECTORY_SEPARATOR . 'u_' . $this->user->id . DIRECTORY_SEPARATOR . 'd_' . $delivery->id;
                $readPath = $this->domain . '/userData/'. 'u_' . $this->user->id . '/' . 'd_' . $delivery->id;
                // Создаем директорию рассылки.
                if (!file_exists($deliveryPath)){
                    mkdir($deliveryPath, 0777);
                }

                // Добавляем файл боди
                $bodyFileName = 'body_' . time() . '.txt';
                $delivery->body = $readPath . DIRECTORY_SEPARATOR . $bodyFileName;
                file_put_contents($deliveryPath . DIRECTORY_SEPARATOR . $bodyFileName, $_POST['body_' . $_POST['type']]);
                // Копируем и добавляем вложение.
                if (empty($_FILES['attachment']) === false && $_FILES['attachment']['tmp_name'] != '') {
                    if (copy($_FILES['attachment']['tmp_name'], $deliveryPath . DIRECTORY_SEPARATOR . $_FILES['attachment']['name'])) {
                        $delivery->file = $readPath . DIRECTORY_SEPARATOR . $_FILES['attachment']['name'];
                    }
                }

                // Копируем базы в директорию рассылки.
                if (empty($_POST['generateSender']) === false) {
                    $name = time() . 'sender.txt';
                    $list = Delivery::generateSenderBase($_POST['generateDomain'], $_POST['emailCount']);
                    file_put_contents($deliveryPath . DIRECTORY_SEPARATOR . $name, $list);
                    $delivery->senderBase = $readPath . DIRECTORY_SEPARATOR . $name;
                } else {
                    $name = explode(DIRECTORY_SEPARATOR, $_POST['senderBaseLink']);
                    $name = end($name);
                    if (copy($_POST['senderBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
                        $delivery->senderBase = $readPath . DIRECTORY_SEPARATOR . $name;
                        unlink($_POST['senderBaseLink']);
                    }
                }
                $name = explode(DIRECTORY_SEPARATOR, $_POST['emailBaseLink']);
                $name = end($name);
                if (copy($_POST['emailBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
                    $delivery->emailBase = $readPath . DIRECTORY_SEPARATOR . $name;
                    unlink($_POST['emailBaseLink']);
                }
//                if (empty($_POST['titleBaseLink']) === false) {
//                    $name = explode(DIRECTORY_SEPARATOR, $_POST['titleBaseLink']);
//                    $name = end($name);
//                    $titleBase = file_get_contents($_POST['titleBaseLink']);
//                    $encoding = mb_detect_encoding($titleBase, array('utf-8', 'cp1251'));
//                    $titleBase = mb_convert_encoding($titleBase, "utf-8", $encoding);
//                    //$titleBase = iconv($encoding, 'utf-8', $titleBase);
////                    file_put_contents($_POST['titleBaseLink'], $titleBase);
//                    $f = fopen($_POST['titleBaseLink'], 'w+');  // создаем файл export.csv
//                    fwrite($f, "\xEF\xBB\xBF", 3);   // пишем в начало файла 3 байта
//                    fwrite($f, $titleBase);   // пишем в начало файла 3 байта
//                    fclose($f);
//                    if (copy($_POST['titleBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
//                        $delivery->titleBase = $readPath . DIRECTORY_SEPARATOR . $name;
//                        unlink($_POST['titleBaseLink']);
//                    }
//                }

                // Готовим макросы.
                if(
                    (isset($_POST['macros']) && is_array($_POST['macros']) && count($_POST['macros']) > 0) ||
                    (empty($_POST['titleBase']) === false && $_POST['titleBase'] != '')
                ) {
                    $zip = new ZipArchive();
                    $time = time();
                    $zipName = $deliveryPath . DIRECTORY_SEPARATOR . 'macros' . $time . $delivery->id . '.zip';
                    $zipReadPath = $readPath . DIRECTORY_SEPARATOR . 'macros' . $time . $delivery->id . '.zip';
                    if ($zip->open($zipName, ZipArchive::CREATE) !== true) {
                        $errors['zip'] = "Невозможно открыть <$zipName>.";
                    }
                    if (isset($_POST['macros']) && is_array($_POST['macros']) && count($_POST['macros']) > 0){
                        foreach ($_POST['macros'] as $name => $text) {
                            if(stripos($_POST['macrosList'], $name) !== false) {
                                $zip->addFromString($name . '.txt', $text);
                            }
                        }
                    }

                    if (empty($_POST['titleBase']) === false && $_POST['titleBase'] != '') {
                        $zip->addFromString('title1.txt', $_POST['titleBase']);
                        $delivery->titleBase = '+';
                    }
                    $zip->close();

                    $delivery->macros = $zipReadPath;
                }

                if ($errors === false) {
                    $this->deliveryPay($delivery);
                    //$delivery->status = Delivery::STATUS_NEW;
                    //$delivery->save();
                    $this->redirect(Yii::app()->params['baseUrl'] . '/delivery');
                } else {
                    $delivery->delete();
                }
            }

        }
        $this->render($this->theme . 'createDelivery', array('errors' => $errors));
    }

    /**
     * Редактирование рассылки.
     */
    public function actionRefactorDelivery($id)
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;
        $save = false;
        $delivery = Delivery::model()->findByPk($id);

        if ((empty($delivery->id) === true || $delivery->userId != $this->user->id || $delivery->status != Delivery::STATUS_ERROR) && $this->user->role != 1) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        if (Yii::app()->request->isPostRequest === true) {
            $errors = Delivery::customValidate($_POST);

            if ($errors === false) {
                $deliveryPath = USER_PATH . DIRECTORY_SEPARATOR . 'u_' . $this->user->id . DIRECTORY_SEPARATOR . 'd_' . $delivery->id;
                $readPath = $this->domain . '/userData/'. 'u_' . $this->user->id . '/' . 'd_' . $delivery->id;

                if ($delivery->emailBase != $_POST['emailBaseLink']) {
                    unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->emailBase));
                    $name = explode(DIRECTORY_SEPARATOR, $_POST['emailBaseLink']);
                    $name = end($name);
                    if (copy($_POST['emailBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
                        $delivery->emailBase = $readPath . DIRECTORY_SEPARATOR . $name;
                        unlink($_POST['emailBaseLink']);
                    }
                }

                if (empty($_POST['generateSender']) === false) {
                    $name = time() . 'sender.txt';
                    $list = Delivery::generateSenderBase($_POST['generateDomain'], $_POST['emailCount']);
                    file_put_contents($deliveryPath . DIRECTORY_SEPARATOR . $name, $list);
                    $delivery->senderBase = $readPath . DIRECTORY_SEPARATOR . $name;
                } else {
                    if ($delivery->senderBase != $_POST['senderBaseLink']) {
                        unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->senderBase));
                        $name = explode(DIRECTORY_SEPARATOR, $_POST['senderBaseLink']);
                        $name = end($name);
                        if (copy($_POST['senderBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
                            $delivery->senderBase = $readPath . DIRECTORY_SEPARATOR . $name;
                            unlink($_POST['senderBaseLink']);
                        }
                    }
                }

//                if (empty($_POST['titleBaseLink']) === false && $delivery->titleBase != $_POST['titleBaseLink']) {
//                    if (!empty($delivery->titleBase) && $delivery->titleBase != '') unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->titleBase));
//
//                    $name = explode(DIRECTORY_SEPARATOR, $_POST['titleBaseLink']);
//                    $name = end($name);
//                    $titleBase = file_get_contents($_POST['titleBaseLink']);
//                    $encoding = mb_detect_encoding($titleBase, array('utf-8', 'cp1251'));
//                    $titleBase = mb_convert_encoding($titleBase, "utf-8", $encoding);
//          //          $titleBase = iconv($encoding, 'utf-8', $titleBase);
//                    $f = fopen($_POST['titleBaseLink'], 'w+');  // создаем файл export.csv
//                    fwrite($f, "\xEF\xBB\xBF", 3);   // пишем в начало файла 3 байта
//                    fwrite($f, $titleBase);   // пишем в начало файла 3 байта
//                    fclose($f);
//                    if (copy($_POST['titleBaseLink'], $deliveryPath . DIRECTORY_SEPARATOR . $name)) {
//                        $delivery->titleBase = $readPath . DIRECTORY_SEPARATOR . $name;
//                        unlink($_POST['titleBaseLink']);
//                    }
//                } elseif(empty($_POST['titleBaseLink']) === true) {
//					if (!empty($delivery->titleBase) && $delivery->titleBase != '') unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->titleBase));
//					$delivery->titleBase = null;
//				}

                $delivery->title = $_POST['title'];
                $delivery->email = $_POST['email'];

                $oldBody = file_get_contents($delivery->body);
                if (($oldBody != $_POST['body_' . $_POST['type']]) || ($delivery->type != $_POST['type']))  {
                    unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->body));
                    $bodyFileName = 'body_' . time() . '.txt';
                    $delivery->body = $readPath . DIRECTORY_SEPARATOR . $bodyFileName;
                    file_put_contents($deliveryPath . DIRECTORY_SEPARATOR . $bodyFileName, $_POST['body_' . $_POST['type']]);
                }
                $delivery->type = $_POST['type'];
                $delivery->count = $_POST['emailCount'];


                // Копируем и добавляем вложение.
                if (
                    empty($_FILES['attachment']) === false &&
                    $_FILES['attachment']['tmp_name'] != '' &&
                    $delivery->file  != $readPath . DIRECTORY_SEPARATOR . $_FILES['attachment']['name']
                ) {
                    unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->file));
                    if (copy($_FILES['attachment']['tmp_name'], $deliveryPath . DIRECTORY_SEPARATOR . $_FILES['attachment']['name'])) {
                        $delivery->file = $readPath . DIRECTORY_SEPARATOR . $_FILES['attachment']['name'];
                    }
                }


                // Готовим макросы.
                if(
                    (isset($_POST['macros']) && is_array($_POST['macros']) && count($_POST['macros']) > 0) ||
                    (empty($_POST['titleBase']) === false && $_POST['titleBase'] != '')
                ) {
                    $zip = new ZipArchive();
                    $time = time();
                    $zipName = $deliveryPath . DIRECTORY_SEPARATOR . 'macros' . $time . $delivery->id . '.zip';
                    $zipReadPath = $readPath . DIRECTORY_SEPARATOR . 'macros' . $time . $delivery->id . '.zip';

                    if ($zip->open($zipName, ZipArchive::CREATE) !== true) {
                        $errors['zip'] = "Невозможно открыть <$zipName>.";
                    }

                    if (isset($_POST['macros']) && is_array($_POST['macros']) && count($_POST['macros']) > 0) {
                        foreach ($_POST['macros'] as $name => $text) {
                            if(stripos($_POST['macrosList'], $name) !== false) {
                                $zip->addFromString($name . '.txt', $text);
                            }
                        }
                    }

                    if (empty($_POST['titleBase']) === false && $_POST['titleBase'] != '') {
                        $zip->addFromString('title1.txt', $_POST['titleBase']);
                        $delivery->titleBase = '+';
                    } else {
                        $delivery->titleBase = null;
                    }
                    $zip->close();

                    if($delivery->macros != null) unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->macros));
                    $delivery->macros = $zipReadPath;
                } else {
                    if($delivery->macros != null) unlink(str_replace($this->domain . '/userData', USER_PATH, $delivery->macros));
                    $delivery->macros = null;
                }

                $delivery->save();

                $save = true;
            }
        }

        $macros = $this->unZipMacros(str_replace($this->domain . '/userData', USER_PATH, $delivery->macros));

        $this->render($this->theme . 'refactorDelivery', array('delivery' => $delivery, 'macros' => $macros, 'errors' => $errors, 'save' => $save));
    }

    public function actionParser()
    {
        $this->menu['/']['class'] = 'active';

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->condition = 't.userId = :userId';
        $criteria->params = array(':userId' => $this->user->id);
        $count = Purchase::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $purchase = Purchase::model()->findAll($criteria);

        $this->render($this->theme . 'parser', array('models' => $purchase,'pages' => $pages));
    }

    /**
     * Cоздание заказа на парсинг.
     */
    public function actionCreatePurchase()
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;
        if (Yii::app()->request->isPostRequest === true) {
            $errors = Purchase::customValidate($_POST);

            if ($errors === false) {
                $purchase = new Purchase();
                $purchase->userId = $this->user->id;
                $purchase->region = $_POST['region'];
                $purchase->count = $_POST['count'];
                $purchase->sex = $_POST['sex'];
                $purchase->from = $_POST['age']['from'];
                $purchase->to = $_POST['age']['to'];
                $purchase->online = $_POST['online'];
                $purchase->price = $_POST['price'];
                $purchase->date = date('Y-m-d H:i:s', time());
                $purchase->status = Purchase::STATUS_NEW;
                $purchase->save(false);

                $this->redirect(Yii::app()->params['baseUrl'] . '/parser');
            }
        }

        $this->render($this->theme . 'createPurchase', array('errors' => $errors));
    }

    public function actionRefactorPurchase($id)
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;
        $save = false;
        $purchase = Purchase::model()->findByPk($id);

        if ((empty($purchase->id) === true || $purchase->userId != $this->user->id || $purchase->status != Delivery::STATUS_NEW) && $this->user->role != 1) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        if (Yii::app()->request->isPostRequest === true) {
            $errors = Purchase::customValidate($_POST);

            if ($errors === false) {
                $purchase->region = $_POST['region'];
                $purchase->count = $_POST['count'];
                $purchase->sex = $_POST['sex'];
                $purchase->from = $_POST['age']['from'];
                $purchase->to = $_POST['age']['to'];
                $purchase->online = $_POST['online'];
                $purchase->price = $_POST['price'];
                $purchase->date = date('Y-m-d H:i:s', time());
                $purchase->save(false);
                $save = true;
            }
        }

        $this->render($this->theme . 'refactorPurchase', array('purchase' => $purchase, 'errors' => $errors, 'save' => $save));
    }

    public function actionUploader()
    {
        if (Yii::app()->request->isPostRequest === true) {
            if (count($_FILES) == 0) {
                return;
            }

            // Загружен файл письма
            if (empty($_FILES['loadBody']) === false) {
                $body = file_get_contents($_FILES['loadBody']['tmp_name']);
                echo json_encode(array('body' => $body));
                Yii::app()->end();
            }

            $info = null;
            if (empty($_FILES['emailBase']) === false) {
                $info = Delivery::getEmailBaseInfo($_FILES['emailBase']['tmp_name']);
            }

            foreach ($_FILES as $type => $file) {
                $content = $file['tmp_name'];
                $ext = explode('.', $file['name']);
                $ext = end($ext);
                $fileName = md5(date('YmdHis') . $file['name']) . '.' . $ext;
                $filePath = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'tmp/';
                if (copy($content, $filePath . $fileName)) {
                    echo json_encode(array('file' => $filePath . $fileName, 'info' => $info));
                }
            }
        }

        Yii::app()->end();
    }
    public function actionRemoveDelivery()
    {
        if (Yii::app()->request->isPostRequest === true) {
            $delivery = Delivery::model()->findByPk($_POST['id']);

            if ((empty($delivery->id) === false && $delivery->userId == $this->user->id && $delivery->status == Delivery::STATUS_NEW) || $this->user->role == 1) {
                $delivery->delete();
                echo json_encode(array('remove' => 1));
            }

        }
        Yii::app()->end();
    }

    public function actionRunDelivery()
    {
        if (Yii::app()->request->isPostRequest === true) {
            $delivery = Delivery::model()->findByPk($_POST['id']);

            if (empty($delivery->id) === false && $delivery->userId == $this->user->id && ($delivery->status == Delivery::STATUS_ERROR)) {
                $delivery->status = Delivery::STATUS_BUSY;
                $delivery->save();
                echo json_encode(array('run' => 1));
            }
        }
        Yii::app()->end();
    }

    /**
     * Оплата за рассылку.
     *
     * @param Delivery $delivery
     * @return array|bool
     */
    protected function deliveryPay(Delivery $delivery)
    {
        $amount = Delivery::calculateDeliveryPrice($delivery->count, $this->settings, $delivery->file);

        if ($this->user->balance < $amount) {
            return array('not_enough_money' => 1, 'amount' => $amount);
        }

        $this->user->balance-= $amount;
        $this->user->save();

        $delivery->status = Delivery::STATUS_BUSY;
        $delivery->save();

        return true;
    }

    public function actionRemovePurchase()
    {
        if (Yii::app()->request->isPostRequest === true) {
            $purchase = Purchase::model()->findByPk($_POST['id']);

            if ((empty($purchase->id) === false && $purchase->userId == $this->user->id && $purchase->status == Purchase::STATUS_NEW) || $this->user->role == 1) {
                $purchase->delete();
                echo json_encode(array('remove' => 1));
            }

        }
        Yii::app()->end();
    }

    public function actionRunPurchase()
    {
        if (Yii::app()->request->isPostRequest === true) {
            $purchase = Purchase::model()->findByPk($_POST['id']);

            if ($this->user->balance < $purchase->price) {
                echo json_encode(array('not_enough_money' => 1, 'amount' => $purchase->price));
                Yii::app()->end();
            }

            if (empty($purchase->id) === false && $purchase->userId == $this->user->id && $purchase->status == Purchase::STATUS_NEW) {
                $this->user->balance-= $purchase->price;
                $this->user->save();
                $purchase->status = Purchase::STATUS_BUSY;
                $purchase->save();
                echo json_encode(array('run' => 1));
            }
        }
        Yii::app()->end();
    }

    public function actionChangeState()
    {
        if (Yii::app()->request->isPostRequest === true && $this->user->role == 1) {
            $delivery = Delivery::model()->findByPk($_POST['id']);

            if (empty($delivery->id) === false) {
                $delivery->status = $_POST['status'];
                $delivery->save();
                echo json_encode(array('status' => Delivery::$statusTranslate[$_POST['status']]));
            }
        }
        Yii::app()->end();
    }

    public function actionChangeStatePurchase()
    {
        if (Yii::app()->request->isPostRequest === true && $this->user->role == 1) {
            $delivery = Purchase::model()->findByPk($_POST['id']);

            if (empty($delivery->id) === false) {
                $delivery->status = $_POST['status'];
                $delivery->save();
                echo json_encode(array('status' => Purchase::$status[$_POST['status']]));
            }
        }
        Yii::app()->end();
    }

    /**
     * Вытягивает с архива макросы и выдает в нужном формате.
     *
     * @param $file
     *
     * @return array
     */
    private function unZipMacros($file)
    {
        if (empty($file) === true) {
            return false;
        }
        $result = array();
        $zip = new ZipArchive();
        $zip->open($file);

        for ($i=0; $i<$zip->numFiles;$i++) {
            $file = $zip->statIndex($i);
            $result[str_replace('.txt', '', $file['name'])] = $zip->getFromName($file['name']);
        }

        return $result;
    }
    // КОНЕЦ ПАРСЕРА!!!!
    /**
     * Login
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest === false) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        $error = false;
        //$this->layout = '//layouts/login';
		//if(isset($_REQUEST['awersome']) && $_REQUEST['awersome'] == 1) {
			$this->layout = '//layouts/awerlogin';
			$this->theme = 'awersome/';
		//}
        if (Yii::app()->request->isPostRequest === true) {
            $username = $_POST['username'];
            $password = $_POST['password'];
			$user = User::model()->find('t.username = :username', array(':username' => $_POST['username']));
			
			if (isset($user->authCode) && $user->authCode != null) {
				$error = 'Ваша учётная запись не активирована!';
			} else {
				$identity=new UserIdentity($username,$password);

				if($identity->authenticate() == true) {
					Yii::app()->user->login($identity);
					$this->redirect(Yii::app()->params['baseUrl']);
				} else {
					$error = $identity->errorMessage;
				}
			}
        }

        if (Yii::app()->request->isAjaxRequest && $error != false) {
            echo $error;
        }
        $this->render($this->theme . 'login', array('error' => $error));
    }

	public function actionConfirm()
	{
		if (Yii::app()->user->isGuest === false) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }
		$error = false;
        $success = false;
		$this->layout = '//layouts/awerlogin';
		if (isset($_GET['code'])) {
			$user = User::model()->find('t.authCode = :authCode', array(':authCode' => $_GET['code']));
			if (empty($user->id) === false) {
				$user->authCode = null;
				$user->save();
				$success = true;
			} else {
				$error = 'Не верно указан код активации аккаунта.';
			}
			$this->render($this->theme . 'confirm', array('error' => $error, 'success' => $success));
		} else {
			$this->redirect(Yii::app()->params['baseUrl']);
		}
	}
    /*
    * Регистрация
    *
    * @param
    * @return
    */
    public function actionRegistration()
	{
        if (Yii::app()->user->isGuest === false) {
            $this->redirect(Yii::app()->params['baseUrl']);
        }

        $errors = false;
        $success = false;
        //$this->layout = '//layouts/login';
		//if(isset($_REQUEST['awersome']) && $_REQUEST['awersome'] == 1) {
			$this->layout = '//layouts/awerlogin';
			$this->theme = 'awersome/';
		//}
        if (Yii::app()->request->isPostRequest === true) {

            $user = new User();
            $user->attributes = $_POST;
			$user->authCode = $this->GenCode();
            if (empty($_POST['password']) === false && $_POST['password'] != '') {
                $user->password = User::hashPassword($_POST['password']);
            }

            if ($user->validate()) {
                $user->save();
				if (empty($_GET['ref']) === false && $_GET['ref'] != '') {
					$parrent = User::model()->find('referralCode = :referralCode', array(':referralCode' => $_GET['ref']));
					if (empty($parrent->id) === false) {
						$sql = "INSERT INTO `user_referral` (`id`, `parentId`, `refId`) VALUES (NULL, '{$parrent->id}', '{$user->id}');";
						$command = \Yii::app()->db->createCommand($sql);
						$command->execute();
					}
				}
						$mail = new PHPMailer();
						$mail->CharSet = "UTF-8";
						$mail->From = 'admin@' . $_SERVER['HTTP_HOST'];      // от кого email
						$mail->FromName = $_SERVER['HTTP_HOST'];   // от кого имя
						$mail->AddAddress($user->email, '');
						$mail->IsHTML(true);        // выставляем формат письма HTML
						$mail->Subject = 'Регистрация на сайте ' . $_SERVER['HTTP_HOST'];  // тема письма
						$mail->Body = 'Спасибо за регистрацию, для подтверждения Вашей учетной записи <br>
						перейдите по адресу <a href="http://' . $_SERVER['HTTP_HOST'] . '/cabinet/confirm?code=' . $user->authCode . '">Ссылке</a>';
						if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo);
						
						$success = true;
                if (Yii::app()->request->isAjaxRequest) {
                    echo 'Спасибо за регистрацию';
                    exit;
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


        $this->render($this->theme . 'registration', array('errors' => $errors, 'success' => $success));
    }

    public function actionIndex()
    {
        $this->menu['/']['class'] = 'active';

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->condition = 't.userId = :userId';
        $criteria->params = array(':userId' => $this->user->id);
        $count = UserSite::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $products = UserSite::model()->findAll($criteria);

        $this->render($this->theme . 'index', array('products' => $products, 'pages' => $pages));
    }

	public function actionDeleteSite($id)
    {
        $model = UserSite::model()->findByPk($id);

        if ((empty($model->id) === false && $model->userId == $this->user->id) || $this->user->role == 1) {
            $model->delete();
        }

		$this->redirect(Yii::app()->params['baseUrl']);
        Yii::app()->end();
    }
	
    public function actionAddSite()
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;

        if (Yii::app()->request->isPostRequest === true) {
            $model = new UserSite();
            $model->userId = $this->user->id;
            $model->attributes = $_POST;
            if ($model->validate()) {
                $model->save();
                $this->redirect(Yii::app()->params['baseUrl'] . '/default/editSite/' . $model->id);
            } else {
                $errors = $model->getErrors();
            }
        }

        $this->render($this->theme . 'addSite', array('errors' => $errors));
    }

    public function actionEditSite($id)
    {
        $this->menu['/']['class'] = 'active';
        $errors = false;

        $model = UserSite::model()->findByPk($id);
        $this->render($this->theme . 'editSite', array('model' => $model, 'errors' => $errors));
    }

    public function actionActivateSite()
    {
        $id = $_POST['id'];

        $model = UserSite::model()->findByPk($id);
        if (empty($model->url)) {
            echo json_encode(array('error' => 'Ошибка при проверке сайта'));
            exit;
        }

		if (isset($_POST['force']) && $_POST['force'] == 1) {
			$model->active = 1;
            if ($model->validate() === false) {
                echo json_encode(array('error' => $model->getErrors()));
            } else {
                $model->save();
                echo json_encode(array('error' => 0));
            }
            exit;
		}

        $pattern = $_POST['script'];
        $response = $this->_curlGetContent($model->url);

    	if ($response === false) {
			echo json_encode(array('error' => 'Невозможно соедениться с сайтом.'));
            exit;
		}

        if(strpos($response, $pattern) !== false) {
            $model->active = 1;
            $model->save();
            echo json_encode(array('error' => 0));
            exit;
        }

        echo json_encode(array('error' => 'Код не найден на сайте.'));
        exit;
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

        if ($_POST['generate'] == 'true') {
            $realLink = explode('/', $_POST['url']);
            $realLink = end($realLink);

            $statistic = StatisticsLink::model()->with('link')->find(
                'link.link = :realLink AND link.userId = :userId',
                array(':realLink' => $realLink, ':userId' => $this->user->id)
            );

            if (empty($statistic->id) === false) {
                $statistic->active = 1;
                $statistic->save();
            }
        }

        $order = new Orders();
        $order->USER_LOGIN = $this->user->username;
        $order->ORDER_TYPE = $product->id;
        $order->RUN_COUNT = $_POST['count'] * $product->countPrice;
        $order->URL = $_POST['url'];
        $order->DATE_TIME = date('Y-m-d H;i:s', time());
        $order->URL_RESULT = null;
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
        $this->render($this->theme . 'purchase', array('type' => $type, 'orders' => $orders, 'pages' => $pages));
    }

    public function actionNews()
    {
        $this->menu['/news']['class'] = 'active';
        $this->render($this->theme . 'news');
    }
    
    public function actionHelp()
    {
        $this->menu['/help']['class'] = 'active';
        $this->render($this->theme . 'help');
    }

    public function actionBalance()
    {
        $this->menu['/balance']['class'] = 'active';

        $transaction = false;
        $error = false;
        $action = false;
        $currencyCash = Interkassa::getCurrencyCash();

        if (Yii::app()->request->isPostRequest === true) {
            if (isset($_POST['system']) && isset($_POST['amount']) && (float) $_POST['amount'] > 0) {
                $settings = Interkassa::$_paymentSettings[$_POST['system']];

                if ($_POST['system'] == Interkassa::INTERKASSA_SYSTEM_RUR || $_POST['system'] == Interkassa::INTERKASSA_SYSTEM_UAH)
                {
                    switch ($_POST['system']) {
                        case Interkassa::INTERKASSA_SYSTEM_RUR:
                            $amount = round($_POST['amount'] / $currencyCash['USD_RUR'], 2);
                            $currency = 'RUR';
                            break;
                        case Interkassa::INTERKASSA_SYSTEM_UAH:
                            $amount = round($_POST['amount'] / $currencyCash['USD_UAH'], 2);
                            $currency = 'UAH';
                            break;
                        default:
                            $amount = round($_POST['amount'] / $currencyCash['USD_RUR'], 2);
                            $currency = 'RUR';
                            break;
                    }

                    $transaction = new Interkassa();
                    $transaction->amount = (float) $amount;
                    $transaction->payAmount = (float) round($_POST['amount'], 2);
                    $transaction->currency = $currency;
                    $transaction->userId = $this->user->id;
                    $transaction->description = 'Пополнение баланса на сайте ' . Yii::app()->params['baseUrl'] . ' на сумму '
                        . $amount . Yii::app()->params['currency'];
                    $transaction->status = Interkassa::STATUS_NEW;
                    $transaction->date = date('Y-m-d H:i:s', time());
                    $transaction->system = Interkassa::$_paymentSettings[$_POST['system']]['system'];
                    if ($transaction->validate()) {
                        $transaction->save();
                    } else {
                        $error = $transaction->getErrors();
                        $transaction = false;
                    }
                }

                if ($_POST['system'] == Interkassa::WM_SYSTEM || $_POST['system'] == Interkassa::WM_SYSTEM_RUR || $_POST['system'] == Interkassa::WM_SYSTEM_UAH)
                {
                    switch ($_POST['system']) {
                        case Interkassa::WM_SYSTEM:
                            $amount = round($_POST['amount'], 2);
                            $currency = 'USD';
                            break;
                        case Interkassa::WM_SYSTEM_RUR:
                            $amount = round($_POST['amount'] / $currencyCash['USD_RUR'], 2);
                            $currency = 'RUR';
                            break;
                        case Interkassa::WM_SYSTEM_UAH:
                            $amount = round($_POST['amount'] / $currencyCash['USD_UAH'], 2);
                            $currency = 'UAH';
                            break;
                        default:
                            $amount = round($_POST['amount'] / $currencyCash['USD_RUR'], 2);
                            $currency = 'RUR';
                            break;
                    }

                    $transaction = new Interkassa();
                    $transaction->amount = (float) $amount;
                    $transaction->payAmount = (float) round($_POST['amount'], 2);
                    $transaction->currency = $currency;
                    $transaction->userId = $this->user->id;
                    $transaction->description = 'Пополнение баланса';
                    $transaction->status = Interkassa::STATUS_NEW;
                    $transaction->date = date('Y-m-d H:i:s', time());
                    $transaction->system = Interkassa::$_paymentSettings[$_POST['system']]['system'];
                    if ($transaction->validate()) {
                        $transaction->save();
                    } else {
                        $error = $transaction->getErrors();
                        $transaction = false;
                    }
                }

                $this->layout = false;
                $this->render($this->theme . 'redirect-form', array('system' => $transaction->system, 'amount' => $_POST['amount'], 'transaction' => $transaction, 'settings' => $settings));
                Yii::app()->end();
            }
        }

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
		

        $this->render($this->theme . 'balance', array('transaction' => $transaction, 'error' => $error, 'action' => $action, 'currencyCash' => $currencyCash));
    }

    public function actionRefill($id)
    {
    if (empty($_POST) === false) {
            switch ($id) {
                case 1: $this->redirect(Yii::app()->params['baseUrl'] . '/balance?action=1');
                    break;
                case 2: $this->redirect(Yii::app()->params['baseUrl'] . '/balance?action=2');
                    break;
                case 3: Interkassa::result($_POST);
                    break;
                case 4: 
					Interkassa::wm($_POST);
//					$amount = $_POST['LMI_PAYMENT_AMOUNT'];
//					$order_id = $_POST['LMI_PAYMENT_NO'];
//					$transaction = new Interkassa();
//					$transaction->amount = $amount;
//					$transaction->userId = $order_id;
//					$transaction->status = 1;
//					$transaction->date = date('Y-m-d H:i:s', time());
//					$transaction->save();
				
                    break;
                default: Interkassa::result($_POST);
            }
        } else  { echo 'no';}
        exit;
    }

    public function actionChangeLink($id)
    {
        $this->menu['/statistics']['class'] = 'active';
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
        }

        $link = GeneratedLink::model()->with('statistic')->find(
            't.id = :id',
            array(':id' => $id)
        );

        $this->render($this->theme . 'changeLink', array('link' => $link, 'save' => $save));
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
     * Статистика.
     */
    public function actionStatistics($id = false)
    {
        $this->menu['/statistics']['class'] = 'active';

        // Тащим сайты юзера
        $sites = UserSite::model()->findAll('userId = :userId', array(':userId' => $this->user->id));

        if ($id === false) {
            $default = $sites[0];
        } else {
            foreach ($sites as $item) {
                if($item->id == $id) {$default = $item;}
            }
        }

        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->condition = 't.siteId = :siteId';
        $criteria->params = array(':siteId' => $default->id);
        $count = UserIdentifying::model()->count($criteria);

        $pages = new CPagination($count);
        // элементов на страницу
        $pages->pageSize = 25;
        $pages->applyLimit($criteria);

        $identify = UserIdentifying::model()->findAll($criteria);

        $this->render($this->theme . 'statistic', array('identify' => $identify, 'sites' => $sites, 'pages' => $pages, 'default' => $default));
    }

    /**
     * Генерация ссылки.
     */
    public function actionGenerateLink()
    {
        if ($_POST['action'] === 'true') {
            $url = $_POST['url'];
            $linkData = GeneratedLink::generate($this->user->id);

            $statistic = new StatisticsLink();
            $statistic->linkId = $linkData['id'];
            $statistic->url = $url;
            $statistic->active = 0;
            $statistic->save();

            echo json_encode(array('link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $linkData['link']));
            exit;
        } else {
            $realLink = explode('/', $_POST['url']);
            $realLink = end($realLink);

            $link = GeneratedLink::model()->with('statistic')->find(
                't.link = :realLink AND t.userId = :userId',
                array(':realLink' => $realLink, ':userId' => $this->user->id)
            );

            if (empty($link->id) === false) {
                $linkData['link'] = $link->statistic[0]->url;
                $link->delete();
            }

            echo json_encode(array('link' => $linkData['link']));
            exit;
        }
    }

	public function actionReferrals()
	{
        $this->menu['/referrals']['class'] = 'active';
		$referrals = $this->user->referrals;

		$this->render($this->theme . 'referrals', array('referrals' => $referrals));
	}

    public function actionQuestions()
    {
        $this->menu['/questions']['class'] = 'active';
        if (empty($_POST['message']) === false) {
            $question = new Question();
            $question->userId = $this->user->id;
            $question->date = date('Y-m-d H:i:s', time());
            $question->save();

            $questionMessage = new QuestionMessage();
            $questionMessage->questionId = $question->id;
            $questionMessage->type = QuestionMessage::TYPE_USER;
            $questionMessage->message = $_POST['message'];
            $questionMessage->date = date('Y-m-d H:i:s', time());
            $questionMessage->save();
        }

        $questions = Question::model()->findAll('userId = :userId AND active = 1', array(':userId' => $this->user->id));
        $this->render($this->theme . 'questions', array('questions' => $questions));
    }

    public function actionMessageList($id)
    {
        $this->menu['/questions']['class'] = 'active';

        $question = Question::model()->findByPk($id);
        if (empty($_POST['message']) === false) {
            $questionMessage = new QuestionMessage();
            $questionMessage->questionId = $question->id;
            $questionMessage->type = QuestionMessage::TYPE_USER;
            $questionMessage->message = $_POST['message'];
            $questionMessage->date = date('Y-m-d H:i:s', time());
            $questionMessage->save();
        }

        $this->render($this->theme . 'messageList', array('question' => $question));
    }

	public function actionCheckNewEvent()
	{
        if ($this->user->role == 1) {
            $question = Question::model()->find('id > 0 order by id desc');

            if (
                empty($question) === false &&
                $question->read == 0 &&
                strtotime($question->date) >= (time() - 120)
            ) {
                $question->read = 1;
                $question->save();
                echo json_encode(array('question' => mb_substr($question->messages[0]->message, 0, 64)));
                exit;
            }

            $order = Orders::model()->find('id > 0 order by id desc');
            if (
                empty($order) === false &&
                $order->read == 0 &&
                strtotime($order->DATE_TIME) >= (time() - 120)
            ) {
                $order->read = 1;
                $order->save();
                echo json_encode(array('order' => $order->USER_LOGIN));
                exit;
            }

            $delivery = Delivery::model()->find('id > 0 order by id desc');
            if (
                empty($delivery) === false &&
                $delivery->read == 0 &&
                strtotime($delivery->date) >= (time() - 120)
            ) {
                $delivery->read = 1;
                $delivery->save();
                echo json_encode(array('delivery' => $delivery->user->username));
                exit;
            }

            $purchase = Purchase::model()->find('id > 0 order by id desc');
            if (
                empty($purchase) === false &&
                $purchase->read == 0 &&
                strtotime($purchase->date) >= (time() - 120)
            ) {
                $purchase->read = 1;
                $purchase->save();
                echo json_encode(array('purchase' => $purchase->user->username));
                exit;
            }
        }

        if ($this->user->role == 0) {
            $order = Orders::model()->find('USER_LOGIN = :username AND informed = 0 AND ORDER_STATE = 2', array(':username' => $this->user->username));
            if (
                empty($order) === false
            ) {
                $order->informed = 1;
                $order->save();
                echo json_encode(array('informed' => $order->URL));
                exit;
            }
        }
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

	protected function GenCode(){
        return rand(10000000, 99999999);
    }

    protected function _curlGetContent($url)
    {
        $curl = curl_init();
        $f = fopen(__DIR__ . '/../runtime/request.txt', 'w');
        curl_setopt($curl, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //запрещаем делать запрос с помощью POST и соответственно разрешаем с помощью GET
        //curl_setopt($curl, CURLOPT_POST, 0);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/../runtime/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/../runtime/cookie.txt');
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Connection: keep-alive',
                'Keep-Alive: 300'
            ));
		curl_setopt ($curl, CURLOPT_STDERR, $f);
		curl_setopt ($curl, CURLOPT_VERBOSE, 1);
        $response = curl_exec($curl);

        if (empty($response) === true) {
            return false;
        }

        curl_close($curl);
        return $response;
    }
}
