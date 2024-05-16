<?php

namespace app\models;

use Yii;

class Author extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'author';
    }

    public function rules()
    {
        return [
            [['nsp', 'image'], 'required'],
//            [['books_id'], 'integer'],
            ['nsp', 'string', 'max' => 256],
            ['image', 'file'],
//            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'nsp' => Yii::t('app', 'ФИО'),
            'image' => Yii::t('app', 'Изображение'),
            'books_id' => Yii::t('app', 'ИД книги'),
        ];
    }

    public function getBook()
    {
        return $this->hasOne(Books::class, ['id' => 'books_id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('image/author/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
}
