<?php
// +----------------------------------------------------------------------
// | ServerIp 获取微信服务器IP
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140187
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\bridge\CacheTrait;

class ServerIp
{
    /*
     * Cache Trait
     */
    use CacheTrait,AccessTokenTrait;

    /**
     * 微信接口地址
     */
    const SERVER_IP = 'https://api.weixin.qq.com/cgi-bin/getcallbackip';

    /**
     * 构造方法
     * ServerIp constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取微信服务器 IP（默认缓存 1 天）
     * @param int $cacheLifeTime 缓存时间
     * @return array
     * @throws \Exception
     */
    public function getIps($cacheLifeTime = 86400)
    {
        $cacheId = $this->getCacheId();
        if ($this->cache && $data = $this->cache->fetch($cacheId)) {
            return $data['ip_list'];
        }
        $response = Http::request('GET', static::SERVER_IP)
            ->withAccessToken($this->accessToken)
            ->send();
        if ($response->containsKey('errcode')) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        if ($this->cache) {
            $this->cache->save($cacheId, $response, $cacheLifeTime);
        }
        return $response['ip_list'];
    }

    /**
     * 获取缓存 ID
     * @return string
     */
    public function getCacheId()
    {
        return str_replace('\\', '_', strtolower(__CLASS__));
    }
}
