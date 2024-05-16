<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
?>
<div class="site-login" style="width: 100%;
    height: 73vh;
    display: flex;
    align-items: center;
    justify-content: center;">
    <div class="content-container" style=" margin-bottom: 10px;">
        <center><h1><?= Html::encode($this->title) ?></h1></center>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'username', ['labelOptions' => ['class' => 'label_my']])->textInput(['autofocus' => true, 'class' => 'my-input-class']) ?>

        <?= $form->field($model, 'password', ['labelOptions' => ['class' => 'label_my']])->passwordInput(['class' => 'my-input-class']) ?>

<!--        <p>Введите данные своей учетной записи</p>-->

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Войти', ['class' => 'redeng', 'name' => 'login-button', 'style'=>'margin-left: -55px']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
