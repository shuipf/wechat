<?php
// +----------------------------------------------------------------------
// | Button 子菜单
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

class Button implements ButtonInterface
{
    /**
     * 菜单名称
     * @var string
     */
    protected $name;

    /**
     * 菜单类型
     * @var
     */
    protected $type;

    /**
     * 菜单值（key/url/media_id => value）
     * @var array
     */
    protected $value = [];

    /**
     * 菜单类型映射关系
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013
     * @var array
     */
    protected $mapping = [
        //跳转URL
        'view' => 'url',
        //点击
        'click' => 'key',
        //扫码推事件用户点击按钮后，微信客户端将调起扫一扫工具
        'scancode_push' => 'key',
        'scancode_waitmsg' => 'key',
        'pic_sysphoto' => 'key',
        'pic_photo_or_album' => 'key',
        'pic_weixin' => 'key',
        'location_select' => 'key',
        'media_id' => 'media_id',
        'view_limited' => 'media_id',
    ];

    /**
     * 构造方法
     * Button constructor.
     * @param string $name 菜单名称
     * @param string $type 菜单类型
     * @param string $value 菜单值
     */
    public function __construct($name, $type, $value)
    {
        if (!array_key_exists($type, $this->mapping)) {
            throw new \InvalidArgumentException(sprintf('Invalid Type: %s', $type));
        }
        $this->name = $name;
        $this->type = $type;
        $this->value = [$this->mapping[$type] => $value];
    }

    /**
     * 菜单数据
     * @return array
     */
    public function getData()
    {
        $data = [
            'name' => $this->name,
            'type' => $this->type,
        ];
        return array_merge($data, $this->value);
    }
}
