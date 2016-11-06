<?php
/**
 * Модель для таблицы 'purchase'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $userId
 * @property string $region
 * @property integer $count
 * @property string $sex
 * @property string $form
 * @property string $to
 * @property integer $online
 * @property integer $price
 * @property string $date
 * @property integer $status
 * @property string $execution
 * @property string $read
 */
class Purchase extends \CActiveRecord
{
    const STATUS_NEW = 0;

    const STATUS_BUSY = 1;

    const STATUS_COMPLETE = 2;

    public static $sex = array(
        'all' => 'Любой',
        'male' => 'Мужской',
        'female' => 'Женский',
    );

    public static $status = array(
        0 => 'Создана',
        1 => 'Запущена',
        2 => 'Завершена',
    );

    public static $online = array(
        0 => 'Нет',
        1 => 'Да',
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
        return 'purchase';
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
        return [
            // Основные правила валидации.
            array('id, userId', 'required'),
            array('count, online, price, status, from, to', 'numerical', 'integerOnly' => true),
            array('id, userId', 'length', 'max' => 10),
            array('region', 'length', 'max' => 255),
            array('sex', 'length', 'max' => 6),
            array('execution', 'length', 'max' => 64),
            array('date', 'safe'),
            // Правила валидации для поиска.
            [
                'id, userId, region, count, sex, online, price, date, status, execution, from, to, read',
                'safe',
                'on' => 'search'
            ]
        ];
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
        return [
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        ];
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
        return [
            'id' => \Yii::t('main', 'ID'),
            'userId' => \Yii::t('main', 'Ид пользователя.'),
            'region' => \Yii::t('main', 'Регион.'),
            'count' => \Yii::t('main', 'Количество адресов для парса.'),
            'sex' => \Yii::t('main', 'Пол.'),
            'from' => \Yii::t('main', 'from.'),
            'to' => \Yii::t('main', 'to.'),
            'online' => \Yii::t('main', 'Онлайн.'),
            'price' => \Yii::t('main', 'Цена за заказ.'),
            'date' => \Yii::t('main', 'Дата и время.'),
            'status' => \Yii::t('main', 'Статус заказа не запущенн - 0,в процессе - 1, завершен-2'),
            'execution' => \Yii::t('main', 'Приблизительно время выполнения.'),
            'read' => \Yii::t('main', 'read.'),
        ];
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
        $criteria->compare('region', $this->region, true);
        $criteria->compare('count', $this->count);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('form', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('online', $this->online);
        $criteria->compare('price', $this->price);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('execution', $this->execution, true);
        $criteria->compare('read', $this->read, true);

        return new \CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Purchase
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }

    /**
     * Получает масив регионов.
     *
     * @return array
     */
    public static function getRegionList()
    {
        $list = file(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'region.txt');

        return $list;
    }

    /**
     * Произвольная валидация.
     */
    public static function customValidate($data)
    {
        $errors = false;
        if (empty($data['age']['from']) || $data['age']['from'] == '') {
            $errors['from'] = 'Не указан возрасто "от".';
        }
        if (empty($data['age']['to']) || $data['age']['to'] == '') {
            $errors['to'] = 'Не указан возрасто "до".';
        }

        return $errors;
    }
}
