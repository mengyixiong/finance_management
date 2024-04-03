<?php
declare (strict_types=1);

namespace app\admin\model\system;

use app\admin\exception\ApiException;
use think\Model;

/**
 * @mixin \think\Model
 */
class SystemUserModel extends Model
{
    # 表名
    protected $table = 'system_user';

    #
    public function setRolesAttr($value): string
    {
        if (empty($value)){
            $value = [];
        }
        $json = json_encode($value);
        if (false === $json) {
            throw new ApiException("设置用户权限失败!~ ");
        }
        return $json;
    }
}
