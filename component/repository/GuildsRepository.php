<?php

namespace app\component\repository;

use app\entity\Guilds;

class GuildsRepository
{
    public static function getGuildById($id) {
        return Guilds::find()->where(['id' => $id])->one();
    }

    public static function getGuildByDiscordId($discord_id) {
        return Guilds::find()->where(['discord_id' => $discord_id])->one();
    }

    public static function getGuildsByOwnerId($owner_id) {
        return Guilds::find()->where(['owner_discord_id' => $owner_id])->all();
    }

    public static function createGuildsByRestCordUser($data) {
        foreach ($data as $key => $value) {
            $guild = null;
            if (!empty(GuildsRepository::getGuildByDiscordId($value->id))) {
                $guild = GuildsRepository::getGuildByDiscordId($value->id);
            } else {
                $guild = new Guilds();
            }

            $guild->discord_id = $value->id;
            $guild->name = trim(preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $value->name));
            $guild->icon_url = $value->icon
                ? 'https://cdn.discordapp.com/icons/'.$value->id.'/'.$value->icon.'.png'
                : null;
            $guild->save();
        }
    }
}