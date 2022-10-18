<?php

namespace App\Framework\Cli\Interface;

interface CommandInterface
{
    public function validate() : CommandInterface;

    public function run();
}
