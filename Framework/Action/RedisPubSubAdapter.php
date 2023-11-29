<?php

namespace GrowBitTech\Framework;

use GrowBitTech\Framework\Config\Interface\GlobalInterface;

class RedisPubSubAdapter
{
    private $client;
    private $adapter;
    private $channel = 'Socket';
    public $isRadis = false;

    public function __construct(GlobalInterface $global)
    {
        $settings = $global->get('Socket');
        if ($settings['IsRadis']) {
            $this->isRadis = true;
            if (isset($settings['RadisChannel'])) {
                $this->channel = $settings['RadisChannel'];
            }
            $client = new \Predis\Client($settings['Redis']);
            $this->adapter = new \Superbalist\PubSub\Redis\RedisPubSubAdapter($client);
        }
    }

    public function publish($msg)
    {
        $this->adapter->publish($this->channel, $msg);
    }

    public function subscribe($messagefun)
    {
        $this->subscribe($this->channel, $messagefun);
    }
}
