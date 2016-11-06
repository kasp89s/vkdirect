<?php

/**
 * Модель для таблицы 'generated_link'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $linkId
 * @property string $url
 * @property string $active
 * @property string $count
 */
class StatisticsLink extends \CActiveRecord
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
        return 'statistics_link';
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
            array('url', 'length', 'max' => 255),
            array('count', 'length', 'max' => 10),
            array('linkId, url', 'required'),
            // Правила валидации для поиска.
            [
                'id, linkId, url, active, count',
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
            'link' => array(self::BELONGS_TO, 'GeneratedLink', 'linkId'),
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
            'linkId' => \Yii::t('main', 'linkId'),
            'url' => \Yii::t('main', 'url'),
            'active' => \Yii::t('main', 'active'),
            'count' => \Yii::t('main', 'count'),
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
        $criteria->compare('linkId', $this->linkId, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('active', $this->active, true);
        $criteria->compare('count', $this->count, true);

        return new \CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return Coupon
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
}
