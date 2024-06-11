<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $telefon;
    public $password;
    public $password_repeat;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'name', 'surname', 'email', 'password', 'password_repeat', 'telefon', ], 'required'],
            ['email', 'email'],
            ['username', 'unique', 'targetClass'=>'app\models\User', 'message'=>'Пользователь с таким иминем уже существует'],
            ['telefon', 'unique', 'targetClass'=>'app\models\User', 'message'=>'Пользователь с таким телефоном уже существует'],
            ['email', 'unique', 'targetClass'=>'app\models\User', 'message'=>'Пользователь с такой почтой уже существует'],
            [['patronymic', 'telefon'], 'string', 'max'=>256],
            [['name', 'surname', 'patronymic'], 'match', 'pattern'=>'/^[а-яёА-ЯЁ]++$/u', 'message'=>'Это поле должно содержать буквы русского алфавита'],
            ['password', 'string', 'min'=>6],
            ['password_repeat', 'string', 'min'=>6],
            ['password', 'compare', 'compareAttribute'=>'password_repeat', 'message'=>'Пароли не совпадают']
        ];
    }

    public function register()
    {
        if(!$this->validate()){
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->patronymic = $this->patronymic;
        $user->email = $this->email;
        $user->telefon = $this->telefon;
        $user->HashPassword($this->password);

        return $user->save() ? $user : null;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Логин'),
            'name' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'telefon' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Почта'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повторите пароль'),
        ];
    }
}
