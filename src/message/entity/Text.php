<?php
// +----------------------------------------------------------------------
// | Text 文字消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class Text extends Entity
{
    /**
     * 回复的消息内容
     * @var string
     */
    protected $content;

    /**
     * 回复的消息内容
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        return ['Content' => $this->content];
    }

    /**
     * 消息类型
     * @return string
     */
    public function getType()
    {
        return 'text';
    }
}
