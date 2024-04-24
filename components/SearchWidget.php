<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class SearchWidget extends Widget
{
    public function run()
    {
        // Создаем экземпляр модели для формы поиска
        $searchModel = new \app\models\SearchModel();

        // Выводим форму поиска
        return $this->render('search', ['searchModel' => $searchModel,]);
    }
}