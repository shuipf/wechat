<?php
// +----------------------------------------------------------------------
// | Sender 发送模板消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\template;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Sender
{
    use AccessTokenTrait;

    /**
     * 发送接口 URL.
     */
    const SENDER = 'https://api.weixin.qq.com/cgi-bin/message/template/send';

    /**
     * 构造方法
     * Sender constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 发送模板消息
     * @param TemplateInterface $template
     * @return string 消息ID
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(TemplateInterface $template)
    {
        $response = Http::request('POST', static::SENDER)
            ->withAccessToken($this->accessToken)
            ->withBody($template->getRequestBody())
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response['msgid'];
    }
}
