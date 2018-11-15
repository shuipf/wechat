<?php

namespace shuipf\wechat\message;

abstract class Entity
{
    /**
     * 消息类型.
     */
    abstract public function getType();

    /**
     * 消息内容.
     */
    abstract public function getBody();
}
