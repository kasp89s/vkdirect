<?php
/**
 * Модель для таблицы 'product'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $title
 * @property string $price
 * @property integer $countPrice
 * @property string $description
 * @property string $url
 * @property string $activateKey
 * @property string $type
 * @property integer $status
 */
class Product extends \CActiveRecord
{
    /**
     * Возвращает название таблицы.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function tableName()
    {
        return 'product';
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
            array('countPrice, status, sort', 'numerical', 'integerOnly' => true),
            array('title, url, productUrl, activateKey', 'length', 'max' => 255),
            array('price, type, sort', 'length', 'max' => 10),
            array('description', 'safe'),
            array('countPrice, price, title, type', 'required'),
            array('url','required','on'=>'buy'),
            // Правила валидации для поиска.
            array(
                'id, title, price, countPrice, description, url, productUrl, activateKey, type, sort, status',
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
            'keys' => array(self::HAS_MANY, 'SoftCode', 'productId'),
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
            'title' => \Yii::t('main', 'Название'),
            'price' => \Yii::t('main', 'Цена'),
            'countPrice' => \Yii::t('main', 'Количество по цене'),
            'description' => \Yii::t('main', 'Описание'),
            'url' => \Yii::t('main', 'Ссылка'),
            'productUrl' => \Yii::t('main', 'Ссылка'),
            'activateKey' => \Yii::t('main', 'Activate Key'),
            'type' => \Yii::t('main', 'Type'),
            'sort' => \Yii::t('main', 'sort'),
            'status' => \Yii::t('main', 'Status'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('countPrice', $this->countPrice);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('productUrl', $this->productUrl, true);
        $criteria->compare('activateKey', $this->activateKey, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('sort', $this->type, true);
        $criteria->compare('status', $this->status);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Product
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
}
