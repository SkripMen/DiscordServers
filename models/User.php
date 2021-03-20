<?php

namespace app\models;

use app\component\repository\UsersRepository;
use Yii;
use yii\base\BaseObject;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends BaseObject implements IdentityInterface
{
    public $id;
    public $name;
    public $discord_id;
    public $email;
    public $avatar_url;
    public $access_key;
    public $is_admin;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        if (!empty($id)){
            return new static(UsersRepository::getUserById($id));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return new static(
            !empty(UsersRepository::getUserByAccessKey($token))
                ? UsersRepository::getUserByAccessKey($token)
                : UsersRepository::createUserByAccessKey($token)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->access_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($access_key)
    {
        return $this->access_key === $access_key;
    }

}
