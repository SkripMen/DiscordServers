<?php
namespace app\entity;

use yii\db\ActiveRecord;

/**
 * Class DirTags
 * @param int $id
 * @param string $tag
 * @package app\entity
 */
class DirTags extends ActiveRecord
{
    public static function tableName()
    {
        return 'dir_tags';
    }
}