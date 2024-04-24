<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['action' => ['site/search'], 'method' => 'get']) ?>
<div style="display: flex">
    <?= $form->field($searchModel, 'query')->textInput(['placeholder' => 'Введите название книги', 'class'=>'my-input-search'])->label(false) ?>
</div>
<?php ActiveForm::end() ?>