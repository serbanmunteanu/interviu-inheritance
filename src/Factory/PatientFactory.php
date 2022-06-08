<?php

namespace App\Factory;

use App\Models\Patient;

class PatientFactory
{
    public static function create(
        string $firstName,
        string $lastName,
        string $symptom,
        int $painLevel,
        bool $haveInsurance
    ): Patient {
        return new Patient($firstName, $lastName, $symptom, $painLevel, $haveInsurance);
    }
}