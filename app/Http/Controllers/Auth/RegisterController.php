<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Tools\Fomatter\End;
use App\Repositories\UserRepository as Repository;
use App\Services\Auth\ParseValidators\Register;
use App\Services\ServiceCaller;

class RegisterController
{
    public function register(Request $request)
    {
        $parseValidateResult = ServiceCaller::call(ServiceCaller::PARSE_VALIDATOR_SERVICE, Register::class, $request->all());

        if (!is_null($parseValidateResult->errors))
            return End::toFailureJson($parseValidateResult->errors, End::VALIDATE_ERROR);

        if (!Repository::create($request->all()))
            return End::toFailureJson([], End::INTERNAL_ERROR);

        return End::toSuccessJson();
    }
}