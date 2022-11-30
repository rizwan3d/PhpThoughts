<?php

namespace GrowBitTech\Framework;

use GrowBitTech\Framework\Config\_Global;

class RedisPubSubAdapter
{
    private $client;
    private $adapter;
    private $channel = 'socket';
    public $isRadis = false;

    public function __construct(_Global $global)
    {
        $settings = $global->get('socket');
        if($settings["isRadis"]){
            $this->isRadis = true;
            if(isset($settings["radisChannel"]))
                $this->channel = $settings["radisChannel"];
            $client = new Predis\Client($settings["redis"]);        
            $this->adapter = new \Superbalist\PubSub\Redis\RedisPubSubAdapter($client);
        }
    }

    public function publish($msg){
        $this->adapter->publish($this->channel, $msg);
    }

    public function subscribe($messagefun){
        $this->subscribe($this->channel, $messagefun);
    }
}
