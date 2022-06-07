<?php

namespace App\Models\Doctor;

use App\Models\Disease;
use App\Models\Patient;

interface ConsultInterface
{
    /**
     * @param Disease[] $diseases
     */
    public function consult(Patient $patient, array $diseases): void;
}