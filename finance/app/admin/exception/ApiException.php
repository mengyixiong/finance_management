<?php

namespace app\admin\exception;

use Throwable;

class ApiException extends \RuntimeException
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}