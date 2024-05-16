<?php

use app\models\Books;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Книга');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'opisanie:ntext',
                'file:ntext',
                'image',
                //'date',
                'author_id',
                'category_id',
                //'viewed',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Books $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать книгу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
