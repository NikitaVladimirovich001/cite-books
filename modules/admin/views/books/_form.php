<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var yii\widgets\ActiveForm $form */
$items = \app\models\Category::find()
    ->select(['name', 'id'])
    ->indexBy('id')
    ->column();

$it = \app\models\Author::find()
    ->select(['nsp', 'id'])
    ->indexBy('id')
    ->column();
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opisanie')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'author_id')->dropDownList($it, ['prompt'=>'Выйбирите автора книги'])  ?>

    <?= $form->field($model, 'category_id')->dropDownList($items, ['prompt'=>'Выйбирите жанр книги']) ?>

<!--    --><?//= $form->field($model, 'viewed')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохронить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
