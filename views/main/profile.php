<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Профиль';
?>
<div class="site-contact">
    <img src="<?=$ava?>">
    <h1><?=$name?></h1>
    <p><?=$email?></p>
    <a href="add-to-created">Добавить сервер</a>
    <div style="border: gold 3px solid">
        <?foreach ($added_guilds as $key => $value):?>
            <div style="border: black 3px solid">
                <img src="<?='https://cdn.discordapp.com/icons/' . $value->id . '/' . $value->icon . '.png'?>">
                <h1><?=$value->name?></h1>
            </div>
        <?endforeach;?>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); border: silver 3px solid">
        <?foreach ($guilds as $key => $value):?>
        <div style="border: black 3px solid">
            <img src="<?='https://cdn.discordapp.com/icons/' . $value->id . '/' . $value->icon . '.png'?>">
            <h1><?=$value->name?></h1>
        </div>
        <?endforeach;?>
    </div>
</div>
