<?php

namespace App\Framework\Config;

class _Global
{
    private $settings;
    function __construct($settings) {
        $this->settings = $settings;
    }

    public function get($key){
       if(isset($this->settings[$key]))
        return $this->settings[$key];
      return null;
    }
}

