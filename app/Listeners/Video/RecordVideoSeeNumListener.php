<?php
namespace App\Listeners\Video;

use App\Events\User\UserSeeVideoEvent;

class RecordVideoSeeNumListener
{
    public function handle(UserSeeVideoEvent $event)
    {
       $event->video->see_num = $event->video->see_num + 1;
       $event->video->real_see_num = $event->video->real_see_num + 1;
       $event->video->save();
    }
}