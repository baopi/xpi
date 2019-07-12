<?php
namespace App\Repositories;

use App\UserSeeVideoRecord;
use App\Video;
use Illuminate\Support\Facades\Auth;

class UserSeeVideoRecordRepository
{
    public static function create(Video $video)
    {
        $model = new UserSeeVideoRecord();
        $model->video_id = $video->id;
        $model->user_id = Auth::id();
        $model->save();
    }

    public static function get()
    {
        return UserSeeVideoRecord::with('video')->where(UserSeeVideoRecord::USER_ID_FIELD, Auth::id())->get()->toArray();
    }
}