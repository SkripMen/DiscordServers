<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use app\models\LoginForm;
use app\models\ContactForm;
use RestCord\DiscordClient;
use Hybridauth\Provider\Discord;

class SiteController extends Controller
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
        $token = fopen('../token.txt', 'r');
        $token = fgets($token);
//        $discord = new DiscordClient([
//            'token' => $token,
//            'tokenType' => 'Bot'
//        ]);
////        return var_dump($discord->user->getUser(['user.id'=>361154033362403338]));
////        return var_dump($discord->guild->listGuildMembers(['guild.id' => 547094388539392000]));
//        $guild = $discord->guild->getGuild(['guild.id' => $discord->user->getCurrentUserGuilds()[0]->id]);
//            return var_dump($discord->guild->getGuildWidgetImage(['guild.id' => $guild->id, 'style' => 'shield']));
////            return var_dump($discord->guild->listGuildMembers([
////                'guild.id'=>$discord->user->getCurrentUserGuilds()[1]->id,
////                'limit' => 2,
////                'after' => 1
////            ]));
//        $arrIn = [
//            'Heading',
//            'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
//                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
//                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
//                    fugiat nulla pariatur.'
//        ];
//        $arr = [$arrIn, $arrIn, $arrIn, $arrIn];
//        return $this->render('index', [
//            'arr' => $arr,
//        ]);
//        return 1;
        $config = [

            'callback' => 'http://server-discord.ru/',

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
        $userProfile = $adapter->getUserProfile();
        $discord = new DiscordClient([
            'token' => $accessToken['access_token'],
            'tokenType' => 'OAuth'
        ]);
        return var_dump($discord->user->getCurrentUser()) . '<br>' . var_dump($discord->user->getCurrentUserGuilds()) . '<br>' . var_dump($userProfile);

        return var_dump($accessToken) . '<br>' . var_dump($userProfile);
//https://discord.com/oauth2/authorize?response_type=code&client_id=784753344467566602&redirect_uri=http%3A%2F%2Fserver-discord.ru%2F&scope=identify+email&state=HA-O7UPSKFRT16HBMI9C4Y5AQN3ZWJGD2X0V8LE
//https://discord.com/api/oauth2/authorize?client_id=784753344467566602&redirect_uri=http%3A%2F%2Fserver-discord.ru%2F&response_type=code&scope=identify%20email%20guilds
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
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
