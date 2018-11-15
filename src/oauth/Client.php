<?php
// +----------------------------------------------------------------------
// | Client 发起授权
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\oauth;

class Client extends AbstractClient
{
    /**
     * 授权接口地址
     * @return string
     */
    public function resolveAuthorizeUrl()
    {
        return 'https://open.weixin.qq.com/connect/oauth2/authorize';
    }

    /**
     * 授权作用域
     * @return string
     */
    public function resolveScope()
    {
        return $this->scope ?: 'snsapi_base';
    }
}
