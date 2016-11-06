<?php

/**
 * Модель для таблицы 'interkassa'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $amount
 * @property string $payAmount
 * @property string $currency
 * @property integer $userId
 * @property string $description
 * @property integer $status
 * @property string $date
 */
class Interkassa extends \CActiveRecord
{
    const SHOP_ID = '55ba38313b1eafb8518b4569';

    const PAY_URL = 'https://sci.interkassa.com/';

    const STATUS_NEW = 0;

    const STATUS_COMPLETE = 1;

    const STATUS_ERROR = 2;

    const WM_SYSTEM = '1';
    const WM_SYSTEM_RUR = '1.1';
    const WM_SYSTEM_UAH = '1.2';

    const INTERKASSA_SYSTEM_RUR = '2.1';
    const INTERKASSA_SYSTEM_UAH = '2.2';

    private static $systemStatus = array(
        'success' => self::STATUS_COMPLETE,
        'canceled' => self::STATUS_ERROR,
    );

    /**
     * Настройки Webmoney.
     */
    public static $_paymentSettings = array(
        self::WM_SYSTEM => array(
            'system' => 'webmoney',
            'keeper' => 'Z218987269112',
        ),
        self::WM_SYSTEM_RUR => array(
            'system' => 'webmoney',
            'keeper' => 'R389444715550',
        ),
        self::WM_SYSTEM_UAH => array(
            'system' => 'webmoney',
            'keeper' => 'U129273841141',
        ),
        self::INTERKASSA_SYSTEM_UAH => array(
            'system' => 'interkassa',
            'shopId' => '55ba38433b1eaf0f538b4569',
            'secretKey' => 'GMFT2i55zSnLHamv',
//            'secretKey' => '5ZpJR7XgnxY5LWeQ',
        ),
        self::INTERKASSA_SYSTEM_RUR => array(
            'system' => 'interkassa',
            'shopId' => '55ba38313b1eafb8518b4569',
            'secretKey' => 'IwqfXKanVJ98CejR',
//            'secretKey' => 'uf2zW1wYDTGZ1FHL',
        ),
    );

