<?php

namespace App\Socket;

use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use GrowBitTech\Framework\Socket;
use Ratchet\ConnectionInterface;

class SocketEvent extends Socket
{
    protected $clients;

    public function init()
    {
        parent::init();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }


    public function messageFromRadis($msg){

    }

    #[Route('/chat')]
    public function messageFromSocket($msg, ConnectionInterface $from)
    {
        //if client exist send message otherise publish it
        // $this->publish($msg);
        
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        parent::onClose($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        parent::onError($conn,$e);
    }
}
