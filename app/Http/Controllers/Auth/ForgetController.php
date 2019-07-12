<?php
namespace App\Http\Controllers\Auth;

use App\Services\Auth\ParseValidators\ResetPasswordToFindPassword as ResetPasswordValidator;
use App\Services\Auth\Tasks\ResetPasswordToFindPassword;
use App\Services\Redis\Key;
use App\Tools\Fomatter\End;
use Illuminate\Http\Request;
use App\Services\Auth\ParseValidators\SendCodeToFindPassword as SendCodeValidator;
use App\Services\Auth\Tasks\SendCodeToFindPassword;
use App\Services\ServiceCaller;
use Illuminate\Support\Facades\Cache;

class ForgetController
{
    public function sendVerifyCode(Request $request)
    {
        $parseValidateResult = ServiceCaller::call(
            ServiceCaller::PARSE_VALIDATOR_SERVICE,
            SendCodeValidator::class,
            $request->all()
        );
        if ($parseValidateResult->errors) {
            return End::toFailureJson($parseValidateResult->errors, End::VALIDATE_ERROR);
        }

        ServiceCaller::call(
            ServiceCaller::TASK_SERVICE,
            new SendCodeToFindPassword($request->input('email'), (int)$request->input('app_id'), $request->input('nickname'))
        );

        return End::toSuccessJson();
    }

    public function resetPassword(Request $request)
    {
        $parseValidateResult = ServiceCaller::call(ServiceCaller::PARSE_VALIDATOR_SERVICE,ResetPasswordValidator::class, $request->all());
        if ($parseValidateResult->errors) {
            return End::toFailureJson($parseValidateResult->errors, End::VALIDATE_ERROR);
        }

        ServiceCaller::call(
            ServiceCaller::TASK_SERVICE,
            new ResetPasswordToFindPassword($request->input('app_id'), $request->input('nickname'), $request->input('password'))
        );

        return End::toSuccessJson();
    }
}