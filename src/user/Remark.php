<?php
// +----------------------------------------------------------------------
// | Remark 设置用户备注名
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140838
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\user;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Remark
{
    use AccessTokenTrait;

    /**
     * 设置用户备注名接口地址
     */
    const REMARK = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark';

    /**
     * 构造方法
     * Remark constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 设置/更新用户备注
     * @param string $openid 用户标识
     * @param string $remark 新的备注名，长度必须小于30字符
     * @return \Doctrine\Common\Collections\ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($openid, $remark)
    {
        $body = [
            'openid' => $openid,
            'remark' => $remark,
        ];
        $response = Http::request('POST', static::REMARK)
            ->withAccessToken($this->accessToken)
            ->withBody($body)
            ->send();
        //检查是否有错误
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }
}
