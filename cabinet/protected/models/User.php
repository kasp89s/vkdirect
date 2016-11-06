<?php
/**
 * Created by JetBrains PhpStorm.
 * User: turbo
 * Date: 18.09.14
 * Time: 16:32
 * To change this template use File | Settings | File Templates.
 */
/**
 * Модель для таблицы 'user'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $name
 * @property string $skype
 * @property string $icq
 * @property string $password
 * @property string $balance
 * @property string $role
 * @property string $authCode
 */
class User extends \CActiveRecord
{
    /**
     * Процент начисления при пополнении рефералом.
     */
	const REFERRAL_BONUS = 5;
	
    /**
     * Возвращает название таблицы.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function tableName()
    {
        return 'user';
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
            array('username, password, email', 'required'),
            array('username','unique', 'message'=>'Логин уже занят.'),
            array('email','unique', 'message'=>'email уже занят.'),
            array('username, skype, icq', 'length', 'max' => 64),
            array('email', 'length', 'max' => 128),
            array('email', 'match', 'pattern'    => '/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/', 'message' => 'Не верный формат e-mail адреса.'),
            array('name, password, referralCode', 'length', 'max' => 255),
            array('balance', 'length', 'max' => 10),
            array('authCode', 'length', 'max' => 10),
            array('role', 'length', 'max' => 1),
            // Правила валидации для поиска.
            array(
                'id, username, email, name, skype, icq, password, balance, role, referralCode, authCode',
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
		    'referrals' => array(
                self::MANY_MANY,
                'User',
                'user_referral(parentId, refId)'
            ),
			'parent' => array(
                self::MANY_MANY,
                'User',
                'user_referral(refId, parentId)'
            ),
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
            'username' => \Yii::t('main', 'Username'),
            'email' => \Yii::t('main', 'Email'),
            'name' => \Yii::t('main', 'Name'),
            'skype' => \Yii::t('main', 'Skype'),
            'icq' => \Yii::t('main', 'Icq'),
            'password' => \Yii::t('main', 'Password'),
            'balance' => \Yii::t('main', 'Balance'),
            'role' => \Yii::t('main', 'role'),
            'referralCode' => \Yii::t('main', 'referralCode'),
            'authCode' => \Yii::t('main', 'authCode'),
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('skype', $this->skype, true);
        $criteria->compare('icq', $this->icq, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('balance', $this->balance, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('referralCode', $this->referralCode, true);
        $criteria->compare('authCode', $this->authCode, true);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return User
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }

    public static function verifyPassword($p1, $p2)
    {
        return (self::hashPassword($p1) == $p2) ? true : false;
    }

    public static function hashPassword($password)
    {
        return md5(md5($password));
    }

    public function buy($amount)
    {
        if ($this->balance >= $amount) {
            $this->balance-= $amount;
            $this->save();
            return true;
        }

        return false;
    }

    public function refill($amount)
    {
        $this->balance+= $amount;
        $this->save();
        return true;
    }
	
	public static function generateReferralCode($login, $id)
	{
		return md5($login . $id);
	}
	
	public static function canculateReferalRefill($amount)
	{
		$bonus = round($amount / 100 * self::REFERRAL_BONUS);
		return ($bonus > 1) ? $bonus : 1;
	}
	
	public static function payToMyParrent($userId, $refillAmount)
	{
		$user = self::model()->with('parent')->findByPk($userId);
		$bonus = self::canculateReferalRefill($refillAmount);

		if (empty($user->parent) === false && count($user->parent) > 0) {
			foreach ($user->parent as $parent) {
				$parent->balance+= $bonus;
				$parent->save(false);
			}
		}
	}
    /**
     * Проверяет и создает папку юзера.
     *
     * @param $userId
     */
    public static function checkMyFolder($userId)
    {
        return true;
        if (!file_exists(USER_PATH . DIRECTORY_SEPARATOR . 'u_' . $userId))
        {
            mkdir(USER_PATH . DIRECTORY_SEPARATOR . 'u_' . $userId, 0777);
        }
    }
}
