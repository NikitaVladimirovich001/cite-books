<?php

use app\models\Books;
use app\models\Author;
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
//            'viewed',
            'file:ntext',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img(Yii::$app->request->BaseUrl . '/image/books/' . $model->image, ['width' => '100']);
                },
            ],
            //'date',
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return $model->author->nsp;
                },
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category->name;
                },
            ],
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