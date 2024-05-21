<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "proposal".
 *
 * @property int $id
 * @property string $image
 * @property string $body
 * @property int $user_id
 * @property int $status
 *
 * @property User $user
 */
class Proposal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['body', 'soob', 'status'], 'string'],
            ['user_id', 'default', 'value' => Yii::$app->user->getId()],
            [['image'], 'file', 'extensions' => 'png,jpg', 'on' => 'update'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'image' => Yii::t('app', 'Изображения с ошибкой'),
            'body' => Yii::t('app', 'Сообщить об ошибке'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'status' => Yii::t('app', 'Статус'),
            'soob' => Yii::t('app', 'Сообщение'),
        ];
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
     * Handle file upload
     *
     * @return bool
     */
    public function upload()
    {
        if ($this->image !== null && $this->validate()) {
            $this->image->saveAs('image/uploads/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get status description
     *
     * @return string
     */
    public function getStatus()
    {
        switch ($this->status) {
            case 1:
                return 'Ожидание';
            case 2:
                return 'Принято';
            default:
                return 'Неизвестный статус';
        }
    }

    /**
     * Set proposal as accepted
     *
     * @return bool
     */
    public function good()
    {
        $this->status = 2;
        return $this->save(false);
    }

    /**
     * Set proposal as pending
     *
     * @return bool
     */
    public function verybad()
    {
        $this->status = 1;
        return $this->save(false);
    }
}