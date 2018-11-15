<?php
// +----------------------------------------------------------------------
// | Delete 删除菜单
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Delete
{
    use AccessTokenTrait;

    /**
     * 接口地址
     */
    const DELETE_URL = 'https://api.weixin.qq.com/cgi-bin/menu/delete';

    /**
     * 构造方法
     * Delete constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取响应
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doDelete()
    {
        $response = Http::request('GET', static::DELETE_URL)
            ->withAccessToken($this->accessToken)
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return true;
    }
}
