<?php

namespace app\admin\controller;

use app\admin\enums\system\SystemUserStatus;
use app\admin\services\AuthServices;
use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\facade\App;

/**
 * 授权控制器
 */
#[Apidoc\Title("认证管理")]
#[Apidoc\Group("public")]
class Auth extends BaseController
{
    public function __construct(App                    $app,
                                protected AuthServices $services
    )
    {
        parent::__construct($app);
    }

    #[
        Apidoc\Title("登录"),
        Apidoc\Tag("登录,login"),
        Apidoc\Method("POST"),
        Apidoc\Url("/adminapi/auth/login"),
        Apidoc\Param(name: "username", type: "string", require: true, desc: "用户名"),
        Apidoc\Param(name: "password", type: "string", require: true, desc: "密码"),
    ]
    public function login()
    {
        return app('json')->success($this->services->doLogin());
    }

    #[
        Apidoc\Title("退出登录"),
        Apidoc\Tag("登出,退出,logout"),
        Apidoc\Method("POST"),
        Apidoc\Url("/adminapi/auth/logout"),
    ]
    public function logout()
    {
        return app('json')->success([]);
    }
}