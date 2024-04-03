<?php
// 应用公共文件
if (!function_exists('now_datetime')) {
    /**
     * 获取当前时间(年-月-日 时:分:秒)
     */
    function now_datetime()
    {
        return date('Y-m-d H:i:s');
    }
}