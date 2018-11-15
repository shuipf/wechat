<?php

namespace shuipf\wechat\menu;

use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Delete
{
    /**
     * 接口地址
     */
    const DELETE_URL = 'https://api.weixin.qq.com/cgi-bin/menu/delete';

    /**
     * shuipf\wechat\Wechat\AccessToken.
     */
    protected $accessToken;

    /**
     * 构造方法.
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * 获取响应.
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
