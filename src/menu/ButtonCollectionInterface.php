<?php
// +----------------------------------------------------------------------
// | ButtonCollectionInterface 一级菜单接口
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

interface ButtonCollectionInterface
{
    /**
     * 添加子菜单
     * @param ButtonInterface $button
     * @return $this
     */
    public function addChild(ButtonInterface $button);

    /**
     * 检测是否有子菜单
     * @return bool
     */
    public function hasChild();

    /**
     * 获取子按钮
     * @return array
     */
    public function getChild();
}
