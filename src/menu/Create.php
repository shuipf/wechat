<?php
// +----------------------------------------------------------------------
// | Create 创建菜单
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

use shuipf\wechat\bridge\AccessTokenTrait;
use shuipf\wechat\bridge\Http;
use shuipf\wechat\wechat\AccessToken;

class Create
{
    use AccessTokenTrait;

    /**
     * 接口地址
     */
    const CREATE_URL = 'https://api.weixin.qq.com/cgi-bin/menu/create';

    /**
     * 一级菜单不能超过 3 个.
     */
    const MAX_COUNT = 3;

    /**
     * 按钮集合.
     */
    protected $buttons = [];

    /**
     * 构造方法
     * Create constructor.
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * 添加按钮 一级
     * @param ButtonInterface $button
     * @return $this
     */
    public function add(ButtonInterface $button)
    {
        if ($button instanceof ButtonCollectionInterface) {
            if (!$button->getChild()) {
                throw new \InvalidArgumentException('一级菜单不能为空');
            }
        }
        if (count($this->buttons) > (static::MAX_COUNT - 1)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '一级菜单不能超过 %d 个', static::MAX_COUNT
                )
            );
        }
        $this->buttons[] = $button;
        return $this;
    }

    /**
     * 发布菜单
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doCreate()
    {
        $response = Http::request('POST', static::CREATE_URL)
            ->withAccessToken($this->accessToken)
            ->withBody($this->getRequestBody())
            ->send();
        if (0 != $response['errcode']) {
            throw new \Exception($response['errmsg'], $response['errcode']);
        }
        return true;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getRequestBody()
    {
        $data = [];
        foreach ($this->buttons as $k => $v) {
            $data['button'][$k] = $v->getData();
        }
        return $data;
    }
}
