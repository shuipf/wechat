<?php
// +----------------------------------------------------------------------
// | AccessToken 网页授权access_token
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\oauth;

use shuipf\wechat\bridge\Http;
use Doctrine\Common\Collections\ArrayCollection;

class AccessToken extends ArrayCollection
{
    /**
     * 刷新 access_token.
     */
    const REFRESH = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';

    /**
     * 检测 access_token 是否有效.
     */
    const IS_VALID = 'https://api.weixin.qq.com/sns/auth';

    /**
     * 网页授权获取用户信息.
     */
    const USERINFO = 'https://api.weixin.qq.com/sns/userinfo';

    /**
     * 用户 access_token 和公众号是一一对应的
     * @var string
     */
    protected $appid;

    /**
     * 构造方法
     * AccessToken constructor.
     * @param string $appid
     * @param array $options
     */
    public function __construct($appid, array $options)
    {
        $this->appid = $appid;
        parent::__construct($options);
    }

    /**
     * 获取公众号 appid
     * @return string
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * 获取用户信息
     * @param string $lang
     * @return ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUser($lang = 'zh_CN')
    {
        //检测用户 access_token 是否有效
        if (!$this->isValid()) {
            $this->refresh();
        }
        $query = [
            'access_token' => $this['access_token'],
            'openid' => $this['openid'],
            'lang' => $lang,
        ];
        $response = Http::request('GET', static::USERINFO)
            ->withQuery($query)
            ->send();

        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 刷新用户 access_token
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refresh()
    {
        $query = [
            'appid' => $this->appid,
            'grant_type' => 'refresh_token',
            'refresh_token' => $this['refresh_token'],
        ];
        $response = Http::request('GET', static::REFRESH)
            ->withQuery($query)
            ->send();

        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        parent::__construct($response->toArray());
        return $this;
    }

    /**
     * 检测用户 access_token 是否有效
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isValid()
    {
        $query = [
            'access_token' => $this['access_token'],
            'openid' => $this['openid'],
        ];
        $response = Http::request('GET', static::IS_VALID)
            ->withQuery($query)
            ->send();
        return 'ok' === $response['errmsg'];
    }
}
