<?php

namespace shuipf\wechat\message\Template;

use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Sender
{
    /**
     * 发送接口 URL.
     */
    const SENDER = 'https://api.weixin.qq.com/cgi-bin/message/template/send';

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
     * 发送模板消息.
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
