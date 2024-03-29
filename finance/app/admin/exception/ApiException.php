<?php

namespace app\admin\exception;

use Throwable;

class ApiException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (!env('APP_DEBUG')) {
            $message = '系统错误,请联系管理员';
        }
        parent::__construct($message, $code, $previous);
    }
}