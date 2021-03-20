<?php


namespace app\entity;

use yii\db\ActiveRecord;

/**
 * Class Users
 * @param int $id
 * @param int $discord_id
 * @param string $email
 * @param string $name
 * @param string $access_key
 * @param string $avatar_url
 * @param int $is_admin
 * @package app\entity
 */
class Users extends ActiveRecord
{

}