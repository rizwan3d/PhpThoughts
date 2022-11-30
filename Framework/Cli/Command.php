<?php

namespace GrowBitTech\Framework\Cli;

use GrowBitTech\Framework\Config\_Global;
use samejack\PHP\ArgvParser;
use GrowBitTech\Framework\Cli\Interface\CommandInterface;

class Command  implements CommandInterface
{
    protected $settings;
    protected $argv;

    public function __construct(_Global $global, $argv)
    {
        $this->settings = $global;
        $this->parseArgs($argv);
    }

    public function parseArgs()
    {
        $argvParser = new ArgvParser();
        $this->argv = $argvParser->parseConfigs();
    }

    public function validate(): CommandInterface
    {
        return $this;
    }

    public function run(): void
    {
        return;
    }
}
