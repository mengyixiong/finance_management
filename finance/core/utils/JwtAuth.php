<?php
// +----------------------------------------------------------------------
// | CRMEB [ CRMEB赋能开发者，助力企业发展 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2023 https://www.crmeb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed CRMEB并不是自由软件，未经许可不能去掉CRMEB相关版权
// +----------------------------------------------------------------------
// | Author: CRMEB Team <admin@crmeb.com>
// +----------------------------------------------------------------------

namespace core\utils;


use app\admin\exception\ApiException;
use core\services\CacheService;
use core\traits\ExceptionFail;
use Firebase\JWT\JWT;
use think\facade\Env;

/**
 * Jwt
 * Class JwtAuth
 * @package crmeb\utils
 */
class JwtAuth
{
    use ExceptionFail;

    /**
     * token
     * @var string
     */
    protected $token;

    /**
     * 获取token
     * @param int|string $id
     * @param string $type
     * @param array $params
     * @return array
     */
    public function getToken($id, string $type, array $params = []): array
    {
        $host = app('request')->host();
        $time = time();
        $exp_time = strtotime('+ 30day');
        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => $exp_time,
        ];
        $params['jti'] = compact('id', 'type');
        $token = JWT::encode($params,
            env('app.app_key', 'default'),
            env('app.app_alg', 'HS256')
        );
        return compact('token', 'params');
    }

    /**
     * 解析token
     * @param string $jwt
     * @return array
     */
    public function parseToken(string $jwt): array
    {
        $this->token = $jwt;
        list($headb64, $bodyb64, $cryptob64) = explode('.', $this->token);
        $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64));
        return [$payload->jti->id, $payload->jti->type, $payload->pwd ?? ''];
    }

    /**
     * 验证token
     */
    public function verifyToken()
    {
        JWT::$leeway = 60;

        JWT::decode($this->token, Env::get('app.app_key', 'default'), array('HS256'));

        $this->token = null;
    }

    /**
     * 获取token并放入令牌桶
     * @param $id
     * @param string $type
     * @param array $params
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function createToken($id, string $type, array $params = [])
    {
        $tokenInfo = $this->getToken($id, $type, $params);
        $exp = $tokenInfo['params']['exp'] - $tokenInfo['params']['iat'] + 60;
        $res = CacheService::set(
            md5($tokenInfo['token']),
            ['uid' => $id, 'type' => $type, 'token' => $tokenInfo['token'], 'exp' => $exp],
            (int)$exp,
            $type
        );
        if (!$res) {
            $this->apiException("用户登录失败，请重试");
        }
        return $tokenInfo;
    }
}
