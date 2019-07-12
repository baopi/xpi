<?php
namespace App\Http\Controllers\Auth;

use App\Tools\Fomatter\End;
use App\Services\Redis\Key;
use Illuminate\Http\Request;
use App\Services\Auth\ParseValidators\Login;
use App\Services\Auth\Tasks\CreateLoginToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\ServiceCaller;

class LoginController
{
    public function login(Request $request)
    {
        $parseValidateResult = ServiceCaller::call(ServiceCaller::PARSE_VALIDATOR_SERVICE,Login::class, $request->all());
        if (!is_null($parseValidateResult->errors)) {
            return End::toFailureJson($parseValidateResult->errors, End::VALIDATE_ERROR);
        }

        $user = $parseValidateResult->parser->user;

        $token = ServiceCaller::call(
            ServiceCaller::TASK_SERVICE,
            new CreateLoginToken((int)$request->input('app_id'), (int)$user['id'], $request->input('nickname'), (bool)$request->input('remember_me'))
        );
        if (!$token) {
            return End::toFailureJson([], End::INTERNAL_ERROR);
        }

        return End::toSuccessJson(['token' => $token]);
    }

    public function logout()
    {
        if (Cache::forget(sprintf(Key::USER_LOGIN_TOKEN, Auth::id())))
            return End::toSucessJson();
        else
            return End::toFailureJson([], End::INTERNAL_ERROR);
    }
}