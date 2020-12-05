<?php

namespace app\controllers;

use app\models\HworldModel;
use Yii;
use yii\web\Controller;

class HworldController extends Controller
{
    public function actionIndex(){
        $model= new HworldModel();
        if ($model->load(Yii::$app->request->post())){
            $model->username = 'hello world';
            return $this->render('../site/index',['model'=>$model]);
        }
        return $this->render('hworld',['model'=>$model]);
    }
}