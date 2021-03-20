<?php
namespace app\entity;

use yii\db\ActiveRecord;

/**
 * Class UserToGuilds
 * @param int $guild_id
 * @param int $user_id
 * @package app\entity
 */
class UserToGuilds extends ActiveRecord
{
    public static function tableName()
    {
        return 'users_to_guilds';
    }
}