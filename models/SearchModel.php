<?php

namespace app\models;

use yii\base\Model;

class SearchModel extends Model
{
    public $query; // Поле для хранения поискового запроса

    public function rules()
    {
        return [
            ['query', 'string'], // Поле query должно быть строкой
        ];
    }

    public function search()
    {
        if (!$this->validate()) {
            // Если данные не прошли валидацию, возвращаем null или пустой массив
            return [];
        }

        // Возвращаем результат поиска, например, с использованием запроса к базе данных
        return Books::find()->where(['like', 'name', $this->query])->all();
    }
}