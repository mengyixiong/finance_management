<?php

namespace core\traits;

use app\admin\exception\ApiException;

trait PasswordEncoder
{
    /**
     * 加密
     * @param $pwd
     * @return string
     */
    public function passwordHash($pwd): string
    {
        $hashPassword = password_hash($pwd, PASSWORD_BCRYPT);
        if (empty($hashPassword)) {
            throw new ApiException("密码加密失败! ");
        }
        return $hashPassword;
    }

    /**
     * 验证密码
     * @param $pwd
     * @param $hash
     * @return bool
     */
    public function passwordVerify($pwd, $hash): bool
    {
        return password_verify($pwd, $hash);
    }
}