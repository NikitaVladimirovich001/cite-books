<?php

use app\models\Proposal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProposalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Обращение');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'body:ntext',
            [
                'attribute' => 'user_id',
                'label' => 'Пользователь',
                'value' => function ($model) {
                    return $model->user->username;
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Изображение',
                'value' => function ($model) {
                    $imagePath = Yii::getAlias('@web/image/uploads/' . $model->image);
                    $imageFilePath = Yii::getAlias('@webroot/image/uploads/' . $model->image);
                    if (!empty($model->image) && file_exists($imageFilePath)) {
                        return Html::img($imagePath, [
                            'alt' => 'Image',
                            'width' => '70px'
                        ]);
                    } else {
                        return 'Нет изображения';
                    }
                },
            ],
            'soob',
            [
                'attribute' => 'Администрирование',
                'format' => 'html',
                'value' => function ($data) {
                    switch ($data->status) {
                        case 1:
                            return Html::a('Принято', 'good/?id=' . $data->id) . "|" .
                                Html::a('Ожидание', 'verybad/?id=' . $data->id);

                        case 2:
                            return Html::a('Ожидание', 'verybad/?id=' . $data->id);
                    }
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Proposal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <!--
    <p>
        <?= Html::a(Yii::t('app', 'Создать обращение'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    -->

</div>