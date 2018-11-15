<?php
// +----------------------------------------------------------------------
// | AccessTokenTrait
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\bridge;

use shuipf\wechat\wechat\AccessToken;

trait AccessTokenTrait
{
    /**
     * 全局access_token
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * 设置全局access_token对象
     * @param AccessToken $accessToken
     * @return $this
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * 获取access_token对象
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
