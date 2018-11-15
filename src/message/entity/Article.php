<?php
// +----------------------------------------------------------------------
// | Article 图文消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class Article extends Entity
{
    /**
     * 图文列表
     * @var array
     */
    protected $items = [];

    /**
     * 添加图文
     * @param ArticleItem $item
     */
    public function addItem(ArticleItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        $body = [];
        foreach ($this->items as $item) {
            $body['item'][] = $item->getBody();
        }
        $count = isset($body['item'])
            ? count($body['item'])
            : 0;
        return ['Articles' => $body, 'ArticleCount' => $count];
    }

    /**
     * 消息类型
     * @return string
     */
    public function getType()
    {
        return 'news';
    }
}
