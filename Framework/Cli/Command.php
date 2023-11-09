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

    /**
     * Color output text for the CLI
     *
     * @param string $text to color
     * @param string $color of text
     * @param string $background color
     */
    function colorize($text, $color, $bold = FALSE)
    {
        // Standard CLI colors
        $colors = array_flip(array(30 => 'gray', 'red', 'green', 'yellow', 'blue', 'purple', 'cyan', 'white', 'black'));

        // Escape string with color information
        return "\033[" . ($bold ? '1' : '0') . ';' . $colors[$color] . "m$text\033[0m";
    }
}
