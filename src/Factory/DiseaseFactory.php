<?php

namespace App\Factory;

use App\Models\Disease;

class DiseaseFactory
{
    public static function create(string $name, string $symptom, int $chanceToCure): Disease
    {
        return new Disease($name, $symptom, $chanceToCure);
    }
}