<?php
// +----------------------------------------------------------------------
// | Music 音乐消息
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\message\entity;

use shuipf\wechat\message\Entity;

class Music extends Entity
{
    /**
     * 音乐标题
     * @var string
     */
    protected $title;

    /**
     * 音乐描述
     * @var string
     */
    protected $description;

    /**
     * 音乐链接
     * @var string
     */
    protected $musicUrl;

    /**
     * 高质量音乐链接
     * @var string
     */
    protected $HQMusicUrl;

    /**
     * 缩略图的媒体id
     * @var int|string
     */
    protected $thumbMediaId;

    /**
     * 设置音乐标题
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 音乐描述
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 音乐链接
     * @param string $musicUrl
     * @return $this
     */
    public function setMusicUrl($musicUrl)
    {
        $this->musicUrl = $musicUrl;
        return $this;
    }

    /**
     * 高质量音乐链接
     * @param string $HQMusicUrl
     * @return $this
     */
    public function setHQMusicUrl($HQMusicUrl)
    {
        $this->HQMusicUrl = $HQMusicUrl;
        return $this;
    }

    /**
     * 缩略图的媒体id
     * @param string|int $thumbMediaId
     * @return $this
     */
    public function setThumbMediaId($thumbMediaId)
    {
        $this->thumbMediaId = $thumbMediaId;
        return $this;
    }

    /**
     * 消息内容
     * @return array|mixed
     */
    public function getBody()
    {
        $body = [
            'Title' => $this->title,
            'Description' => $this->description,
            'MusicUrl' => $this->musicUrl,
            'HQMusicUrl' => $this->HQMusicUrl,
            'ThumbMediaId' => $this->thumbMediaId,
        ];

        return ['Music' => $body];
    }

    /**
     * 消息类型
     * @return string
     */
    public function getType()
    {
        return 'music';
    }
}
