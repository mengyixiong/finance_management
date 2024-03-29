<?php
declare (strict_types=1);

namespace app\admin\services\system;

use app\admin\exception\ApiException;
use app\admin\model\system\SystemMenuModel;
use app\admin\services\BaseService;
use app\admin\validate\system\SystemMenuValidate;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;

/**
 * 系统设置-后台管理员逻辑
 */
class SystemMenuServices extends BaseService
{
    public function __construct(
        protected SystemMenuModel    $model,
        protected SystemMenuValidate $validate
    )
    {
    }

    /**
     * 添加用户
     * @param mixed $post
     */
    public function addMenu(mixed $post)
    {
        # 验证
        if (!$this->validate->scene('create')->check($post)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            return $this->model->save($post);
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 获取用户
     */
    public function getMenu(int $id)
    {
        try {
            $menu = $this->model->findOrFail($id);
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("角色不存在");
        }
        unset($menu->password);
        return $menu->toArray();
    }

    /**
     * @param mixed $put
     */
    public function updateMenu(array $put, int $id)
    {
        # 验证
        if (!$this->validate->scene('update')->check($put)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            # 获取用户
            $menu = $this->model->findOrFail($id);
            $menu->real_name = $put['role_name'];
            $res = $menu->save();
            if (!$res) {
                throw new ApiException("更新失败! ");
            }
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("角色不存在");
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function getList(mixed $params)
    {
        $where = [];
        if (!empty($params['keywords'])) {
            $where[] = ['real_name', 'like', '%' . $params['keywords'] . '%'];
        }

        $menus = $this->model->where($where)->select()->toArray();

        # 处理成前端需要的route
        $routes = [];
        foreach ($menus as $menu) {
            $routes[] = [
                'id' => $menu['id'],
                'pid' => $menu['pid'],
                'name' => $menu['name'],
                'path' => $menu['path'],
                'meta' => [
                    'title' => $menu['title'],
                    'icon' => $menu['icon'],
                    'rank' => $menu['rank'],
                ],
            ];
        }
        $routes = $this->buildTree($routes);
        foreach ($routes as &$route) {
            if (empty($route['children'])) {
                $route['children'][] = $route;
            }
        }
        return $routes;
    }

    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['pid'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
