<?php
namespace App\Services\Auth\Tasks;

use App\User;
use App\Services\TaskContract;

class ResetPasswordToFindPassword implements TaskContract
{
    private $appId;
    private $nickname;
    private $password;

    public function __construct(int $appId, string $nickname, string $password)
    {
        $this->nickname = $nickname;
        $this->password = $password;
        $this->appId = $appId;
    }

    public function run()
    {
        User::where(User::APP_ID_FIELD, $this->appId)->where(User::NICKNAME_FIELD, $this->nickname)->update([User::PASSWORD_FIELD => $this->password]);
    }
}