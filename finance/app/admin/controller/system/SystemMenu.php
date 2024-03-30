<?php
declare (strict_types=1);

namespace app\admin\controller\system;

use app\admin\services\system\SystemMenuServices;
use core\basic\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\facade\App;
use think\Request;

#[Apidoc\Title("菜单管理")]
#[Apidoc\Group("system")]
class SystemMenu extends BaseController
{

    /**
     * @param App $app
     * @param SystemMenuServices $services
     */
    public function __construct(
        App                          $app,
        protected SystemMenuServices $services,
    )
    {
        parent::__construct($app);
    }

    #[
        Apidoc\Title("列表"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/system/system_menu"),
        Apidoc\Query(name: "keywords", type: "string", require: false, desc: "姓名"),
    ]
    public function index()
    {
        return app('json')->success(
            $this->services->getList(
                request()->get()
            )
        );
    }

    #[
        Apidoc\Title("创建显示"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/system/system_menu/create"),
    ]
    public function create()
    {
        return app('json')->success([]);
    }

    #[
        Apidoc\Title("创建"),
        Apidoc\Method("POST"),
        Apidoc\Param(name: "name", type: "string", require: true, desc: "组件名称"),
        Apidoc\Param(name: "title", type: "string", require: true, desc: "名称"),
        Apidoc\Param(name: "path", type: "string", require: true, desc: "前端路径"),
        Apidoc\Param(name: "route", type: "string", require: true, desc: "后端路由"),
        Apidoc\Param(name: "pid", type: "string", require: false, default: 0, desc: "父级ID"),
        Apidoc\Param(name: "icon", type: "string", require: false, desc: "图标"),
        Apidoc\Param(name: "rank", type: "string", require: false, desc: "排序"),
        Apidoc\Param(name: "mark", type: "string", require: false, desc: "备注"),
        Apidoc\Param(name: "is_show", type: "int", require: false, default: 1, desc: "是否显示"),
        Apidoc\Param(name: "type", type: "string", require: false, default: 'M', desc: "类型，M为菜单,B为按钮"),
        Apidoc\Url("/adminapi/system/system_menu"),
    ]
    public function save(Request $request)
    {
        $this->services->addMenu($request->post());
        return app('json')->success();
    }

    #[
        Apidoc\Title("详情"),
        Apidoc\Method("GET"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Url("/adminapi/system/system_menu/{id}"),
    ]
    public function read($id)
    {
        return app('json')->success(
            $this->services->getMenu((int)$id)
        );
    }

    #[
        Apidoc\Title("更新"),
        Apidoc\Method("PUT"),
        Apidoc\RouteParam(name: "id", type: "int", require: true, desc: "主键ID"),
        Apidoc\Param(name: "name", type: "string", require: true, desc: "组件名称"),
        Apidoc\Param(name: "title", type: "string", require: true, desc: "名称"),
        Apidoc\Param(name: "path", type: "string", require: true, desc: "前端路径"),
        Apidoc\Param(name: "route", type: "string", require: true, desc: "后端路由"),
        Apidoc\Param(name: "pid", type: "string", require: false, default: 0, desc: "父级ID"),
        Apidoc\Param(name: "icon", type: "string", require: false, desc: "图标"),
        Apidoc\Param(name: "rank", type: "string", require: false, desc: "排序"),
        Apidoc\Param(name: "mark", type: "string", require: false, desc: "备注"),
        Apidoc\Param(name: "is_show", type: "int", require: false, default: 1, desc: "是否显示"),
        Apidoc\Param(name: "type", type: "string", require: false, default: 'M', desc: "类型，M为菜单,B为按钮"),
        Apidoc\Url("/adminapi/system/system_menu/{id}"),
    ]
    public function update(Request $request, int $id)
    {
        $this->services->updateMenu($request->put(), $id);
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
