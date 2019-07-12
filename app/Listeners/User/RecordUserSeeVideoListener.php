<?php
namespace App\Listeners\User;

use App\Events\User\UserSeeVideoEvent;
use App\Repositories\UserSeeVideoRecordRepository;
use App\Tools\Chain\ActionChain;
use Illuminate\Support\Facades\Auth;

class RecordUserSeeVideoListener
{
    public function handle(UserSeeVideoEvent $event)
    {
        (new ActionChain(static::beforeExec(), static::exec($event)))->do();
    }

    private static function exec(UserSeeVideoEvent $event)
    {
        return function () use($event) {
            UserSeeVideoRecordRepository::create($event->video);
        };
    }

    private static function beforeExec()
    {
        return function () {
            return Auth::check();
        };
    }
}