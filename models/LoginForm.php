<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    private $_user = false;

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login($token)
    {
        return Yii::$app->user->login(
            $this->getUser($token)
        );
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser($token)
    {
        if ($this->_user === false) {
            $this->_user = User::findIdentityByAccessToken($token);
        }
        return $this->_user;
    }
}
