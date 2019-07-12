<?php
namespace App\Listeners\User;

use App\Events\User\UserCollectVideoEvent;
use App\Repositories\UserCollectVideoRecordRepository;
use App\Tools\Chain\ActionChain;
use Illuminate\Support\Facades\Auth;

class UserCollectVideoListener
{
    public function handle(UserCollectVideoEvent $event)
    {
        (new ActionChain(static::beforeExec(), static::exec($event)))->do();
    }

    private static function exec(UserCollectVideoEvent $event)
    {
        return function () use($event) {
            UserCollectVideoRecordRepository::create($event->video);
        };
    }

    private static function beforeExec()
    {
        return function () {
            return Auth::check();
        };
    }
}