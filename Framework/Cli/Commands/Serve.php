<?php

namespace App\Framework\Cli\Commands;

use App\Framework\Cli\Interface\CommandInterface;
use App\Framework\Cli\Command;

final class Serve extends Command implements CommandInterface
{
    public function validate(): CommandInterface
    {
        return $this;
    }

    public function run()
    {
        $command = 'php -S ';
        if (isset($this->argv['host']))
            $command = $command.$this->argv['host'];
        else
            $command = $command.'localhost';

        if (isset($this->argv['port']))
            $command = $command.':'.$this->argv['port'];
        else
            $command = $command.':8080';

        $command = $command.' -t '.dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'public';
        echo 'executing: '.$command.'\n';
        exec($command);
    }
}
