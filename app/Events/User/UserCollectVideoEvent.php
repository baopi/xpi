<?php
namespace App\Events\User;

use App\Events\Event;
use App\Video;

class UserCollectVideoEvent extends Event
{
    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }
}