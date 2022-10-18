<?php

namespace App\Framework\Cli;

use App\Framework\Config\_Global;
use samejack\PHP\ArgvParser;

class Command
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
}
