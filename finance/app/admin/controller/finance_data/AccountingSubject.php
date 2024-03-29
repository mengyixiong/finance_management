<?php
declare (strict_types = 1);

namespace app\admin\controller\finance_data;

use app\BaseController;
use think\Request;
use hg\apidoc\annotation as Apidoc;

#[Apidoc\Title("会计科目")]
#[Apidoc\Group("finance_data")]
class AccountingSubject extends BaseController
{
    #[
        Apidoc\Title("列表"),
        Apidoc\Method("GET"),
        Apidoc\Url("/adminapi/finance_data/accounting_subject"),
        Apidoc\Query(name: "username", type: "string", require: true, desc: "姓名", mock: "@name"),
        Apidoc\Query(name: "password", type: "string", require: true, desc: "密码", mock: "@password"),
        Apidoc\Returned("id", type: "int", desc: "Id"),
    ]
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
