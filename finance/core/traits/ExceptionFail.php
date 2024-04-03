<?php

namespace core\traits;

use app\admin\exception\ApiException;

trait ExceptionFail
{
    public function apiException($message = "", $previous = null, $code = 0)
    {
        if (env('APP_DEBUG') && is_object($previous)) {
            $message = [
                'user_message' => $message,
                'throw_message' => $previous->getMessage(),
                'file' => $previous->getFile(),
                'line' => $previous->getLine(),
                'trace' => $previous->getTraceAsString(),
                'code' => $previous->getCode(),
                'previous' => $previous->getPrevious()
            ];

            return app('json')->print($message);
        }

        throw new ApiException($message, $code, $previous);
    }
}