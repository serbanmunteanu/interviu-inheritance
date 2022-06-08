<?php

namespace App\Models;

class Disease
{
    public function __construct(
        private string $name,
        private string $symptom,
        private int $chanceToCure
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymptom(): string
    {
        return $this->symptom;
    }

    public function getChanceToCure(): int
    {
        return $this->chanceToCure;
    }

}