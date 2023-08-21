<?php

namespace GrowBitTech\Framework\Config;
use GrowBitTech\Framework\Config\Interface\GlobalInterface;

class _Global implements GlobalInterface
{
    private $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    public function get($key)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }

        return null;
    }

    public function set($key, $val)
    {
        return $this->settings[$key] = $val;
    }
}
