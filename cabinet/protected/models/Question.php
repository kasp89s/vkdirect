<?php
/**
 * Модель для таблицы 'question'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $userId
 * @property string $date
 * @property string $read
 * @property integer $active
 */
class Question extends \CActiveRecord
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
        return 'question';
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
            array('userId, active', 'numerical', 'integerOnly' => true),
            array('date', 'length', 'max' => 255),
            // Правила валидации для поиска.
            array(
                'id, userId, date, read, active',
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
            'messages' => array(self::HAS_MANY, 'QuestionMessage', 'questionId'),
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
            'userId' => \Yii::t('main', 'userId'),
            'date' => \Yii::t('main', 'date'),
            'read' => \Yii::t('main', 'read'),
            'active' => \Yii::t('main', 'active'),
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('read', $this->read, true);
        $criteria->compare('active', $this->active);

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
