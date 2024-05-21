<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

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
            [['user_id', 'books_id', 'body'], 'required'],
            [['user_id', 'books_id'], 'integer'],
            [['body'], 'string'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
            ['user_id', 'default', 'value' => Yii::$app->user->getId()],
            ['books_id', 'default', 'value' => Yii::$app->request->get('id')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'body' => Yii::t('app', 'Введите текст'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'user_id' => Yii::t('app', 'ИД пользователя'),
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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Сохраняет комментарий с экранированием ввода.
     */
    public function saveComment()
    {
        $comment = new Comment();
        $id = Yii::$app->request->get('id');
        $books = Books::findOne($id);
        $comment->body = Html::encode($this->body);  // Экранирование ввода

        $comment->link('books', $books);
        $comment->save();
    }
}