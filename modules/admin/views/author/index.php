<?php

use app\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Автор');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'nsp',
                'image',
//                'books_id',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Создать автора'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

</div>
