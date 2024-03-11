<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Books;

/**
 * BooksSearch represents the model behind the search form of `app\models\Books`.
 */
class BooksSearch extends Books
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'category_id', 'viewed'], 'integer'],
            [['name', 'opisanie', 'file', 'image', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Books::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'viewed' => $this->viewed,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'opisanie', $this->opisanie])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
