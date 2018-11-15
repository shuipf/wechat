<?php

namespace shuipf\wechat\wechat\Qrcode;

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
     * 生成二维码接口地址
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1443433542
     */
    const TICKET_URL = 'https://api.weixin.qq.com/cgi-bin/qrcode/create';

    //临时的整型参数值
    const QR_SCENE = 'QR_SCENE';
    //临时的字符串参数值
    const QR_STR_SCENE = 'QR_STR_SCENE';
    //永久的整型参数值
    const QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';
    //永久的字符串参数值
    const QR_LIMIT_STR_SCENE = 'QR_LIMIT_STR_SCENE';

    /**
     * 二维码类型
     * @var string
     */
    protected $type;

    /**
     * 二维码场景值
     * @var
     */
    protected $scene;

    /**
     * 永久二维码因场景值类型不同，发送的 Key 也不同
     * @var string
     */
    protected $sceneKey;

    /**
     * 二维码有效期（临时二维码可用）
     * @var int
     */
    protected $expire;

    /**
     * 构造方法
     * Ticket constructor.
     * @param AccessToken $accessToken
     * @param string $type 二维码类型
     * @param string $scene 场景
     * @param int $expire 临时二维码有效期
     */
    public function __construct(AccessToken $accessToken, $type, $scene, $expire = 2592000)
    {
        $constraint = [
            static::QR_SCENE => 'integer',
            static::QR_STR_SCENE => 'string',
            static::QR_LIMIT_SCENE => 'integer',
            static::QR_LIMIT_STR_SCENE => 'string',
        ];
        $type = strtoupper($type);
        //检查二维码类型是否支持
        if (!array_key_exists($type, $constraint)) {
            throw new \InvalidArgumentException(sprintf('Invalid Qrcode Type: %s', $type));
        }
        //检查场景值是否符合对应二维码类型要求
        $callback = sprintf('is_%s', $constraint[$type]);
        if (!call_user_func($callback, $scene)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'parameter "scene" must be %s, %s given', $constraint[$type], gettype($scene)
                )
            );
        }
        $this->type = $type;
        $this->scene = $scene;
        $this->sceneKey = (is_int($scene) ? 'scene_id' : 'scene_str');
        $this->expire = $expire;
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取 Qrcode 票据（调用缓存，返回 String）
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
            $this->cache->save($cacheId, $response, $response['expire_seconds'] ?: 0);
        }
        return $response['ticket'];
    }

    /**
     * 通过API获取 Qrcode 票据
     * @return \Doctrine\Common\Collections\ArrayCollection|string
     * @throws \Exception
     */
    public function getTicketResponse()
    {
        $response = Http::request('POST', static::TICKET_URL)
            ->withAccessToken($this->accessToken)
            ->withBody($this->getRequestBody())
            ->send();
        //是否有错误
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return $response;
    }

    /**
     * 获取请求内容
     * @return array
     */
    public function getRequestBody()
    {
        $options = [
            'action_name' => $this->type,
            'action_info' => [
                'scene' => [$this->sceneKey => $this->scene],
            ],
        ];
        //临时二维码需要设置有效期
        if ($options['action_name'] === static::QR_SCENE || $options['action_name'] == static::QR_STR_SCENE) {
            $options['expire_seconds'] = $this->expire;
        }
        return $options;
    }

    /**
     * 获取缓存 ID
     * @return string
     */
    public function getCacheId()
    {
        return implode('_', [$this->accessToken['appid'], $this->type, $this->sceneKey, $this->scene]);
    }
}
