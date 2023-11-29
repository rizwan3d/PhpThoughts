<?php

namespace GrowBitTech\Framework\Cli\Commands;

use GrowBitTech\Framework\Cli\Command;
use GrowBitTech\Framework\Cli\Interface\CommandInterface;

final class Serve extends Command implements CommandInterface
{
    public function run(): void
    {
        $phpExeFile = $this->settings->get('php');
        $phpExeFile = !isset($phpExeFile) || $phpExeFile == null ? 'php' : $phpExeFile;

        $command = "$phpExeFile -S ";
        if (isset($this->argv['host'])) {
            $command = $command.$this->argv['host'];
        } else {
            $command = $command.'localhost';
        }

        if (isset($this->argv['port'])) {
            $command = $command.':'.$this->argv['port'];
        } else {
            $command = $command.':8080';
        }

        $command = $command.' -t "'.dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'public"';
        echo 'executing: '.$command.PHP_EOL;
        exec($command);
    }
}
