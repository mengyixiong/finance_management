<?php
declare (strict_types=1);

namespace app\admin\controller\system;

use app\admin\services\system\SystemUserServices;
use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\Request;

#[Apidoc\Title("用户管理")]
#[Apidoc\Group("system")]
class SystemUser extends BaseController
{

    /**
     * @var SystemUserServices $services
     */
    public function __construct(
        protected SystemUserServices $services,
    )
    {
    }

    #[
        Apidoc\Title("列表"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/system/system_user"),
        Apidoc\Query(name: "keywords", type: "string", require: false, desc: "姓名"),
    ]
    public function index()
    {
        return app('json')->success(
            $this->services->pageQuery(
                request()->get()
            )
        );
    }

    #[
        Apidoc\Title("创建显示"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/system/system_user/create"),
    ]
    public function create()
    {
        return app('json')->success([]);
    }

    #[
        Apidoc\Title("创建"),
        Apidoc\Method("POST"),
        Apidoc\Param(name: "username", type: "string", require: true, desc: "用户名"),
        Apidoc\Param(name: "password", type: "string", require: true, desc: "密码"),
        Apidoc\Param(name: "real_name", type: "string", require: true, desc: "真实姓名"),
        Apidoc\Param(name: "head_pic", type: "string", require: true, desc: "头像"),
        Apidoc\Param(name: "roles", type: "array", require: true, desc: "角色集合"),
        Apidoc\Param(name: "dept", type: "int", require: false, default: 0, desc: "部门ID"),
        Apidoc\Url("/adminapi/system/system_user"),
    ]
    public function save(Request $request)
    {
        $this->services->addUser($request->post());
        return app('json')->success();
    }

    #[
        Apidoc\Title("详情"),
        Apidoc\Method("GET"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Url("/adminapi/system/system_user/{id}"),
    ]
    public function read($id)
    {
        return app('json')->success(
            $this->services->getUser((int)$id)
        );
    }

    #[
        Apidoc\Title("更新"),
        Apidoc\Method("PUT"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Param(name: "real_name", type: "string", require: true, desc: "真实姓名"),
        Apidoc\Param(name: "head_pic", type: "string", require: true, desc: "头像"),
        Apidoc\Param(name: "roles", type: "array", require: true, desc: "角色集合"),
        Apidoc\Param(name: "dept", type: "int", require: false, default: 0, desc: "部门ID"),
        Apidoc\Url("/adminapi/system/system_user/{id}"),
    ]
    public function update(Request $request, int $id)
    {
        $this->services->updateUser($request->put(), $id);
        return app('json')->success();
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
