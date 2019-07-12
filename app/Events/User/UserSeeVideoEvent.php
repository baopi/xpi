<?php
namespace App\Events\User;

use App\Events\Event;
use App\Video;

class UserSeeVideoEvent extends Event
{
    public $video;

    public $user;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }
}
