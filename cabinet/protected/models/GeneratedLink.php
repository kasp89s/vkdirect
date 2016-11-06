<?php

/**
 * Модель для таблицы 'generated_link'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $userId
 * @property string $link
 * @property string $count
 */
class GeneratedLink extends \CActiveRecord
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
        return 'generated_link';
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
            array('link', 'length', 'max' => 255),
            array('count', 'length', 'max' => 10),
            array('userId, link', 'required'),
            // Правила валидации для поиска.
            [
                'id, userId, link, count',
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
            'statistic' => array(self::HAS_MANY, 'StatisticsLink', 'linkId'),
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
            'userId' => \Yii::t('main', 'userId'),
            'link' => \Yii::t('main', 'link'),
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
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('link', $this->link, true);
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

    /**
     * Генерирует ссылку для редиректа
     *
     * @param $userId
     * @return array
     */
    public static function generate($userId)
    {
        $model = new self();
        $model->userId = $userId;
        $model->link = self::randomText(5, 'string');
        $model->save();
        return array('id' => $model->id, 'link' => $model->link);
    }

    /**
     * Генерирует случайную строку
     *
     * @param int длина строки
     * @param string [string,int,symbol] указываем с чего будет состоять строка
     * @return string
     */
    public static function randomText()
    {
        //Получаем аргументы
        $args_ar = func_get_args();
        $new_arr = array();

        //Определяем длину текста
        $length = $args_ar[0];
        unset($args_ar[0]);

        if(!sizeof($args_ar))
        {
            $args_ar = array("string","int","symbol");
        }

        $arr['string'] = array(
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z');

        $arr['int'] = array(
            '1','2','3','4','5','6',
            '7','8','9','0');

        $arr['symbol'] = array(
            '.','$','[',']','!','@',
            '*', '+','-','{','}');

        //Создаем массив из всех массивов
        foreach($args_ar as $type)
        {
            if(isset($arr[$type]))
            {
                $new_arr = array_merge($new_arr,$arr[$type]);
            }
        }

        // Генерируем строку
        $str = "";
        for($i = 0; $i < $length; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($new_arr) - 1);
            $str .= $new_arr[$index];
        }
        return $str;
    }
}
