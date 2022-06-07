<?php

namespace App\Models;

use App\Output\OutputInterface;

class Surgery
{
    private Patient $patient;
    private int $operationRoom;
    private OutputInterface $output;
    private bool $surgerySucceeded;

    public function __construct(Patient $patient, int $operationRoom, OutputInterface $output)
    {
        $this->patient = $patient;
        $this->operationRoom = $operationRoom;
        $this->output = $output;
    }

    public function execute(): void
    {
        $this->output->write(sprintf(
            'Starting surgery for disease %s in Operation room %d for patient %s performed by %s.',
            $this->patient->getDiagnosis()->getName(),
            $this->operationRoom,
            $this->patient->getFullName(),
            $this->patient->getAssignedDoctor()->getName()
        ));

        if ($this->patient->getDiagnosis()->getChanceToCure() < 50
        && !$this->patient->getAssignedDoctor()->isMaster()) {
            $this->setSurgerySucceeded(false);
            return;
        }

        $this->setSurgerySucceeded(true);
        $this->patient->getAssignedDoctor()->increasePatientTreat();
    }

    public function setSurgerySucceeded(bool $surgerySucceeded): Surgery
    {
        $this->surgerySucceeded = $surgerySucceeded;
        return $this;
    }

    public function isASuccess(): bool
    {
        return $this->surgerySucceeded;
    }
}