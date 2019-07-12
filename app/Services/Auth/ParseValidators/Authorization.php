<?php
namespace App\Services\Auth\ParseValidators;

use App\Services\ParseValidatorContract;
use App\Services\ParseValidatorResult;
use App\Services\Redis\Key;
use App\Tools\Encryptor\Encryptor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator as BaseValidator;

class Authorization implements ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult
    {
        $payload = [];

        $result = BaseValidator::make($data, [
            'token' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) use (&$payload) {
                    if (!$payload = Encryptor::decodeJwtToken(null, $value)) {
                        $fail('token已过期');
                    }

                    if (Cache::get(sprintf(Key::USER_LOGIN_TOKEN, $payload['uid'])) !== $value) {
                        $fail('token已过期');
                    }
                }
            ],
        ],[
            'token.required' => '缺失token'
        ]);

        if ($result->fails()) {
            return ParseValidatorResult::make($result->errors()->toArray());
        }

        return ParseValidatorResult::make([], ['uid' => $payload['uid'], 'app_id' => $payload['aud'], 'nickname' => $payload['nickname']]);
    }
}
