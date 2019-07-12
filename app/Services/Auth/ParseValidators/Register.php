<?php
namespace App\Services\Auth\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\User;
use Illuminate\Support\Facades\Validator as BaseValidator;

class Register implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $result = BaseValidator::make($data, [
            'nickname' => [
                'bail',
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use($data) {
                    if (!isset($data['app_id'])) {
                        $fail('APP ID不合法');
                    } else if (User::where($attribute, $value)->where(User::APP_ID_FIELD, $data['app_id'])->exists()) {
                        $fail('用户名已存在');
                    }
                },
            ],
            'email' => ['bail', 'required', 'string', 'email', 'max:255'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
            'sex' => ['bail', sprintf('in:%d,%d', User::MAN_SEX, USER::WOMEN_SEX)],
            'app_id' => ['bail', 'required', 'integer']
        ],[
            'nickname.required' => '请输入您的用户名',
            'nickname.max' => '用户名长度不能超过225个字符',
            'nickname.string' => '用户名不合法',
            'email.required' => '请输入您的邮箱',
            'email.email' => '邮箱格式不正确',
            'email.max' => '邮箱地址长度不能超过225个字符',
            'email.string' => '邮箱地址不合法',
            'sex.in' => '性别不合法',
            'app_id.required' => '缺少APP ID',
            'app_id.integer' => 'APP ID不合法',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能少于8个字',
            'password.confirmed' => '两次密码输入不正确',
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        return ParseValidatorResult::make([]);
    }
}