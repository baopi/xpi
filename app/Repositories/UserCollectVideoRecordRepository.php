<?php
namespace App\Repositories;

use App\UserCollectVideo;
use App\Video;
use Illuminate\Support\Facades\Auth;

class UserCollectVideoRecordRepository
{
    public static function create(Video $video)
    {
        $model = new UserCollectVideo();
        $model->video_id = $video->id;
        $model->user_id = Auth::id();
        $model->save();
    }

    public static function get()
    {
        return UserCollectVideo::with('video')->where(UserCollectVideo::USER_ID_FIELD, Auth::id())->get()->toArray();
    }
}