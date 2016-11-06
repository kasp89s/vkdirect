<?php
/**
 * Created by JetBrains PhpStorm.
 * User: turbo
 * Date: 18.09.14
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    private $_errorMessages = array(
        1 => 'Не верное имя пользователя.',
        2 => 'Не верный пароль.',
        100 => 'Нет такого пользователя.',
    );
    public function authenticate()
    {
        $record = User::model()->findByAttributes(array('username'=>$this->username));
        if($record === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage = $this->_errorMessages[self::ERROR_USERNAME_INVALID];
        } elseif (!User::verifyPassword($this->password,$record->password)) {
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
                $this->errorMessage = $this->_errorMessages[self::ERROR_PASSWORD_INVALID];
        } else {
            $this->_id=$record->id;
            $this->setState('role', $record->role);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

}
