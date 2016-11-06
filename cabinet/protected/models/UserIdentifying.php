<?php
/**
 * Модель для таблицы 'user_identifying'.
 *
 * Доступны следующие поля:
 *
 * @property string $id
 * @property string $siteId
 * @property integer $uid
 * @property integer $nid
 * @property string $cookid
 * @property string $vkid
 * @property string $vkname
 * @property string $lname
 * @property string $sex
 * @property string $domain
 * @property string $bdate
 * @property string $city
 * @property string $citytxt
 * @property string $photo_50
 * @property string $interests
 * @property string $activities
 * @property string $contacts
 * @property string $remoteid
 * @property string $time
 */
class UserIdentifying extends CActiveRecord
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
        return 'user_identifying';
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
            array('id, siteId', 'required'),
            array('uid, nid', 'numerical', 'integerOnly' => true),
            array('id, siteId', 'length', 'max' => 10),
            array('cookid, vkid, vkname, lname, domain', 'length', 'max' => 32),
            array('sex', 'length', 'max' => 5),
            array('bdate, city, citytxt, activities, remoteid', 'length', 'max' => 16),
            array('photo_50, interests, contacts', 'length', 'max' => 255),
            array('time', 'safe'),
            // Правила валидации для поиска.
            array(
                'id, siteId, uid, nid, cookid, vkid, vkname, lname, sex, domain, bdate, city, citytxt, photo_50, interests, activities, contacts, remoteid, time',
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
            'site' => array(self::BELONGS_TO, 'UserSite', 'siteId'),
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
            'siteId' => \Yii::t('main', 'Site'),
            'uid' => \Yii::t('main', 'Uid'),
            'nid' => \Yii::t('main', 'Nid'),
            'cookid' => \Yii::t('main', 'Cookid'),
            'vkid' => \Yii::t('main', 'Vkid'),
            'vkname' => \Yii::t('main', 'Vkname'),
            'lname' => \Yii::t('main', 'Lname'),
            'sex' => \Yii::t('main', 'Sex'),
            'domain' => \Yii::t('main', 'Domain'),
            'bdate' => \Yii::t('main', 'Bdate'),
            'city' => \Yii::t('main', 'City'),
            'citytxt' => \Yii::t('main', 'Citytxt'),
            'photo_50' => \Yii::t('main', 'Photo 50'),
            'interests' => \Yii::t('main', 'Interests'),
            'activities' => \Yii::t('main', 'Activities'),
            'contacts' => \Yii::t('main', 'Contacts'),
            'remoteid' => \Yii::t('main', 'Remoteid'),
            'time' => \Yii::t('main', 'Time'),
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
        $criteria->compare('siteId', $this->siteId, true);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('nid', $this->nid);
        $criteria->compare('cookid', $this->cookid, true);
        $criteria->compare('vkid', $this->vkid, true);
        $criteria->compare('vkname', $this->vkname, true);
        $criteria->compare('lname', $this->lname, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('domain', $this->domain, true);
        $criteria->compare('bdate', $this->bdate, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('citytxt', $this->citytxt, true);
        $criteria->compare('photo_50', $this->photo_50, true);
        $criteria->compare('interests', $this->interests, true);
        $criteria->compare('activities', $this->activities, true);
        $criteria->compare('contacts', $this->contacts, true);
        $criteria->compare('remoteid', $this->remoteid, true);
        $criteria->compare('time', $this->time, true);

        return new \CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Возвращает статическую модель Active Record.
     *
     * @param string $className Название текущего класса.
     *
     * @return UserIdentifying
     *
     * @codeCoverageIgnore
     */
    public static function model($className = __CLASS__)
    {
        $className = __CLASS__;
        return parent::model($className);
    }
}
