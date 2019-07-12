<?php
namespace App\Services\Auth\Tasks;

use App\Services\TaskContract;
use App\Jobs\EmailJob;
use App\Services\Redis\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class SendCodeToFindPassword implements TaskContract
{
    private $email;
    private $appId;
    private $nickname;

    public function __construct(string $email, int $appId, string $nickname)
    {
        $this->appId = $appId;
        $this->nickname = $nickname;
        $this->email = $email;
    }


    public function run()
    {
        $code = mt_rand(10000, 99999);
        $text = "您正在找回自己的密码，您的邮箱验证码未$code";

        Cache::put(sprintf(Key::FIND_PASSWORD_VERIFY_CODE, $this->appId, $this->nickname), $code, 60 * 50);//缓存单位是秒
        Queue::push(new EmailJob($text, $this->email, '找回密码'));
    }

}