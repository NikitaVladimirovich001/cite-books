<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $user_id
 * @property int $books_id
 * @property string $created_at
 *
 * @property Books $books
 * @property User $user
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'books_id'], 'required'],
            [['user_id', 'books_id'], 'integer'],
            [['created_at'], 'safe'],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'books_id' => Yii::t('app', 'Books ID'),
            'created_at' => Yii::t('app', 'Created At'),
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['books_id' => 'id']);
    }
}
