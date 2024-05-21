<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * Это класс модели для таблицы «категория».
 *
 * @property int $id
 * @property string $name
 * @property string $opisanie
 * @property string $image
 *
 * @property Books[] $books
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'opisanie', 'image'], 'required'],
            [['name'], 'string', 'max' => 256],
            ['opisanie', 'string'],
            ['image', 'file', 'extensions' => 'png, jpg', 'on' => 'update'],
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
            'image' => Yii::t('app', 'Картинка'),
        ];
    }

    /**
     * Получает запрос для [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::class, ['category_id' => 'id']);
    }

    public function upload()
    {
        if ($this->image !== null) {
            $this->image->saveAs('image/genres/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
}