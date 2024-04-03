<?php

namespace app\admin\dao\system;

use app\admin\model\system\SystemUserModel;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;

class SystemUserDao
{
    public function __construct(
        protected SystemUserModel $model
    )
    {
    }

    /**
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    public function findByUsername(string $username)
    {
        return $this->model->where('username', $username)->findOrFail();
    }
}