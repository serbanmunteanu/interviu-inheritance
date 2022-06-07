<?php

namespace App\Factory;

use App\Models\Disease;

class DiseaseFactory
{
    public static function create(array $diseaseData): Disease
    {
        return (new Disease())
            ->setName($diseaseData['name'])
            ->setChanceToCure($diseaseData['chanceToCure'])
            ->setSymptom($diseaseData['symptom']);
    }
}