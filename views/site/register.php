<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
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

        <?= $form->field($model, 'name', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'surname', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'patronymic', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'telefon', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->widget(MaskedInput::className(), ['mask' => '+7 (999) 999 99 99'])?>

        <?= $form->field($model, 'password', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->passwordInput() ?>

        <?= $form->field($model, 'password_repeat', ['template' => '<label class="col-lg-1 col-form-label mr-lg-3" style="color: white;">{label}</label>{input}{hint}{error}',
        ])->passwordInput() ?>
        <p>Соблюдайте конфендициальность</p>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Регистрация', ['class' => 'redeng', 'name' => 'login-button', 'style'=>'']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
