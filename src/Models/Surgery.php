<?php

namespace App\Models;

use App\Output\OutputInterface;

class Surgery
{
    public function __construct(
        private Patient $patient,
        private int $operationRoom,
        private OutputInterface $output
    ) {
    }

    public function execute(): void
    {

    }

    public function isASuccess(): bool
    {
        return true;
    }
}