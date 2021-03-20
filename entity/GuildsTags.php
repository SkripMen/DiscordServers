<?php
namespace app\entity;

use yii\db\ActiveRecord;

/**
 * Class GuildsTags
 * @param int $guild_id
 * @param int $tag_id
 * @package app\entity
 */
class GuildsTags extends ActiveRecord
{
    public static function tableName()
    {
        return 'guilds_tags';
    }
}