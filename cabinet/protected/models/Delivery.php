<?php
/**
 * Модель для таблицы 'delivery'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $userId
 * @property string $emailBase
 * @property string $senderBase
 * @property string $titleBase
 * @property string $title
 * @property string $email
 * @property string $body
 * @property string $file
 * @property string $macros
 * @property string $type
 * @property string $count
 * @property string $sendCount
 * @property string $tookTime
 * @property string $status
 * @property string $message
 * @property string $date
 * @property string $read
 */
class Delivery extends \CActiveRecord
{
    const STATUS_NEW = 0;

    const STATUS_BUSY = 1;

    const STATUS_ERROR = 3;

    /**
     * Не повторяющиеся адреса
     *
     * @var array
     */
    private static $distinctEmails = array();

    public static $statusTranslate = array(
        0 => 'Создана',
        1 => 'Рассылаеться',
        2 => 'Разослана',
        3 => 'Ошибка в письме',
		4 => 'Письмо пришло - рассылаем',
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
        return 'delivery';
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
            array('userId', 'length', 'max' => 10),
            array('emailBase, senderBase, titleBase, title, email, file, macros', 'length', 'max' => 255),
            array('type', 'length', 'max' => 4),
            array('body', 'safe'),
            // Правила валидации для поиска.
            array(
                'id, userId, emailBase, senderBase, titleBase, title, email, body, file, macros, type, count, sendCount, tookTime, status, message, date, read',
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
            //'state' => array(self::HAS_MANY, 'DeliveryState', 'deliveryId'),
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
            'userId' => \Yii::t('main', 'ID пользователя'),
            'emailBase' => \Yii::t('main', 'Путь к фалу адресов'),
            'senderBase' => \Yii::t('main', 'Sender Base'),
            'titleBase' => \Yii::t('main', 'Путь к файлу тем'),
            'title' => \Yii::t('main', 'Тема если еденичная'),
            'email' => \Yii::t('main', 'Контрольная почта'),
            'body' => \Yii::t('main', 'Тело письма'),
            'file' => \Yii::t('main', 'File'),
            'macros' => \Yii::t('main', 'macros'),
            'type' => \Yii::t('main', 'Type'),
            'count' => \Yii::t('main', 'count'),
            'sendCount' => \Yii::t('main', 'sendCount'),
            'tookTime' => \Yii::t('main', 'tookTime'),
            'status' => \Yii::t('main', 'status'),
            'date' => \Yii::t('main', 'date'),
            'read' => \Yii::t('main', 'read'),
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
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('emailBase', $this->emailBase, true);
        $criteria->compare('senderBase', $this->senderBase, true);
        $criteria->compare('titleBase', $this->titleBase, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('macros', $this->macros, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('count', $this->count, true);
        $criteria->compare('sendCount', $this->sendCount, true);
        $criteria->compare('tookTime', $this->tookTime, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('read', $this->read, true);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Delivery
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }

    public static function getEmailBaseInfo($file)
    {
        if(!is_file($file)) {
            return false;
        }
        $tmp = '';
        $handle = fopen($file, "r");
        if ($handle) {
            while (($buffer = fgets($handle)) !== false) {
                if (stripos($buffer, '@') !== false) {
                    self::$distinctEmails[$buffer] = 1;
                }
            }

            if (!feof($handle)) {
                throw new Exception('Error: unexpected fgets() fail');
            }
            fclose($handle);
        }

        foreach (self::$distinctEmails as $email => $value) {
            $tmp.= $email;
        }

        file_put_contents($file, $tmp);

        return count(self::$distinctEmails);
    }

    public static function makeDistinct()
    {

    }

    /**
     * Проверяет достаточно ли у пользователя на счету средств для рассылки.
     *
     * @param $count
     * @param $settings
     * @param User $user
     * @return array|bool
     */
    public static function validateAmount($count, $settings, User $user)
    {
        $amount = self::calculateDeliveryPrice($count, $settings, isset($_FILES['attachment']['name']) ? 1 : null);

            if ($user->balance < $amount) {
                return array('money' => 'У вас не достаточно средств!');
            }

        return false;
    }

	/**
	* Считает стоимость расслки.
	*
	*/
    public static function calculateDeliveryPrice($count, $settings, $attachment)
    {
		if($attachment == null) {
			$price = $settings['deliveryPrice']->key;
            $countOnPrice = $settings['deliveryPrice']->value;
		} else {
			$price = $settings['deliveryMacrosPrice']->key;
            $countOnPrice = $settings['deliveryMacrosPrice']->value;
		}

		$amount = $count / $countOnPrice;
        if ($amount < 1) {
            $amount = 1;
        } else {
            if ($amount != $count / $countOnPrice) {
                $amount+= 1;
            }
        }
		
		return $price * $amount;
    }

    /**
     * Произвольная валидация.
     */
    public static function customValidate($data)
    {
        $errors = false;
        if ((empty($data['senderBaseLink']) || $data['senderBaseLink'] == '') && empty($data['generateDomain']) === true) {
            $errors['senderBaseLink'] = 'Не загружена база отправителей, либо не выбрана генерация.';
        }
        if ((empty($data['titleBase']) || $data['titleBase'] == '') && (empty($data['title']) || $data['title'] == '')) {
            $errors['titleBaseLink'] = 'Не загружен список тем либо укажите тему.';
        }
        if ((empty($data['emailBaseLink']) || $data['emailBaseLink'] == '')) {
            $errors['emailBaseLink'] = 'Не загружена база получателей.';
        }
        if (empty($data['email']) || $data['email'] == '') {
            $errors['email'] = 'Не указан контрольный email.';
        }
        if (empty($data['body_' . $data['type']]) || $data['body_' . $data['type']] == '') {
            $errors['body'] = 'Не указан контент письма в формате ' . $data['type'];
        }

        return $errors;
    }

    /**
     * Генерирует список отправителей.
     *
     * @param $domain
     * @param $count
     * @return string
     */
    public static function generateSenderBase($domain, $count)
    {
        $tmp = '';

        for ($i = 0; $i < $count; $i++) {
            $tmp.= self::generate(10) . $domain . "\n";
        }

        return $tmp;
    }

    private static function generate($length = 8){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}
