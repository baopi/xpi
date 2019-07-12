<?php
namespace App\Services\Auth\Tasks;

use App\Tools\Encryptor\Encryptor;
use Illuminate\Support\Facades\Cache;
use App\Services\Redis\Key;
use App\Services\TaskContract;

class CreateLoginToken implements TaskContract
{
    private $userId;

    private $nickname;

    private $isRememberMe;

    private $appId;

    public function __construct(int $appId, int $userId, string $nickname, int $isRememberMe)
    {
        $this->userId = $userId;
        $this->nickname = $nickname;
        $this->isRememberMe = $isRememberMe;
        $this->appId = $appId;
    }

    public function run()
    {
        $this->isRememberMe ? $expire = 300 * 24 * 365 : $expire = 3600 * 24 * 7;

        if(!$token =  Encryptor::createJwtToken(null, $now = time(), $now + $expire, $now, ['uid' => $this->userId, 'nickname' => $this->nickname, 'aud' => $this->appId]))
            return false;

        if (!Cache::put(sprintf(Key::USER_LOGIN_TOKEN, $this->userId), $token, $expire)) {
            return false;
        }

        return $token;
    }
}