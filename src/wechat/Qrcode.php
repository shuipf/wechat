<?php
// +----------------------------------------------------------------------
// | Qrcode 二维码生成
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1443433542
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\CacheTrait;
use shuipf\wechat\wechat\Qrcode\Ticket;

class Qrcode
{
    /*
     * Cache Trait
     */
    use CacheTrait,AccessTokenTrait;

    /**
     * 二维码地址
     */
    const QRCODE_URL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';

    /**
     * 构造方法
     * Qrcode constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 获取临时二维码
     * @param string|int $scene 场景
     * @param int $expire 有效期
     * @return string
     * @throws \Exception
     */
    public function getTemporary($scene, $expire = 2592000)
    {
        $ticket = new Ticket($this->accessToken, Ticket::QR_SCENE, $scene, $expire);
        if ($this->cache) {
            $ticket->setCache($this->cache);
        }
        return $this->getResourceUrl($ticket);
    }

    /**
     * 获取永久二维码
     * @param $scene
     * @return string
     * @throws \Exception
     */
    public function getForever($scene)
    {
        $type = is_int($scene)
            ? Ticket::QR_LIMIT_SCENE
            : Ticket::QR_LIMIT_STR_SCENE;
        $ticket = new Ticket($this->accessToken, $type, $scene);
        if ($this->cache) {
            $ticket->setCache($this->cache);
        }
        return $this->getResourceUrl($ticket);
    }

    /**
     * 获取微信提供的二维码图片地址
     * @param Ticket $ticket
     * @return string
     * @throws \Exception
     */
    public function getResourceUrl(Ticket $ticket)
    {
        $query = ['ticket' => $ticket->getTicketString()];
        return static::QRCODE_URL . '?' . http_build_query($query);
    }
}
