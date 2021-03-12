<?php

namespace app\component\repository;

use app\entity\Users;
use RestCord\DiscordClient;
use yii\db\ActiveRecord;

class UsersRepository
{
    /**
     * @param int $id
     * @return array|ActiveRecord|null
     */
    public static function getUserById($id)
    {
        return Users::find()->where(['id' => $id])->one();
    }

    /**
     * @param int $discord_id
     * @return array|ActiveRecord|null
     */
    public static function getUserByDiscordId($discord_id)
    {
        return Users::find()->where(['discord_id' => $discord_id])->one();
    }

    /**
     * @param string $access_key
     * @return array|ActiveRecord|null
     */
    public static function getUserByAccessKey($access_key)
    {
        return Users::find()->where(['access_key' => $access_key])->one();
    }

    /**
     * @param string $access_key
     * @return array|ActiveRecord|null
     */
    public static function createUserByAccessKey($access_key)
    {
        $discord = new DiscordClient([
            'token' => $access_key,
            'tokenType' => 'OAuth'
        ]);
        $discord_user = $discord->user->getCurrentUser();
        if (!empty(UsersRepository::getUserByDiscordId($discord_user->id))) {
            $user = UsersRepository::getUserByDiscordId($discord_user->id);
        } else {
            $user = new Users;
        }
        $user->discord_id = $discord_user->id;
        $user->name = $discord_user->username;
        $user->email = $discord_user->email;
        $user->access_key = $access_key;
        $user->avatar_url =
            'https://cdn.discordapp.com/avatars/'
            . $discord_user->id
            . '/'
            . $discord_user->avatar
            . '.png';
        $user->save();
        return $user;
    }
}