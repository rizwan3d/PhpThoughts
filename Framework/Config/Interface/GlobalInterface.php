<?php

namespace GrowBitTech\Framework\Config\Interface;

interface GlobalInterface
{
    public function get($key);

    public function set($key, $val);
}
