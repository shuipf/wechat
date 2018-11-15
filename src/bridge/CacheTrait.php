<?php
// +----------------------------------------------------------------------
// | CacheTrait 基于 doctrine/cache
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.shuipf.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace shuipf\wechat\bridge;

use Doctrine\Common\Cache\Cache;

trait CacheTrait
{
    /**
     * 缓存对象
     * @var Cache
     */
    protected $cache;

    /**
     * 设置缓存驱动
     * @param Cache $cache
     * @return $this
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * 获取缓存驱动
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * 从缓存中清除
     * @return bool
     */
    public function clearFromCache()
    {
        if ($this->cache) {
            return $this->cache->delete($this->getCacheId());
        }
        return false;
    }
}
