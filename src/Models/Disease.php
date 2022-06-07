<?php

namespace App\Models;

class Disease
{
    private string $name;
    private string $symptom;
    private int $chanceToCure;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Disease
    {
        $this->name = $name;
        return $this;
    }

    public function getSymptom(): string
    {
        return $this->symptom;
    }

    public function setSymptom(string $symptom): Disease
    {
        $this->symptom = $symptom;
        return $this;
    }

    public function getChanceToCure(): int
    {
        return $this->chanceToCure;
    }

    public function setChanceToCure(int $chanceToCure): Disease
    {
        $this->chanceToCure = $chanceToCure;
        return $this;
    }
}