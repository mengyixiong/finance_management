<?php
declare (strict_types=1);

namespace app\admin\controller\system;

use app\admin\services\system\SystemRoleServices;
use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\Request;

#[Apidoc\Title("角色管理")]
#[Apidoc\Group("system")]
class SystemRole extends BaseController
{
    /**
     * @var SystemRoleServices $services
     */
    public function __construct(
        protected SystemRoleServices $services,
    )
    {
    }

    #[
        Apidoc\Title("列表"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/system/system_role"),
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
        Apidoc\Url("/adminapi/system/system_role/create"),
    ]
    public function create()
    {
        return app('json')->success([]);
    }

    #[
        Apidoc\Title("创建"),
        Apidoc\Method("POST"),
        Apidoc\Param(name: "role_name", type: "string", require: true, desc: "名称"),
        Apidoc\Param(name: "menus", type: "array", require: false, desc: "菜单"),
        Apidoc\Param(name: "desc", type: "string", require: false, desc: "描述"),
        Apidoc\Url("/adminapi/system/system_role"),
    ]
    public function save(Request $request)
    {
        $this->services->addRole($request->post());
        return app('json')->success();
    }

    #[
        Apidoc\Title("详情"),
        Apidoc\Method("GET"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Url("/adminapi/system/system_role/{id}"),
    ]
    public function read($id)
    {
        return app('json')->success(
            $this->services->getRole((int)$id)
        );
    }

    #[
        Apidoc\Title("更新"),
        Apidoc\Method("PUT"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Param(name: "role_name", type: "string", require: true, desc: "名称"),
        Apidoc\Param(name: "menus", type: "array", require: false, desc: "菜单"),
        Apidoc\Param(name: "desc", type: "string", require: false, desc: "描述"),
        Apidoc\Url("/adminapi/system/system_role/{id}"),
    ]
    public function update(Request $request, int $id)
    {
        $this->services->updateRole($request->put(), $id);
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
