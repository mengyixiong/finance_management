<?php
declare (strict_types=1);

namespace app\admin\services\system;

use app\admin\exception\ApiException;
use app\admin\model\system\SystemUserModel;
use app\admin\validate\system\SystemUserValidate;
use app\service\BaseService;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;

/**
 * 系统设置-后台管理员逻辑
 */
class SystemUserServices extends BaseService
{
    public function __construct(
        protected SystemUserModel    $model,
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
    public function addUser(mixed $post)
    {
        # 验证
        if (!$this->validate->scene('create')->check($post)) {
            throw new ApiException($this->validate->getError());
        }

        # 头像为空使用默认头像
        if (empty($post['head_pic'])) {
            $post['head_pic'] = '/static/images/default_head_pic.png';
        }

        # 加密密码
        $post['password'] = $this->passwordHash($post['password']);

        try {
            return $this->model->save($post);
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 获取用户
     */
    public function getUser(int $id)
    {
        try {
            $user = $this->model->findOrFail($id);
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("用户不存在");
        }
        unset($user->password);
        return $user->toArray();
    }

    /**
     * 修改密码
     */
    public function updatePassword(array $post)
    {
        # 验证
        if (!$this->validate->scene('update_password')->check($post)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            # 获取用户
            $user = $this->model->findOrFail($post['id']);

            $user->setAttrs([
                # 加密密码
                'password' => $this->passwordHash($post['password'])
            ]);
            $user->save();
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("用户不存在");
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @param mixed $put
     */
    public function updateUser(array $put, int $id)
    {
        # 验证
        if (!$this->validate->scene('update')->check($put)) {
            throw new ApiException($this->validate->getError());
        }

        try {
            # 获取用户
            $user = $this->model->findOrFail($id);
            $user->real_name = $put['real_name'];
            $user->roles = $put['roles'];
            $user->dept = $put['dept'];
            $user->head_pic = $put['head_pic'];
            $res = $user->save();
            if (!$res) {
                throw new ApiException("更新失败! ");
            }
        } catch (DataNotFoundException|ModelNotFoundException $e) {
            throw new ApiException("用户不存在");
        } catch (\Throwable $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
