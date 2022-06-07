<?php

namespace App\Models\Doctor;

use App\Models\Disease;
use App\Models\Patient;

class Doctor implements ConsultInterface
{
    private string $name;
    private int $patientsTreated = 0;
    private string $experienceLevel;
    /** @var Disease[]  */
    private array $knowHowToTreat;

    public function consult(Patient $patient, array $diseases): void
    {
        $symptoms = $patient->getSymptoms();
        $disease = Disease::createFromSymptoms($symptoms);

        if (!is_null($disease)) {
            $patient->setDiagnosis($disease);
        }
    }

    public function increasePatientTreat(): void
    {
        $this->patientsTreated++;

        if ($this->isMaster()) {
            $this->setExperienceLevel('Master');
        }
    }

    public function canTreat(Disease $disease): bool
    {
        return in_array($disease, $this->knowHowToTreat, true);
    }

    public function getPatientsTreated(): int
    {
        return $this->patientsTreated;
    }

    public function isMaster(): bool
    {
        return $this->experienceLevel !== 'Master' && $this->patientsTreated > 20;
    }

    public function setExperienceLevel(string $experienceLevel): Doctor
    {
        $this->experienceLevel = $experienceLevel;
        return $this;
    }

    public function getName(): string
    {
        return 'Doctor ' . $this->name;
    }

    public function setName(string $name): Doctor
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Disease[] $knowHowToTreat
     */
    public function setKnowHowToTreat(array $knowHowToTreat): Doctor
    {
        $this->knowHowToTreat = $knowHowToTreat;
        return $this;
    }
}