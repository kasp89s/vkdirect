<?php
/**
 * Модель для таблицы 'question_message'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $questionId
 * @property string $type
 * @property integer $message
 * @property integer $date
 */
class QuestionMessage extends \CActiveRecord
{
    const TYPE_USER = 'user';

    const TYPE_ADMIN = 'admin';

    /**
     * Возвращает название таблицы.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function tableName()
    {
        return 'question_message';
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
            array('questionId', 'numerical', 'integerOnly' => true),
            array('type, message, date', 'length', 'max' => 255),
            // Правила валидации для поиска.
            [
                'id, userId, type, message, date',
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
            'question' => array(self::BELONGS_TO, 'Question', 'questionId'),
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
            'questionId' => \Yii::t('main', 'questionId'),
            'type' => \Yii::t('main', 'type'),
            'message' => \Yii::t('main', 'message'),
            'date' => \Yii::t('main', 'date'),
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
        $criteria->compare('questionId', $this->questionId, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('message', $this->message);
        $criteria->compare('date', $this->date);

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
