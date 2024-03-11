<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
?>
<div class="site-login" style="margin-top: 21px;">
    <div class="content-container">
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

        <?= $form->field($model, 'username', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->passwordInput() ?>

        <p>Введите данные своей учетной записи</p>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Войти', ['class' => 'redeng', 'name' => 'login-button', 'style'=>'margin-left: -55px; margin-bottom: 113px;']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
