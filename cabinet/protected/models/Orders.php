<?php
/**
 * Модель для таблицы 'orders'.
 *
 * Доступны следующие поля:
 *
 * @property integer $iD
 * @property string $uSERLOGIN
 * @property integer $oRDERTYPE
 * @property integer $rUNCOUNT
 * @property string $uRL
 * @property string $dATETIME
 * @property string $uRLRESULT
 * @property integer $oRDERSTATE
 * @property integer $read	
 * @property integer $informed
 */
class Orders extends \CActiveRecord
{
    const STATUS_NEW = 0;

    const STATUS_PROCESS = 1;

    const STATUS_COMPLETE = 2;

    const ERROR_MONEY = 'Недостаточно денег на счету!';

    public static $status = array(
        0 => 'не обработан',
        1 => 'в обработке',
        2 => 'завершен'
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
        return 'orders';
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
            array('ID, ORDER_TYPE, RUN_COUNT, ORDER_STATE', 'numerical', 'integerOnly' => true),
            array('USER_LOGIN', 'length', 'max' => 50),
            array('URL, URL_RESULT', 'length', 'max' => 255),
            array('DATE_TIME', 'safe'),
            // Правила валидации для поиска.
            [
                'ID, USER_LOGIN, ORDER_TYPE, RUN_COUNT, URL, DATE_TIME, URL_RESULT, ORDER_STATE, read, informed',
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
            'product' => array(self::BELONGS_TO, 'Product', 'ORDER_TYPE'),
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
            'ID' => \Yii::t('main', 'ID'),
            'USER_LOGIN' => \Yii::t('main', 'User Login'),
            'ORDER_TYPE' => \Yii::t('main', 'Order Type'),
            'RUN_COUNT' => \Yii::t('main', 'Run Count'),
            'URL' => \Yii::t('main', 'Url'),
            'DATE_TIME' => \Yii::t('main', 'Date Time'),
            'URL_RESULT' => \Yii::t('main', 'Url Result'),
            'ORDER_STATE' => \Yii::t('main', 'Order State'),
            'read' => \Yii::t('main', 'read'),
            'informed' => \Yii::t('main', 'informed'),
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

        $criteria->compare('ID', $this->ID, true);
        $criteria->compare('USER_LOGIN', $this->USER_LOGIN, true);
        $criteria->compare('ORDER_TYPE', $this->ORDER_TYPE, true);
        $criteria->compare('RUN_COUNT', $this->RUN_COUNT, true);
        $criteria->compare('URL', $this->URL, true);
        $criteria->compare('DATE_TIME', $this->DATE_TIME, true);
        $criteria->compare('URL_RESULT', $this->URL_RESULT, true);
        $criteria->compare('ORDER_STATE', $this->ORDER_STATE, true);
        $criteria->compare('read', $this->read, true);
        $criteria->compare('informed', $this->informed, true);

        return new \CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Orders
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
}
