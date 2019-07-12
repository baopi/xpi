<?php
namespace App\Services\Auth\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\Tools\Encryptor\Encryptor;
use App\User;
use Illuminate\Support\Facades\Validator as BaseValidator;

class Login implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $result = BaseValidator::make($data, [
            'nickname' => ['bail', 'required'],
            'password' => ['bail', 'required'],
            'app_id' => ['bail', 'required', 'integer']
        ], [
            'nickname.required' => '请输入用户名',
            'password.required' => '请输入密码',
            'app_id.required' => 'APP ID 不能为空',
            'app_id.integer' => 'APP ID 不合法',
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        if (!$user = User::where(User::NICKNAME_FIELD, $data['nickname'])->where(User::APP_ID_FIELD, $data['app_id'])->select('password', 'id', 'status')->first())
            return ParseValidatorResult::make([
                'nickname' => [
                    '用户名不存在'
                ]
            ]);

        if ($user->status == User::INVALID_STATUS) {
            return ParseValidatorResult::make([
                'status' => [
                    '用户状态已被禁止登录'
                ]
            ]);
        }

        if (!Encryptor::checkPassword($data['password'], $user->password))
            return ParseValidatorResult::make([
                'password' => [
                    '密码不正确'
                ]
            ]);

        return ParseValidatorResult::make([], ['user' => $user->toArray()]);
    }
}