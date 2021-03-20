<?php
namespace app\entity;

use yii\db\ActiveRecord;

/**
 * Class AllowedGuilds
 * @param int $id
 * @param int $guild_id
 * @param string $access_url
 * @package app\entity
 */
class AllowedGuilds extends ActiveRecord
{
    public static function tableName()
    {
        return 'allowed_guilds';
    }
}