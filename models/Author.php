<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $nsp
 * @property string $image
 * @property int|null $books_id
 *
 * @property Books $books
 * @property Books[] $books0
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nsp', 'image'], 'required'],
            [['books_id'], 'integer'],
            [['nsp', 'image'], 'string', 'max' => 256],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'nsp' => Yii::t('app', 'ФИО'),
            'image' => Yii::t('app', 'Изображение'),
            'books_id' => Yii::t('app', 'ИД книги'),
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasOne(Books::class, ['id' => 'books_id']);
    }

    /**
     * Gets query for [[Books0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks0()
    {
        return $this->hasMany(Books::class, ['author_id' => 'id']);
    }
}
