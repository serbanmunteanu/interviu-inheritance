<?php

namespace App\Models;

use App\Models\Doctor\Doctor;

class Patient
{
    private ?Disease $diagnosis;
    private ?Doctor $assignedDoctor;

    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $symptom,
        private int $painLevel,
        private bool $haveInsurance,
    ){
    }

    public function getSymptom(): string
    {
        return $this->symptom;
    }

    public function haveInsurance(): bool
    {
        return $this->haveInsurance;
    }

    public function getDiagnosis(): ?Disease
    {
        return $this->diagnosis ?? null;
    }

    public function setDiagnosis(?Disease $diagnosis): Patient
    {
        $this->diagnosis = $diagnosis;
        return $this;
    }

    public function getAssignedDoctor(): ?Doctor
    {
        return $this->assignedDoctor ?? null;
    }

    public function setAssignedDoctor(Doctor $assignedDoctor): Patient
    {
        $this->assignedDoctor = $assignedDoctor;
        return $this;
    }

    public function getLuckFactor(): int
    {
        return rand(1, 100);
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function canDie(): bool
    {
        return $this->painLevel > 7 && $this->getLuckFactor() < 50;
    }
}