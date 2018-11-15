<?php
// +----------------------------------------------------------------------
// | User 用户信息、列表相关
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\user;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    use AccessTokenTrait;

    /**
     * 获取用户信息
     */
    const USERINFO = 'https://api.weixin.qq.com/cgi-bin/user/info';

    /**
     * 批量获取用户
     */
    const BETCH = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget';

    /**
     * 获取用户列表
     */
    const LISTS = 'https://api.weixin.qq.com/cgi-bin/user/get';

    /**
     * 构造方法
     * User constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 查询用户列表
     * @param null|string $nextOpenid 拉取列表的最后一个用户的OPENID
     * @return ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function lists($nextOpenid = null)
    {
        $query = null === $nextOpenid
            ? []
            : ['next_openid' => $nextOpenid];
        $response = Http::request('GET', static::LISTS)
            ->withAccessToken($this->accessToken)
            ->withQuery($query)
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 获取用户信息
     * @param string $openid 普通用户的标识，对当前公众号唯一
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($openid, $lang = 'zh_CN')
    {
        $query = [
            'openid' => $openid,
            'lang' => $lang,
        ];
        $response = Http::request('GET', static::USERINFO)
            ->withAccessToken($this->accessToken)
            ->withQuery($query)
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 批量获取用户信息
     * @param array $openid 用户的标识，对当前公众号唯一
     * @param string $lang 国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语，默认为zh-CN
     * @return ArrayCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBetch(array $openid, $lang = 'zh_CN')
    {
        $body = [];
        foreach ($openid as $key => $value) {
            $body['user_list'][$key]['openid'] = $value;
            $body['user_list'][$key]['lang'] = $lang;
        }
        $response = Http::request('POST', static::BETCH)
            ->withAccessToken($this->accessToken)
            ->withBody($body)
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return new ArrayCollection($response['user_info_list']);
    }
}
