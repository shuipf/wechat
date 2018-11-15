<?php
// +----------------------------------------------------------------------
// | Ticket
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat\Jsapi;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\bridge\CacheTrait;
use shuipf\wechat\wechat\AccessToken;

class Ticket
{
    /*
     * Cache Trait
     */
    use CacheTrait,AccessTokenTrait;

    /**
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115
     */
    const JSAPI_TICKET = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket';

    /**
     * 构造方法
     * Ticket constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取 Jsapi 票据（调用缓存，返回 String）
     * @return string
     * @throws \Exception
     */
    public function getTicketString()
    {
        $cacheId = $this->getCacheId();
        if ($this->cache && $data = $this->cache->fetch($cacheId)) {
            return $data['ticket'];
        }
        $response = $this->getTicketResponse();
        if ($this->cache) {
            $this->cache->save($cacheId, $response, $response['expires_in']);
        }
        return $response['ticket'];
    }

    /**
     * 通过接口直接获取 Jsapi 票据
     * @return \Doctrine\Common\Collections\ArrayCollection|string
     * @throws \Exception
     */
    public function getTicketResponse()
    {
        $response = Http::request('GET', static::JSAPI_TICKET)
            ->withAccessToken($this->accessToken)
            ->withQuery(['type' => 'jsapi'])
            ->send();
        //是否有错误
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 获取缓存 ID
     * @return string
     */
    public function getCacheId()
    {
        return sprintf('%s_jsapi_ticket', $this->accessToken['appid']);
    }
}
