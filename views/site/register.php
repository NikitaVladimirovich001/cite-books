<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
?>
<div class="site-login" style="    width: 100%;
    height: 153vh;
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

        <?= $form->field($model, 'name', ['labelOptions' => ['class' => 'label_my']])->textInput(['autofocus' => true, 'class' => 'my-input-class']) ?>

        <?= $form->field($model, 'surname', ['labelOptions' => ['class' => 'label_my']])->textInput(['autofocus' => true, 'class' => 'my-input-class']) ?>

        <?= $form->field($model, 'patronymic', ['labelOptions' => ['class' => 'label_my']])->textInput(['autofocus' => true, 'class' => 'my-input-class']) ?>

        <?= $form->field($model, 'email', ['labelOptions' => ['class' => 'label_my']])->textInput(['autofocus' => true, 'class' => 'my-input-class']) ?>

        <?= $form->field($model, 'telefon', ['labelOptions' => ['class' => 'label_my']])->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '+7 (999) 999 99 99',
            'options' => ['class' => 'my-input-class']
        ]) ?>

        <?= $form->field($model, 'password', ['labelOptions' => ['class' => 'label_my']])->passwordInput(['class' => 'my-input-class']) ?>

        <?= $form->field($model, 'password_repeat', ['labelOptions' => ['class' => 'label_my']])->passwordInput(['class' => 'my-input-class']) ?>
        <p>Соблюдайте конфендициальность</p>

        <?= Html::submitButton('Регистрация', ['class' => 'redeng', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
