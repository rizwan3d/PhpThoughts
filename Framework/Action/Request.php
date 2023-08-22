<?php
namespace GrowBitTech\Framework;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Interfaces\HeadersInterface;
use Slim\Psr7\Request as R;

class Request extends R {
    public function forArray(array $array){    
        
        foreach ($array as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function formBody(){
        $this->forArray((array)$this->parsedBody);
    }
}