<?php
namespace App\Services\Auth\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\User;
use Illuminate\Support\Facades\Validator as BaseValidator;

class SendCodeToFindPassword implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $result = BaseValidator::make($data, [
            'nickname' => ['bail', 'required', 'string'],
            'app_id' => ['bail', 'required', 'integer'],
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) use($data) {
                    if (!User::where(User::NICKNAME_FIELD, $data['nickname'])->where(User::APP_ID_FIELD, $data['app_id'])->where(User::EMAIL_FIELD, $value)->exists()) {
                        $fail('邮箱未在本应用注册');
                    }
                }
            ],
        ],[
            'nickname.required' => '用户昵称不能为空',
            'email.required' => '用户邮箱不能为空',
            'email.email' => '邮箱格式不合法',
            'app_id.required' => 'APP ID不合法',
            'app_id.integer' => 'APP ID 不合法'
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        return ParseValidatorResult::make();
    }
}