<?php

namespace App\Output\Adapters;

use App\Output\OutputInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogOutput implements OutputInterface
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('hospital-histoy');
        $this->logger->pushHandler(new StreamHandler('./src/Output/Logs/history.log', Logger::DEBUG));
    }

    public function write(string $message): void
    {
        $this->logger->info($message);
    }
}