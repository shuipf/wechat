<?php
// +----------------------------------------------------------------------
// | ButtonCollection 一级菜单
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

class ButtonCollection implements ButtonInterface, ButtonCollectionInterface
{
    /**
     * 子菜单不能超过 5 个.
     */
    const MAX_COUNT = 5;

    /**
     * 一级菜单名称
     * @var string
     */
    protected $name;

    /**
     * 子菜单集合
     * @var array
     */
    protected $child = [];

    /**
     * 构造方法
     * ButtonCollection constructor.
     * @param string $name 一级菜单名称
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * 添加子菜单
     * @param ButtonInterface $button 子菜单对象
     * @return $this
     */
    public function addChild(ButtonInterface $button)
    {
        if (count($this->child) > (static::MAX_COUNT - 1)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '子菜单不能超过 %d 个', static::MAX_COUNT
                )
            );
        }
        array_push($this->child, $button);
        return $this;
    }

    /**
     * 检测是否有子菜单
     * @return bool
     */
    public function hasChild()
    {
        return !empty($this->child);
    }

    /**
     * 获取子菜单
     * @return array
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * 获取菜单数据
     * @return array
     */
    public function getData()
    {
        $data = [
            'name' => $this->name,
        ];
        if ($this->hasChild()) {
            foreach ($this->child as $k => $v) {
                $data['sub_button'][] = $v->getData();
            }
        }
        return $data;
    }
}
