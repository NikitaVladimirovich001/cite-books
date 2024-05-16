<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string $opisanie
 * @property string $file
 * @property string $image
 * @property string $date
 * @property int $author_id
 * @property int $category_id
 * @property int $viewed
 *
 * @property Author $author
 * @property Author[] $authors
 * @property Category $category
 * @property Comment[] $comments
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['name', 'opisanie', 'file', 'image', 'author_id', 'category_id'], 'required'],
            [['opisanie'], 'string'],
            [['author_id', 'category_id'], 'integer'],
            ['name', 'string', 'max' => 256],
            [['image'], 'file', 'extensions' => 'png, jpg', 'on'=>'update'],
            [['file'], 'file', 'on'=>'update'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'name' => Yii::t('app', 'Имя'),
            'opisanie' => Yii::t('app', 'Описание'),
            'file' => Yii::t('app', 'Файл'),
            'image' => Yii::t('app', 'Картинка'),
            'date' => Yii::t('app', 'Дата'),
            'author_id' => Yii::t('app', 'ИД автор'),
            'category_id' => Yii::t('app', 'ИД категории'),
            'viewed' => Yii::t('app', 'Просмотры'),
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['books_id' => 'id']);
    }

    public function getHistories()
    {
        return $this->hasMany(History::class, ['books_id' => 'id']);
    }

    public function uploadImage()
    {
        if ($this->validate()) {
            $this->image->saveAs('image/books/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->file->saveAs('file/' . $this->file->baseName . '.' . $this->file->extension)) {
                Yii::$app->session->setFlash('success', 'Файл успешно загружен.');
                return true;
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить файл.');
                return false;
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка валидации: ' . json_encode($this->errors));
            return false;
        }
    }
}
