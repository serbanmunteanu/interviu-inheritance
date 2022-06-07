<?php

namespace App\Models\Doctor;

use App\Models\Disease;
use App\Models\Patient;

class Doctor implements ConsultInterface
{
    public const TYPE_NOVICE = 'novice';
    public const TYPE_MASTER = 'master';

    private string $name;
    private int $patientsTreated = 0;
    private string $experienceLevel = self::TYPE_NOVICE;
    /** @var Disease[]  */
    private array $knowHowToTreat;

    /**
     * @param Disease[] $diseases
     */
    public function consult(Patient $patient, array $diseases): void
    {
        foreach ($diseases as $disease) {
            if ($disease->getSymptom() === $patient->getSymptom()) {
                $patient->setDiagnosis($disease);
            }
        }
    }

    public function increasePatientTreat(): void
    {
        $numberOfPatientsTreated = $this->patientsTreated + 1;

        $this->setPatientsTreated($numberOfPatientsTreated);
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
        return $this->experienceLevel === self::TYPE_MASTER;
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

    public function setPatientsTreated(int $patientsTreated): Doctor
    {
        $this->patientsTreated = $patientsTreated;
        if ($patientsTreated > 20) {
            $this->experienceLevel = self::TYPE_MASTER;
        }
        return $this;
    }

    /**
     * @param Disease[] $diseases
     * @param array $knowledge
     * @return Disease[]
     */
    public function getKnowledgeOfDiseases(array $diseases, array $knowledge): array
    {
        $knownDiseases = [];
        foreach ($diseases as $disease) {
            foreach ($knowledge as $diseaseName) {
                if ($disease->getName() === $diseaseName) {
                    $knownDiseases[] = $disease;
                }
            }
        }

        return $knownDiseases;
    }
}