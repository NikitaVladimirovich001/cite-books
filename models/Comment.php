<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $body
 * @property string $created_at
 * @property int $user_id
 * @property int $books_id
 *
 * @property Books $books
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'books_id'], 'required'],
            [['user_id', 'books_id'], 'integer'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
            ['user_id', 'default', 'value'=>Yii::$app->user->getId()],
            ['books_id', 'default', 'value' => $_GET['id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'body' => Yii::t('app', 'Введиет текст'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'user_id' => Yii::t('app', 'Ид пользователя'),
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }



    public function saveComment()
    {
        $comment = new Comment();
        $id = Yii::$app->request->get('id');
        $books = Books::findOne($id);
        $comment->body = $this->body;

        $comment->link('books', $books);
        $comment->save();
    }
}
