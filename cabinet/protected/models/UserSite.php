<?php

/**
 * Модель для таблицы 'user_sites'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $userId
 * @property string $url
 * @property string $script
 * @property string $active
 */
class UserSite extends CActiveRecord
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
        return 'user_sites';
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
            array('script', 'length', 'max' => 255),
            array('url', 'length', 'max' => 255),
            array('url', 'url'),
            array('url', 'required', 'message' => 'Поле Url не может быть пустым.'),
            // Правила валидации для поиска.
            array(
                'id, userId, url, script, active',
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
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'identify' => array(self::HAS_MANY, 'UserIdentifying', 'siteId'),
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
            'url' => \Yii::t('main', 'url'),
            'script' => \Yii::t('main', 'script'),
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('script', $this->script, true);
        $criteria->compare('active', $this->active, true);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
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

    public static function getUserScript($userId)
    {
        $_scriptPattern = "function getCookie(name) {
	var cookie = ' ' + document.cookie;
	var search = ' ' + name + '=';
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(';', offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}
function myload(a1,a2) {
	setTimeout(function() {
		var a3 = document;
		a4 = a3.getElementsByTagName('script')[0];
		a5 = a3.createElement('script');
		a6 = escape(a3.referrer);
		a5.type = 'text/javascript';
		a5.async = true;
		a5.src = a2+'?uid='+a1+'&a6='+a6+'&a7='+location.host+'&a8='+getCookie('my1witid'+a1)+'&a9='+Math.random();
		a4.parentNode.insertBefore(a5, a4);
	},1)
} myload('{userId}','http://" . $_SERVER['HTTP_HOST'] . "/vk/step1.php');";

        $_encodePattern = "<noindex><script async src='data:text/javascript;charset=utf-8;base64,{script}'></script></noindex>";

        $_scriptPattern = base64_encode(str_replace('{userId}', $userId, $_scriptPattern));
        return str_replace('{script}', $_scriptPattern, $_encodePattern);
    }
}
