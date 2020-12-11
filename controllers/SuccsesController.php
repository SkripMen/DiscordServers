<?php

namespace app\controllers;

use app\models\HworldModel;
use RestCord\DiscordClient;
use Yii;
use yii\web\Controller;
use app\entity\Guilds;

class SuccsesController extends Controller
{
    public function actionIndex(){
        $guild = Guilds::findOne(1);
//        return var_dump(get_defined_vars());
//        $guild = new Guilds();

        $token = fopen('../token.txt', 'r');
        $token = fgets($token);
        $discord = new DiscordClient([
            'token' => $token,
            'tokenType' => 'Bot'
        ]);
        $guild_id = intval($guild->guild_id);
        return var_dump($discord->guild->getGuild([
            'guild.id' => intval($guild_id)
        ]));

        return $this->render('succses');
    }
}