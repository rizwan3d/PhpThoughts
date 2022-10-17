<?php

namespace App\Framework\Cli\Interface;

interface CommandInterface
{
    public function parseArgs($args);
    public function validateArgs($args);
    public function run($args);
}