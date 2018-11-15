<?php
// +----------------------------------------------------------------------
// | ShortUrl 长链接转短链接接口
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1443433600
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\bridge\CacheTrait;

class ShortUrl
{
    /*
     * Cache Trait
     */
    use CacheTrait, AccessTokenTrait;

    /**
     * 微信接口地址
     */
    const SHORT_URL = 'https://api.weixin.qq.com/cgi-bin/shorturl';

    /**
     * 构造方法
     * ShortUrl constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取短链接
     * @param string $longUrl 需要转换的长链接
     * @param int $cacheLifeTime 缓存时间
     * @return mixed
     * @throws \Exception
     */
    public function toShort($longUrl, $cacheLifeTime = 86400)
    {
        $cacheId = md5($longUrl);
        if ($this->cache && $data = $this->cache->fetch($cacheId)) {
            return $data;
        }
        $body = [
            'action' => 'long2short',
            'long_url' => $longUrl,
        ];
        $response = Http::request('POST', static::SHORT_URL)
            ->withAccessToken($this->accessToken)
            ->withBody($body)
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        if ($this->cache) {
            $this->cache->save($cacheId, $response['short_url'], $cacheLifeTime);
        }
        return $response['short_url'];
    }
}
