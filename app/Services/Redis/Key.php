<?php
namespace App\Services\Redis;

class Key
{
    const USER_LOGIN_TOKEN = 'user:%d_token';
    const FIND_PASSWORD_VERIFY_CODE = 'app:%d_user:%s_find_password_verify_code';
}