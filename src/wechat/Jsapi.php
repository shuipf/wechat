<?php
// +----------------------------------------------------------------------
// | Jsapi
// | https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\wechat;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Util;
use shuipf\wechat\bridge\CacheTrait;
use shuipf\wechat\bridge\Serializer;
use shuipf\wechat\wechat\Jsapi\Ticket;

class Jsapi
{
    /*
     * Cache Trait
     */
    use CacheTrait, AccessTokenTrait;

    /**
     * 是否开起调试
     * @var bool
     */
    protected $debug = false;

    /**
     * 接口列表
     * @var array
     */
    protected $api = [];

    /**
     * 当前 URL 地址（签名参数）
     * @var
     */
    protected $currentUrl;

    /**
     * 全部接口
     * @var array
     */
    protected $apiValids = [
        //分享接口
        'onMenuShareWeibo', 'updateAppMessageShareData', 'updateTimelineShareData',
        //音频接口
        'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'downloadVoice',
        //图像接口
        'chooseImage', 'previewImage', 'uploadImage', 'downloadImage', 'getLocalImgData',
        //智能接口
        'translateVoice',
        //设备信息
        'getNetworkType',
        //地理位置
        'openLocation', 'getLocation',
        //界面操作
        'hideMenuItems', 'showMenuItems', 'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem', 'closeWindow',
        //微信扫一扫
        'scanQRCode',
        //微信支付
        'chooseWXPay',
        //微信小店
        'openProductSpecificView',
        //微信卡券
        'addCard', 'chooseCard', 'openCard',
    ];

    /**
     * 构造方法
     * Jsapi constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 注入签名地址
     * @param string $url
     * @return $this
     */
    public function setCurrentUrl($url)
    {
        $this->currentUrl = $url;
        return $this;
    }

    /**
     * 注入接口
     * @param array|string $apis 接口
     * @return $this
     */
    public function addApi($apis)
    {
        if (is_array($apis)) {
            foreach ($apis as $api) {
                $this->addApi($api);
            }
            return $this;
        }
        $apiName = (string)$apis;
        //检查接口是否支持
        if (!in_array($apiName, $this->apiValids, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid Api: %s', $apiName));
        }
        array_push($this->api, $apiName);
        return $this;
    }

    /**
     * 启用调试模式
     * @return $this
     */
    public function enableDebug()
    {
        $this->debug = true;
        return $this;
    }

    /**
     * 获取配置文件
     * @param bool $asArray 是否转换为数组，默认否
     * @return array|bool|false|float|int|string
     * @throws \Exception
     */
    public function getConfig($asArray = false)
    {
        $ticket = new Ticket($this->accessToken);
        if ($this->cache) {
            $ticket->setCache($this->cache);
        }
        $options = [
            'jsapi_ticket' => $ticket->getTicketString(),
            'timestamp' => Util::getTimestamp(),
            'url' => $this->currentUrl ?: Util::getCurrentUrl(),
            'noncestr' => Util::getRandomString(),
        ];
        ksort($options);
        $signature = sha1(urldecode(http_build_query($options)));
        $configure = [
            //公众号的唯一标识
            'appId' => $this->accessToken['appid'],
            //生成签名的随机串
            'nonceStr' => $options['noncestr'],
            //生成签名的时间戳
            'timestamp' => $options['timestamp'],
            //签名
            'signature' => $signature,
            //需要使用的JS接口列表
            'jsApiList' => $this->api,
            //开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印
            'debug' => (bool)$this->debug,
        ];
        return $asArray ? $configure : Serializer::jsonEncode($configure);
    }

    /**
     * 输出对象
     * @return array|bool|false|float|int|string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->getConfig();
    }
}
