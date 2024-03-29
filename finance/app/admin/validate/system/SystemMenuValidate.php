<?php
declare (strict_types=1);

namespace app\admin\validate\system;

use think\Validate;

class SystemMenuValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require',
        'name' => 'require',
        'title' => 'require',
        'path' => 'require',
        'route' => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => '详情不存在',
        'name.require' => '组件名称不能为空',
        'title.require' => '名称不能为空',
        'path.require' => '路径不能为空',
        'route.require' => '路由不能为空',
    ];

    /**
     * 场景
     */
    protected $scene = [
        'create' => [
            'name',
            'title',
            'path',
            'route',
        ],

        'update' => [
            'name',
            'title',
            'path',
            'route',
        ],
    ];
}
