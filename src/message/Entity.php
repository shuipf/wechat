<?php
// +----------------------------------------------------------------------
// | Entity
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message;

abstract class Entity
{
    /**
     * 消息类型
     * @return string
     */
    abstract public function getType();

    /**
     * 消息内容
     * @return array
     */
    abstract public function getBody();
}
