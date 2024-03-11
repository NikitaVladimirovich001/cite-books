<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = User::findIdentity(1))->notEmpty();
        verify($user->username)->equals('nikita');

        verify(User::findIdentity(999))->empty();
    }

//    public function testFindUserByAccessToken()
//    {
//        verify($user = User::findIdentityByAccessToken('4-token'))->notEmpty();
//        verify($user->username)->equals('admin');
//
//        verify(User::findIdentityByAccessToken('non-existing'))->empty();
//    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('admin'))->notEmpty();
        verify(User::findByUsername('not-admin'))->empty();
    }
//
//    /**
//     * @depends testFindUserByUsername
//     */
//    public function testValidateUser()
//    {
//        $user = User::findByUsername('nikita');
//        verify($user->validateAuthKey('test100key'))->notEmpty();
//        verify($user->validateAuthKey('test102key'))->empty();
//
//        verify($user->validatePassword('nikita'))->notEmpty();
//        verify($user->validatePassword('qwe123!'))->empty();
//    }

}
