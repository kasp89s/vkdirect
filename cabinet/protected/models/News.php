<?php
/**
 * Модель для таблицы 'question'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $date
 */
class News extends \CActiveRecord
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
        return 'news';
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
            array('title, content', 'required'),
            array('title, date, type', 'length', 'max' => 255),
            // Правила валидации для поиска.
            [
                'id, title, content, date, type',
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
            'title' => \Yii::t('main', 'title'),
            'content' => \Yii::t('main', 'content'),
            'date' => \Yii::t('main', 'date'),
            'type' => \Yii::t('main', 'type'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('date', $this->date);
        $criteria->compare('type', $this->type);

        return new \CActiveDataProvider($this, ['criteria' => $criteria]);
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
