<?php
namespace GrowBitTech\Framework;

use BadFunctionCallException;
use GrowBitTech\Framework\Config\_Global;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Socket implements MessageComponentInterface
{
    protected $clients;
    protected $redis;
    protected $id;

    public function __construct(RedisPubSubAdapter $redis)
    {
        $this->redis = $redis;   
        $this->id = uniqid('GrowBit_');    
    }
    
    public public function init()
    {
        $this->clients = new \SplObjectStorage();
        if($this->redis->isRadis){
            $this->subscribe();
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->newMessage( $msg,$from)
    }

    public function newMessage($msg,ConnectionInterface $from){

    }

    public function publish($msg){
        $this->redis->publish([$msg => $msg, 'fromRadis' => true, 'id' => $this->id]);
    }

    public function subscribe(){
        $this->redis->subscribe($this->routeMsg);
    }
    public public function routeMsg($msg)
    {
        if($msg[id] != $this->id)
            $this->newMessage($msg,null);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        
    }
}