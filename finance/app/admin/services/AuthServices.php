<?php
declare (strict_types=1);

namespace app\admin\services;

use app\admin\dao\system\SystemUserDao;
use app\admin\enums\system\SystemUserStatus;
use app\admin\exception\ApiException;
use app\admin\validate\AuthValidate;
use core\traits\ExceptionFail;
use core\traits\PasswordEncoder;
use core\utils\JwtAuth;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;

/**
 * 认证服务
 */
class AuthServices extends BaseService
{
    use PasswordEncoder, ExceptionFail;

    public function __construct(
        protected SystemUserDao $dao,
        protected AuthValidate  $validate,
        protected JwtAuth       $jwt
    )
    {
    }

    /**
     * 登录
     */
    public
    function doLogin()
    {
        $post = request()->post();

        # 验证
        if (!$this->validate->scene('login')->check($post)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            $user = $this->dao->findByUsername($post['username']);
            if ($user->status != SystemUserStatus::StatusNormal->getValue()) {
                $this->apiException("账号已被禁用! ");
            }

            $user->last_time = now_datetime();
            $user->last_ip = app('request')->ip();
            $user->login_count += 1;
            $user->save();
        } catch (\Throwable $e) {
            $this->apiException("账号或密码不存在! ", $e);
        }

        # 验证密码
        if (!$this->passwordVerify($post['password'], $user->password)) {
            throw new ApiException("账号或密码不存在! ");
        }

        $token = $this->jwt->createToken($user->id, 'adminapi', ['pwd' => $post['password']]);
        echo "<pre>";
        print_r($token);
        die;
        return [];
    }
}
