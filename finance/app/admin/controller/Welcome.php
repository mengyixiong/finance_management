<?php

namespace app\admin\controller;

use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;

#[Apidoc\Title("首页")]
#[Apidoc\Group("public")]
class Welcome extends BaseController
{
    #[
        Apidoc\Title("首页信息展示"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/welcome"),
        Apidoc\Query(name: "keywords", type: "string", require: false, desc: "姓名"),
    ]
    public function index()
    {
        return app('json')->success([]);
    }
}