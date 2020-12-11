<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <div>Succses</div>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password') ?>

<?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>