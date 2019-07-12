<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],
        //捕抓sql日志
        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\QueryListener'
        ],
        //监听视频被观看动作
        'App\Events\User\UserSeeVideoEvent' => [
            'App\Listeners\Video\RecordVideoSeeNumListener',
            'App\Listeners\User\RecordUserSeeVideoListener'
        ],
        //监听用户收藏视频动作
        'App\Events\User\UserCollectVideoEvent' => [
            'App\Listeners\Video\CollectVideoListener',
            'App\Listeners\User\UserCollectVideoListener'
        ]
    ];
}
