<?php
namespace App\Services\User\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\Tools\Encryptor\Encryptor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as BaseValidator;

class ResetPassword implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $result = BaseValidator::make($data, [
            'old_password' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) {
                    if (!Encryptor::checkPassword($value, Auth::user()->password)) {
                        $fail('原密码不正确');
                    }
                }
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'confirmed',
            ]
        ], [
            'old_password' => '原密码不能为空',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码输入不正确',
            'password.min' => '密码不能少于8个字符'
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        return ParseValidatorResult::make();
    }

}