<?php
// +----------------------------------------------------------------------
// | ArticleItem 图文消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class ArticleItem extends Entity
{
    /**
     * 图文消息标题
     * @var string
     */
    protected $title;

    /**
     * 图文消息描述
     * @var string
     */
    protected $description;

    /**
     * 图片链接
     * @var string
     */
    protected $picUrl;

    /**
     * 点击图文消息跳转链接
     * @var string
     */
    protected $url;

    /**
     * 设置图文消息标题
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 设置图文消息描述
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 设置图片链接
     * @param string $picUrl
     * @return $this
     */
    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
        return $this;
    }

    /**
     * 设置点击图文消息跳转链接
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        return [
            'Title' => $this->title,
            'Description' => $this->description,
            'PicUrl' => $this->picUrl,
            'Url' => $this->url,
        ];
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
