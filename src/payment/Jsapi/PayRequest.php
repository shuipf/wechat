<?php

namespace shuipf\wechat\payment\Jsapi;

class PayRequest extends ConfigGenerator
{
    /**
     * 分解配置.
     */
    public function resolveConfig()
    {
        return $this->toArray();
    }
}
