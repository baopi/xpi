<?php
namespace App\Http\Controllers;

use App\Events\User\UserSeeVideoEvent;
use App\Repositories\UserCollectVideoRecordRepository;
use App\Repositories\UserSeeVideoRecordRepository;
use App\Services\User\ParseValidators\ResetPassword;
use App\Services\ServiceCaller;
use App\Tools\Encryptor\Encryptor;
use App\Tools\Fomatter\End;
use App\Events\User\UserCollectVideoEvent;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class UserController
{
    public function seeVideo($videoId)
    {
        Event::dispatch(new UserSeeVideoEvent(Video::find($videoId)));
        return End::toSuccessJson();
    }

    public function collectVideo($videoId)
    {
        Event::dispatch(new UserCollectVideoEvent(Video::find($videoId)));
        return End::toSuccessJson();
    }

    public function getSeeVideoRecords()
    {
        return End::toSuccessJson(UserSeeVideoRecordRepository::get());
    }

    public function getCollectVideos()
    {
        return End::toSuccessJson(UserCollectVideoRecordRepository::get());
    }

    public function resetPassword(Request $request)
    {
        $parseValidateResult = ServiceCaller::call(ServiceCaller::PARSE_VALIDATOR_SERVICE,ResetPassword::class, $request->all());
        if ($parseValidateResult->errors) {
            return End::toFailureJson($parseValidateResult->errors, End::VALIDATE_ERROR);
        }

        $user = Auth::user();
        $user->password = Encryptor::hashPassword($request->input('password'));
        $user->save();

        return End::toSuccessJson();
    }
}