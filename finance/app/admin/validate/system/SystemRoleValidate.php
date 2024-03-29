<?php
declare (strict_types=1);

namespace app\admin\validate\system;

use think\Validate;

class SystemRoleValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'role_name' => 'require|length:2,16',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => '用户详情不存在',
        'role_name.require' => '名称不能为空',
        'role_name.length' => '名称长度为6-16位',
    ];

    /**
     * 场景
     */
    protected $scene = [
        'create' => [
            'role_name',
        ],

        'update' => [
            'role_name',
        ],
    ];
}
