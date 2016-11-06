<?php

/**
 * Модель для таблицы 'softCode'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $productId
 * @property string $code
 */
class SoftCode extends \CActiveRecord
{
    const ERROR_EMPTY_CODE = 'Извените у нас закончились ключи! Попробуйте позже...';

    /**
     * Возвращает название таблицы.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function tableName()
    {
        return 'softCode';
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
            array('code', 'length', 'max' => 255),
            array('productId', 'length', 'max' => 10),
            array('code, productId', 'required'),
            // Правила валидации для поиска.
            [
                'id, productId, code',
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
            'product' => array(self::BELONGS_TO, 'Product', 'productId'),
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
            'productId' => \Yii::t('main', 'productId'),
            'code' => \Yii::t('main', 'Code'),
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
        $criteria->compare('productId', $this->productId, true);
        $criteria->compare('code', $this->code, true);

        return new \CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return SoftCode
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
}
