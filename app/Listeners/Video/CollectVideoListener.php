<?php
namespace App\Listeners\Video;

use App\Events\User\UserCollectVideoEvent;
use App\Tools\Chain\ActionChain;
use Illuminate\Support\Facades\Auth;

class CollectVideoListener
{
    public function handle(UserCollectVideoEvent $event)
    {
        (new ActionChain(static::beforeExec(), static::exec($event)))->do();
    }

    public static function beforeExec()
    {
        return function () {
            return Auth::check();
        };
    }

    public static function exec(UserCollectVideoEvent $event)
    {
        return function () use($event) {
            $event->video->real_collect_num = $event->video->real_collect_num + 1;
            $event->video->collect_num = $event->video->collect_num + 1;
            $event->video->save();
        };
    }
}