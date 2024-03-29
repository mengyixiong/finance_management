<?php
declare (strict_types=1);

namespace app\admin\model\system;

use think\Model;

/**
 * @mixin \think\Model
 */
class SystemRoleModel extends Model
{
    # 表名
    protected $table = 'system_role';
}
