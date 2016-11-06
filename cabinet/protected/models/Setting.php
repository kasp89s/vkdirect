<?php
/**
 * Модель для таблицы 'question'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $title
 * @property string $key
 * @property integer $value
 */
class Setting extends \CActiveRecord
{
	public static $translate = array(
	'deliveryPrice' => 'Рассылка без вложения',
	'deliveryMacrosPrice' => 'Рассылка c вложением',
	'purchasePrice' => 'Парсер',
	'vk_app_id' => 'ID приложения ВК',
	'identify_price' => 'Стоимость определения пользователя',
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
        return 'setting';
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
            array('title, key, value', 'length', 'max' => 255),
            // Правила валидации для поиска.
            array(
                'id, title, key, value',
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
        return array();
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
            'title' => \Yii::t('main', 'title'),
            'key' => \Yii::t('main', 'key'),
            'value' => \Yii::t('main', 'value'),
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
        $criteria->compare('key', $this->key, true);
        $criteria->compare('value', $this->value);

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
