<?php

namespace app\admin\services;

class BaseService
{
    public function passwordHash($pwd)
    {
        return password_hash($pwd, PASSWORD_BCRYPT);
    }

}