<?php
declare (strict_types=1);

namespace app\admin\validate\system;

use think\Validate;

class SystemUserValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'username' => 'require|length:6,16',
        'password' => 'require|length:6,16',
        'real_name' => 'require|length:2,16',
        'dept' => 'require|integer',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => '用户详情不存在',
        'username.require' => '用户名不能为空',
        'username.length' => '用户名长度为6-16位',
        'password.require' => '密码不能为空',
        'password.length' => '密码长度为6-16位',
        'real_name.require' => '真实姓名不能为空',
        'real_name.length' => '真实姓名长度为2-16位',
        'dept.require' => '部门不能为空',
        'dept.integer' => '部门格式错误',
    ];

    /**
     * 场景
     */
    protected $scene = [
        'create' => [
            'username',
            'password',
            'real_name',
            'dept',
        ],

        'update' => [
            'real_name',
            'dept',
        ],

        'update_password' => [
            'id',
            'password',
        ],
    ];
}
