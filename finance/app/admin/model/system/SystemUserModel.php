<?php
declare (strict_types=1);

namespace app\admin\model\system;

use think\Model;

/**
 * @mixin \think\Model
 */
class SystemUserModel extends Model
{
    # 表名
    protected $table = 'system_user';

    #
    public function setRolesAttr($value)
    {
        return json_encode($value);
    }

}
