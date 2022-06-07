<?php

namespace App\Models;

use App\Models\Doctor\Doctor;

class Patient
{
    private string $firstName;
    private string $lastName;
    private string $symptom;
    private int $painLevel;
    private bool $haveInsurance;
    private Disease $diagnosis;
    private Doctor $assignedDoctor;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Patient
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Patient
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getSymptom(): string
    {
        return $this->symptom;
    }

    public function setSymptoms(string $symptom): Patient
    {
        $this->symptom = $symptom;
        return $this;
    }

    public function getPainLevel(): int
    {
        return $this->painLevel;
    }

    public function setPainLevel(int $painLevel): Patient
    {
        $this->painLevel = $painLevel;
        return $this;
    }

    public function haveInsurance(): bool
    {
        return $this->haveInsurance;
    }

    public function setHaveInsurance(bool $haveInsurance): Patient
    {
        $this->haveInsurance = $haveInsurance;
        return $this;
    }

    public function getDiagnosis(): Disease
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(Disease $diagnosis): Patient
    {
        $this->diagnosis = $diagnosis;
        return $this;
    }

    public function getAssignedDoctor(): Doctor
    {
        return $this->assignedDoctor;
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
        return $this->firstName . $this->lastName;
    }

    public function canDie(): bool
    {
        return $this->painLevel > 7 && $this->getLuckFactor() < 50;
    }
}