<?php
// +----------------------------------------------------------------------
// | ButtonInterface 菜单接口
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\menu;

interface ButtonInterface
{
    /**
     * 获取按钮数据
     * @return array
     */
    public function getData();
}