    /**
     * Возвращает название таблицы.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function tableName()
    {
        return 'interkassa';
    }

    /**
     * Генерирует правила валидации полей.
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function rules()
    {
        return array(
            // Основные правила валидации.
            array('userId', 'required'),
            array('userId, status', 'numerical', 'integerOnly' => true),
            array('id, amount, payAmount, currency', 'length', 'max' => 10),
            array('description', 'length', 'max' => 255),
            array('systemId, system', 'length', 'max' => 64),
            array('date', 'safe'),
            // Правила валидации для поиска.
            array(
                'id, systemId, system, currency, amount, payAmount, userId, description, status, date',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     * Генерирует массив связей с другими моделями.
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * Именование полей моделей.
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function attributeLabels()
    {
        return array(
            'id' => \Yii::t('main', 'ID'),
            'systemId' => \Yii::t('main', 'systemId'),
            'system' => \Yii::t('main', 'system'),
            'amount' => \Yii::t('main', 'Amount'),
            'payAmount' => \Yii::t('main', 'payAmount'),
            'currency' => \Yii::t('main', 'currency'),
            'userId' => \Yii::t('main', 'User'),
            'description' => \Yii::t('main', 'Description'),
            'status' => \Yii::t('main', 'Status'),
            'date' => \Yii::t('main', 'Date'),
        );
    }

    /**
     * Возвращает список моделей, основанный на текущих условиях поиска/фильтрации.
     *
     * Используется:
     * - Инициализация полей модели с значениями формы фильтрации.
     * - Получение образца \CActiveDataProvider с филтрами.
     * - Отправка данных в \CGridView, \CListView или другие виджеты.
     *
     * @return \CActiveDataProvider
     *
     * @codeCoverageIgnore
     */
    public function search()
    {
        $criteria = new \CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('systemId', $this->systemId, true);
        $criteria->compare('system', $this->system, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('payAmount', $this->payAmount, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('userId', $this->userId);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date', $this->date, true);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Interkassa
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
	
	public static function wm($data)
    {
	
	/*
		if(isset($data['LMI_PREREQUEST']) && $data['LMI_PREREQUEST']==1)
		{
			$pre_request = 1;
		}
		else
		{
			$pre_request = 0;
		}

		
		// Кошелек продавца
		// Кошелек продавца, на который покупатель совершил платеж. Формат - буква и 12 цифр.
		$merchant_purse = $data['LMI_PAYEE_PURSE'];

		// Сумма платежа
		// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
		
			   
		// Внутренний номер покупки продавца
		// В этом поле передается id заказа в нашем магазине.
		

		// Флаг тестового режима
		// Указывает, в каком режиме выполнялась обработка запроса на платеж. Может принимать два значения: 
		// 0: Платеж выполнялся в реальном режиме, средства переведены с кошелька покупателя на кошелек продавца; 
		// 1: Платеж выполнялся в тестовом режиме, средства реально не переводились.
		$test_mode = $data['LMI_MODE'];

		// Внутренний номер счета в системе WebMoney Transfer
		// Номер счета в системе WebMoney Transfer, выставленный покупателю от имени продавца
		// в процессе обработки запроса на выполнение платежа сервисом Web Merchant Interface.
		// Является уникальным в системе WebMoney Transfer.
		$wm_order_id = $data['LMI_SYS_INVS_NO'];

		// Внутренний номер платежа в системе WebMoney Transfer
		// Номер платежа в системе WebMoney Transfer, выполненный в процессе обработки запроса
		// на выполнение платежа сервисом Web Merchant Interface.
		// Является уникальным в системе WebMoney Transfer.
		$wm_transaction_id = $data['LMI_SYS_TRANS_NO'];

		// Кошелек покупателя
		// Кошелек, с которого покупатель совершил платеж.
		$payer_purse = $data['LMI_PAYER_PURSE'];

		// WMId покупателя
		// WM-идентификатор покупателя, совершившего платеж.
		$payer_wmid = $data['LMI_PAYER_WM'];

		// Номер ВМ-карты (электронного чека)
		// Номер чека Paymer.com или номер ВМ-карты, присутствует только в случае,
		// если покупатель производит оплату чеком Пеймер или ВМ-картой.
		$paymer_number = $data['LMI_PAYMER_NUMBER'];


		// Paymer.com e-mail покупателя
		// Email указанный покупателем, присутствует только в случае,
		// если покупатель производит оплату чеком Paymer.com или ВМ-картой.
		$paymer_email = $data['LMI_PAYMER_EMAIL'];

		// Номер телефона покупателя
		// Номер телефона покупателя, присутствует только в случае,
		// если покупатель производит оплату с телефона в Keeper Mobile.
		$mobile_keeper_phone = $data['LMI_TELEPAT_PHONENUMBER'];

		// Номер платежа в Keeper Mobile
		// Номер платежа в Keeper Mobile, присутствует только в случае,
		// если покупатель производит оплату с телефона в Keeper Mobile.
		$mobile_keeper_order_id = $data['LMI_TELEPAT_ORDERID'];

		// Срок кредитования	LMI_PAYMENT_CREDITDAY
		// В случае если покупатель платит с своего кошелька типа C на кошелек продавца типа D
		// (вариант продажи продавцом своих товаров или услуг в кредит), в данном параметре указывается срок кредитования в днях.
		// Настоятельно рекомендуем обязательно проверять сооветствие данного параметра
		// в форме оповещения о платеже значению параметра в форме запроса платежа.
		$credit_days = $data['LMI_PAYMENT_CREDITDAYS'];

		// Контрольная подпись
		$hash = $data['LMI_HASH'];

		// Дата и время выполнения платежа
		// Дата и время реального прохождения платежа в системе WebMoney Transfer в формате "YYYYMMDD HH:MM:SS"
		$date = $data['LMI_SYS_TRANS_DATE'];


		// Метод оплаты
		$payment_method_id = $data['PAYMENT_METHOD_ID'];
		*/

		if(isset($data['LMI_PREREQUEST']) && $data['LMI_PREREQUEST']==1) {
			$pre_request = 1;
		} else {
			$pre_request = 0;
		}
		
		$amount = $data['LMI_PAYMENT_AMOUNT'];
		$order_id = $data['LMI_PAYMENT_NO'];
		$systemId = $data['LMI_SYS_TRANS_NO'];
		$transaction = self::model()->findByPk($order_id);
		$transaction->systemId = $systemId;
        $transaction->status = self::STATUS_COMPLETE;
        $transaction->save();
		if(!$pre_request && empty($transaction->id) === false) {
                $refillBonus = Refill::model()->find('t.min <= :amount and t.max >= :amount', array(':amount' => $transaction->amount));

                if (empty($refillBonus->id) === false) {
                    $refillAmount = $transaction->amount + ($transaction->amount / 100 * $refillBonus->bonus);
                } else {
                    $refillAmount = $transaction->amount;
                }

                $user = User::model()->findByPk($transaction->userId);
                if (empty($user->id) === true) {
                    $transaction->status == self::STATUS_ERROR;
                    $transaction->save();
                    return false;
                }

                $user->balance+= $refillAmount;
                $user->save(false);
				
				User::payToMyParrent($user->id, $refillAmount);
		}
    }
	
	 public static function result($data)
    {
        if ($data['ik_sign'] == self::generateSign($data, self::$_paymentSettings[self::INTERKASSA_SYSTEM_UAH]['secretKey']) ||
            $data['ik_sign'] == self::generateSign($data, self::$_paymentSettings[self::INTERKASSA_SYSTEM_RUR]['secretKey'])) {
            $transaction = self::model()->findByPk($data['ik_pm_no']);

            if (empty($transaction->id) === true) {
                return false;
            }

            if ($transaction->status == self::STATUS_COMPLETE) {
                return false;
            }

            $transaction->systemId = $data['ik_inv_id'];
            $transaction->status = self::$systemStatus[$data['ik_inv_st']];
            $transaction->save();

            if ($transaction->status == self::STATUS_COMPLETE) {
                $refillBonus = Refill::model()->find('t.min <= :amount and t.max >= :amount', array(':amount' => $transaction->amount));

                if (empty($refillBonus->id) === false) {
                    $refillAmount = $transaction->amount + ($transaction->amount / 100 * $refillBonus->bonus);
                } else {
                    $refillAmount = $transaction->amount;
                }

                $user = User::model()->findByPk($transaction->userId);
                if (empty($user->id) === true) {
                    $transaction->status == self::STATUS_ERROR;
                    $transaction->save();
                    return false;
                }

                $user->balance+= $refillAmount;
                $user->save(false);
				
				User::payToMyParrent($user->id, $refillAmount);
            }
        }
    }

    private static function generateSign($data, $key)
    {
        unset($data['ik_sign']);// удаляем из данных строку подписи
        ksort($data, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
        array_push($data, $key); // добавляем в конец массива "секретный ключ"
        $signString = implode(':', $data); // конкатенируем значения через символ ":"
        $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по

        //сформированной строке и кодируем в BASE64
        return $sign;
    }

	// Wm
	
    private static function generateSignWm($data)
    {
        unset($data['ik_sign']);// удаляем из данных строку подписи
        ksort($data, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
        array_push($data, self::SECRET_KEY); // добавляем в конец массива "секретный ключ"
        $signString = implode(':', $data); // конкатенируем значения через символ ":"
        $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по

        //сформированной строке и кодируем в BASE64
        return $sign;
    }

    public static function getCurrencyCash()
    {
        $currencyCash = file_get_contents('https://privat24.privatbank.ua/p24/accountorder?oper=prp&PUREXML&apicour&country=ru');
        $currencyCash = new SimpleXMLElement($currencyCash);

        $result = array();
        foreach($currencyCash as $item){
            $result[(string) $item["ccy"] . '_RUR'] = round((int)$item["buy"] / 10000, 2);
        }

        $currencyCash = file_get_contents('https://privat24.privatbank.ua/p24/accountorder?oper=prp&PUREXML&apicour&country=ua');
        $currencyCash = new SimpleXMLElement($currencyCash);
        foreach($currencyCash as $item){
            $result[(string) $item["ccy"] . '_UAH'] = round((int)$item["buy"] / 1000000, 2);
        }

        return $result;
    }
}
