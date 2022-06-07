<?php

namespace App\Output\Adapters;

use App\Output\OutputInterface;

class CliOutput implements OutputInterface
{
    public function write(string $message): void
    {
        print_r($message . PHP_EOL);
    }
}