<?php

namespace GrowBitTech\Framework\Cli;

use GrowBitTech\Framework\Cli\Interface\CommandInterface;
use GrowBitTech\Framework\Config\Interface\GlobalInterface;
use samejack\PHP\ArgvParser;

class Command implements CommandInterface
{
    protected $settings;
    protected $argv;

    public function __construct(GlobalInterface $global, $argv)
    {
        $this->settings = $global;
        $this->parseArgs();
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
    }
}
