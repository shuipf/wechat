<?php

namespace shuipf\wechat\payment\jsapi;

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
