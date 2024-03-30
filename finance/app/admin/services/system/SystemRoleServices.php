<?php
declare (strict_types=1);

namespace app\admin\services\system;

use app\admin\exception\ApiException;
use app\admin\model\system\SystemMenuModel;
use app\admin\model\system\SystemRoleMenuModel;
use app\admin\model\system\SystemRoleModel;
use app\admin\services\BaseService;
use app\admin\validate\system\SystemRoleValidate;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;

/**
 * 系统设置-后台管理员逻辑
 */
class SystemRoleServices extends BaseService
{
    public function __construct(
        protected SystemRoleModel    $model,
        protected SystemRoleValidate $validate
    )
    {
    }

    /**
     * 分页查询
     * @param $params
     * @return array
     * @throws \think\db\exception\DbException
     */
    public function pageQuery($params): array
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 15;

        $where = [];
        if (!empty($params['keywords'])) {
            $where[] = ['real_name', 'like', '%' . $params['keywords'] . '%'];
        }

        return $this->model->where($where)->paginate([
            'page' => $page,
            'list_rows' => $limit,
        ])->toArray();
    }

    /**
     * 添加用户
     * @param mixed $post
     */
    public function addRole(mixed $post)
    {
        # 验证
        if (!$this->validate->scene('create')->check($post)) {
            throw new ApiException($this->validate->getError());
        }

        Db::transaction(function () use ($post) {
            $role = new SystemRoleModel();
            $role->data($post);
            $role->allowField([
                'role_name',
                'desc',
                'level',
                'status',
            ])->save();

            # 添加关联数据
            $relevance = [];
            foreach ($post['menus'] as $menu) {
                # 检查每个ID是否有效
                try {
                    $menu = SystemMenuModel::findOrFail($menu);
                } catch (DataNotFoundException|ModelNotFoundException $e) {
                    throw new ApiException($menu . ",菜单不存在");
                }

                $relevance[] = [
                    'role_id' => $role->id,
                    'menu_id' => $menu->id,
                ];
            }
            (new SystemRoleMenuModel)->saveAll($relevance);
        });

    }

    /**
     * 获取用户
     */
    public function getRole(int $id)
    {
        try {
            $role = $this->model->findOrFail($id);
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("角色不存在");
        }
        unset($role->password);
        return $role->toArray();
    }

    /**
     * @param mixed $put
     */
    public function updateRole(array $put, int $id)
    {
        # 验证
        if (!$this->validate->scene('update')->check($put)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            # 获取用户
            $role = $this->model->findOrFail($id);
            $role->real_name = $put['role_name'];
            $res = $role->save();
            if (!$res) {
                throw new ApiException("更新失败! ");
            }
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("角色不存在");
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
