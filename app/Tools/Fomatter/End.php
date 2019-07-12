<?php
namespace App\Tools\Fomatter;

use App\Tools\Singleton\SingletonTrait;

class End
{
    use SingletonTrait;

    //请求成功状态码
    const SUCCESS_CODE = 200;
    //验证状态码
    const VALIDATE_ERROR = 403;
    //内部程序错误状态码
    const INTERNAL_ERROR = 500;
    //认证是吧
    const UNAUTHORIZED_ERROR = 401;

    private function toSuccessJson(array $data = [], string $msg = '请求成功')
    {
        return json_encode([
            'status' => self::SUCCESS_CODE,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    private function toFailureJson(array $data = [], int $statusCode = self::INTERNAL_ERROR, string $msg = '请求错误')
    {
        return json_encode([
            'status' => $statusCode,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}