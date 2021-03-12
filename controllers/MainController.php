<?php

namespace app\controllers;

use app\component\repository\GuildsRepository;
use app\entity\Guilds;
use app\entity\Users;
use Hybridauth\Exception\AuthorizationDeniedException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use RestCord\DiscordClient;
use Hybridauth\Provider\Discord;

class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        return phpinfo();
//        $token = fopen('../token.txt', 'r');
//        $token = fgets($token);

//        $discord = new DiscordClient([
//            'token' => $token,
//            'tokenType' => 'Bot'
//        ]);
//        return var_dump($discord->user->getUser(['user.id'=>361154033362403338]));
//        return var_dump($discord->guild->listGuildMembers(['guild.id' => 547094388539392000]));
//        $guild = $discord->guild->getGuild(['guild.id' => $discord->user->getCurrentUserGuilds()[0]->id]);
//            return var_dump($discord->guild->getGuildWidgetImage(['guild.id' => $guild->id, 'style' => 'shield']));
//            return var_dump($discord->guild->listGuildMembers([
//                'guild.id'=>$discord->user->getCurrentUserGuilds()[1]->id,
//                'limit' => 2,
//                'after' => 1
//            ]));

//        return var_dump(Users::find()->where(['discord_id' => 222])->one());
        $arr = [];
        if (!Yii::$app->user->isGuest) {
//            $discord = new DiscordClient([
//                'token' => Yii::$app->user->identity->getAuthKey(),
//                'tokenType' => 'OAuth'
//            ]);
//            $discord_bot = new DiscordClient([
//                'token' => 'Nzg0NzUzMzQ0NDY3NTY2NjAy.X8t4gQ.rXAqsa_YfyaOgFrdpbsTyrzMW24',
//                'tokenType' => 'Bot'
//            ]);
//            https://cdn.discordapp.com/icons/252378116998168577/8c9c81c0a463a28c7acbaa44c35aa301.png
//        return var_dump($discord->user->getCurrentUserGuilds());

            foreach (Guilds::find()->all() as $key => $value) {
                $arrIn[0] = $value->name;
                $arrIn[1] = $value->discord_id;
                $arrIn[2] = $value->icon_url;
                $arr[] = $arrIn;

            }
//            var_dump($discord->guild->getGuild(['guild.id' => 785580742612484146])->owner_id);
//            var_dump($discord_bot->user->getCurrentUserGuilds());
//            var_dump($discord_bot->guild->getGuildChannels(['guild.id' => 547094388539392000]));
//            var_dump($discord_bot->channel->createMessage(['channel.id' => 550372544809795594, 'content' => 'Проба пера']));
        }
        return $this->render('index', [
            'arr' => $arr,
        ]);
//        return 1;


//        $config = [
//
//            'callback' => 'http://server-discord.ru/',
//
//            'keys' => [
//                'id' => '784753344467566602',
//                'secret' => '7nDcOWEc-YflFDZfbZ47DA7s3PYkqAyA'
//            ],
//            'scope' => 'guilds',
//        ];
//        $adapter = new Discord($config);
//        $adapter->authenticate();
//        $accessToken = $adapter->getAccessToken();
//
//        $adapter->setAccessToken($accessToken);
//        $userProfile = $adapter->getUserProfile();
//        $discord = new DiscordClient([
//            'token' => $accessToken['access_token'],
//            'tokenType' => 'OAuth'
//        ]);
//        return var_dump($discord->user->getCurrentUser()) . '<br>' . var_dump($discord->user->getCurrentUserGuilds()) . '<br>' . var_dump($userProfile);
//
//        return var_dump($accessToken) . '<br>' . var_dump($userProfile);

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        try {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $config = [
                'callback' => 'http://server-discord.ru/main/login',
                'keys' => [
                    'id' => '784753344467566602',
                    'secret' => '7nDcOWEc-YflFDZfbZ47DA7s3PYkqAyA'
                ],
                'scope' => 'guilds',
            ];
            $adapter = new Discord($config);
            $adapter->authenticate();
            $accessToken = $adapter->getAccessToken();
            $adapter->setAccessToken($accessToken);
        } catch (AuthorizationDeniedException $e) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->login($accessToken['access_token'])) {
            $discord = new DiscordClient([
                'token' => Yii::$app->user->identity->getAuthKey(),
                'tokenType' => 'OAuth'
            ]);
            GuildsRepository::createGuildsByRestCordUser($discord->user->getCurrentUserGuilds());
            return $this->goBack();
        }


        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
