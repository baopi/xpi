<?php
namespace App\Repositories;

use App\Tools\Encryptor\Encryptor;
use App\User;

class UserRepository
{
    public static function create(array $data): bool
    {
        $model = new User();
        $model->nickname = $data['nickname'];
        $model->email = $data['email'];
        $model->password = Encryptor::hashPassword($data['password']);
        if (isset($data['sex'])) $model->sex = $data['sex'];
        $model->app_id = $data['app_id'];
        return $model->save();
    }
}