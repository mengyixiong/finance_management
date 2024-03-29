<?php
declare (strict_types=1);

namespace app;

use core\utils\Json;
use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        $this->app->bind('json', Json::class);
    }

    public function boot()
    {
        // 服务启动
    }
}
