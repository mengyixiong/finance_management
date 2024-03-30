<?php

namespace app\admin\controller;

use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\App;

/**
 * 授权控制器
 */
#[Apidoc\Title("认证管理")]
#[Apidoc\Group("public")]
class Auth extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    #[
        Apidoc\Title("登录"),
        Apidoc\Tag("登录,login"),
        Apidoc\Method("POST"),
        Apidoc\Url("/adminapi/auth/login"),
        Apidoc\Query(name: "username", type: "string", require: true, desc: "姓名", mock: "@name"),
        Apidoc\Query(name: "password", type: "string", require: true, desc: "密码", mock: "@password"),
        Apidoc\Returned("id", type: "int", desc: "Id"),
    ]
    public function login()
    {


        return 'hello world';
    }
}