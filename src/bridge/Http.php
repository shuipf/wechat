<?php
// +----------------------------------------------------------------------
// | Http
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\bridge;

use GuzzleHttp\Client;
use shuipf\wechat\wechat\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

class Http
{
    /**
     * 请求地址
     * @var string
     */
    protected $uri;

    /**
     * 请求方式
     * @var string
     */
    protected $method;

    /**
     * 请求Body
     * @var string
     */
    protected $body;

    /**
     * 请求参数
     * @var array
     */
    protected $query = [];

    /**
     * SSL证书
     */
    protected $sslCert;
    protected $sslKey;

    /**
     * 构造函数
     * Http constructor.
     * @param string $method 请求方式
     * @param string $uri 请求地址
     */
    public function __construct($method, $uri)
    {
        $this->uri = $uri;
        $this->method = strtoupper($method);
    }

    /**
     * 绑定请求参数
     * @param array $query
     * @return $this
     */
    public function withQuery(array $query)
    {
        $this->query = array_merge($this->query, $query);
        return $this;
    }

    /**
     * 绑定请求body json
     * @param array $body
     * @return $this
     */
    public function withBody(array $body)
    {
        $this->body = Serializer::jsonEncode($body);
        return $this;
    }

    /**
     * Request Xml Body
     * @param array $body
     * @return $this
     */
    public function withXmlBody(array $body)
    {
        $this->body = Serializer::xmlEncode($body);
        return $this;
    }

    /**
     * 绑定access_token
     * @param AccessToken $accessToken
     * @return $this
     * @throws \Exception
     */
    public function withAccessToken(AccessToken $accessToken)
    {
        $this->query['access_token'] = $accessToken->getTokenString();
        return $this;
    }

    /**
     *  Request SSL Cert
     * @param string $sslCert
     * @param string $sslKey
     * @return $this
     */
    public function withSSLCert($sslCert, $sslKey)
    {
        $this->sslCert = $sslCert;
        $this->sslKey = $sslKey;
        return $this;
    }

    /**
     * 发送请求
     * @param bool $asArray
     * @return ArrayCollection|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($asArray = true)
    {
        $options = [];
        // query
        if (!empty($this->query)) {
            $options['query'] = $this->query;
        }
        // body
        if (!empty($this->body)) {
            $options['body'] = $this->body;
        }
        // ssl cert
        if ($this->sslCert && $this->sslKey) {
            $options['cert'] = $this->sslCert;
            $options['ssl_key'] = $this->sslKey;
        }
        $response = (new Client())->request($this->method, $this->uri, $options);
        $contents = $response->getBody()->getContents();

        if (!$asArray) {
            return $contents;
        }
        $array = Serializer::parse($contents);
        return new ArrayCollection($array);
    }

    /**
     * 创建一个请求对象
     * @param string $method 请求方式
     * @param string $uri 请求地址
     * @return Http
     */
    public static function request($method, $uri)
    {
        return new static($method, $uri);
    }
}
