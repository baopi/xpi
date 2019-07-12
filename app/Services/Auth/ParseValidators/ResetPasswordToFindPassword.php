<?php
namespace App\Services\Auth\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\Services\Redis\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator as BaseValidator;

class ResetPasswordToFindPassword implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $result = BaseValidator::make($data, [
            'nickname' => ['bail', 'required', 'string'],
            'app_id' => ['bail', 'required', 'integer'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
            'code' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) use($data) {
                    $code = Cache::get(sprintf(Key::FIND_PASSWORD_VERIFY_CODE, $data['app_id'], $data['nickname']));
                    if (!$code)
                        $fail('验证码已过期');
                    if ((string)$code != (string)$value)
                        $fail('验证码不正确');
                },
            ],
        ],[
            'code.required' => '请输入验证码',
            'password.confirmed' => '两次密码输入不正确',
            'password.min' => '密码不能少于8个字符'
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        return ParseValidatorResult::make();
    }
}