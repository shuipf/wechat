<?php
// +----------------------------------------------------------------------
// | Event 事件抽象类
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\event;

use shuipf\wechat\message\entity;
use shuipf\wechat\bridge\XmlResponse;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Event extends ArrayCollection
{
    /**
     * 设置回复消息实体对象
     * @param entity $entity
     */
    public function setResponse(Entity $entity)
    {
        $body = $entity->getBody();
        $body['ToUserName'] = $this->get('FromUserName');
        $body['FromUserName'] = $this->get('ToUserName');
        $body['MsgType'] = $entity->getType();
        $body['CreateTime'] = time();
        //构造xml资源
        $response = new XmlResponse($body);
        //输出
        $response->send();
    }

    /**
     * 判断消息类型是否正确
     * @return bool
     */
    abstract public function isValid();
}
