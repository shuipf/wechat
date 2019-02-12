<?php
// +----------------------------------------------------------------------
// | AccessToken 是公众号的全局唯一接口调用凭据，通过公众号 appid 和 appsecret 获取
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat;

use shuipf\wechat\bridge\Http;
use shuipf\wechat\bridge\CacheTrait;
use Doctrine\Common\Collections\ArrayCollection;

class AccessToken extends ArrayCollection
{
    /*
     * Cache Trait
     */
    use CacheTrait;

    /**
     * 接口地址
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140183
     */
    const ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token';

    /**
     * 手动设置的access_token，自动获取的会走缓存
     * @var string
     */
    private $accessToken;

    /**
     * 构造方法
     * AccessToken constructor.
     * @param string $appid 第三方用户唯一凭证
     * @param string $appsecret 第三方用户唯一凭证密钥，即appsecret
     */
    public function __construct($appid, $appsecret)
    {
        $this->set('appid', $appid);
        $this->set('appsecret', $appsecret);
    }

    /**
     * 手动设置accessToken
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * 获取 AccessToken，如果有设置缓存则走缓存否则直接请求api
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTokenString()
    {
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }
        $cacheId = $this->getCacheId();
        //从缓存中获取
        if ($this->cache && $data = $this->cache->fetch($cacheId)) {
            return $data['access_token'];
        }
        //走api获取
        $response = $this->getTokenResponse();
        if ($this->cache) {
            $this->cache->save($cacheId, $response, $response['expires_in']);
        }
        return $response['access_token'];
    }

    /**
     * 通过api获取 access_token
     * @return ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTokenResponse()
    {
        $query = [
            'grant_type' => 'client_credential',
            'appid' => $this->get('appid'),
            'secret' => $this->get('appsecret'),
        ];
        $response = Http::request('GET', static::ACCESS_TOKEN)
            ->withQuery($query)
            ->send();
        if ($response->containsKey('errcode')) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 获取缓存ID
     * @return string
     */
    public function getCacheId()
    {
        return sprintf('%s_access_token', $this['appid']);
    }
}
