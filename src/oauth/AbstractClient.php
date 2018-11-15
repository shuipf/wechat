<?php
// +----------------------------------------------------------------------
// | AbstractClient
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\oauth;

use shuipf\wechat\bridge\Util;
use shuipf\wechat\bridge\Http;

abstract class AbstractClient
{
    /**
     * 获取用户临时AccessToken接口地址
     */
    const ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    /**
     * 公众号 Appid
     * @var string
     */
    protected $appid;

    /**
     * 公众号 AppSecret
     * @var string
     */
    protected $appsecret;

    /**
     * 应用授权作用域
     * @var string
     */
    protected $scope;

    /**
     * 重定向后会带上state参数
     * @var string
     */
    protected $state;

    /**
     * 授权后重定向的回调链接地址
     * @var string
     */
    protected $redirectUri;

    /**
     * session
     * @var StateManager
     */
    protected $stateManager;

    /**
     * 构造方法
     * AbstractClient constructor.
     * @param string $appid 公众号 Appid
     * @param string $appsecret 公众号 AppSecret
     */
    public function __construct($appid, $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->stateManager = new StateManager();
    }

    /**
     * 应用授权作用域
     * @param string $scope
     * @return $this
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * 重定向后会带上state参数
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * 授权后重定向的回调链接地址
     * @param string $redirectUri
     * @return $this
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    /**
     * 获取授权地址
     * @return string
     */
    public function getAuthorizeUrl()
    {
        if (null === $this->state) {
            $this->state = Util::getRandomString(16);
        }
        //缓存state
        $this->stateManager->setState($this->state);
        $query = [
            'appid' => $this->appid,
            'redirect_uri' => $this->redirectUri ?: Util::getCurrentUrl(),
            'response_type' => 'code',
            'scope' => $this->resolveScope(),
            'state' => $this->state,
        ];
        return $this->resolveAuthorizeUrl() . '?' . http_build_query($query);
    }

    /**
     * 通过 code 换取 AccessToken
     * @param $code
     * @param null $state
     * @return AccessToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccessToken($code, $state = null)
    {
        //校验state
        if (null === $state && !isset($_GET['state'])) {
            throw new \Exception('Invalid Request');
        }
        //验证state
        $state = $state ?: $_GET['state'];
        if (!$this->stateManager->isValid($state)) {
            throw new \Exception(sprintf('Invalid Authentication State "%s"', $state));
        }
        $query = [
            'appid' => $this->appid,
            'secret' => $this->appsecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $response = Http::request('GET', static::ACCESS_TOKEN)
            ->withQuery($query)
            ->send();
        //是否有错误
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        //返回用户access_token
        return new AccessToken($this->appid, $response->toArray());
    }

    /**
     * 授权接口地址
     * @return string
     */
    abstract public function resolveAuthorizeUrl();

    /**
     * 授权作用域
     * @return string
     */
    abstract public function resolveScope();
}
