<?php

namespace App;

use App\Models\Disease;
use App\Models\Doctor\Doctor;
use App\Models\Patient;
use App\Models\Surgery;
use App\Output\Adapters\CliOutput;
use App\Output\Adapters\LogOutput;
use App\Output\OutputInterface;

class Hospital
{
    /** @var mixed  */
    private array $config;

    /** @var Doctor[]  */
    private array $doctors;

    /** @var int[] */
    private array $operationRooms;

    /** @var Patient[]  */
    private array $waitingList = [];

    /** @var Disease[] */
    private array $diseases;

    private OutputInterface $output;

    private Doctor $triageDoctor;

    public function __construct()
    {
        $this->config = include('config.php');
    }

    /**
     * @throws \Exception
     */
    public function bootstrap(): Hospital
    {
        $this
            ->loadDoctors()
            ->loadTriageDoctor()
            ->loadDiseasesThatCanBeTreatedInThisHospital()
            ->loadOperationRooms()
            ->loadOutput();
    }

    public function process(): void
    {
        if (empty($this->waitingList)) {
            $this->output->write('Triage queue is empty.');
            return;
        }

        $patientTreatCounter = 0;

        foreach ($this->waitingList as $patient) {
            if (!$patient->haveInsurance()) {
                $this->output->write(sprintf(
                    'Patient %s doesn\'t have insurance and will not be processed.',
                    $patient->getFullName()
                ));
                continue;
            }

            $this->triageDoctor->consult($patient, $this->diseases);

            if (is_null($patient->getDiagnosis()) || is_null($patient->getAssignedDoctor())) {
                $this->output->write(sprintf(
                    'Patient %s cannot be diagnosed or the disease cannot be treated here.',
                    $patient->getFullName()
                ));
                continue;
            }

            if (empty($this->operationRooms) && $patient->canDie()) {
                $this->output->write(sprintf(
                    'Patient %s is dead to to high level of pain.',
                    $patient->getFullName()
                ));
                continue;
            }

            $this->assignDoctorForPatient($patient);
            $operationRoomNumber = array_pop($this->operationRooms);

            $surgery = new Surgery($patient, $operationRoomNumber, $this->output);
            $surgery->execute();

            if ($surgery->isASuccess()) {
                $patientTreatCounter++;
                $this->output->write(sprintf(
                    'Stunning result !!! Doctor %s treat patient %s from disease %s and have %d success surgery.',
                    $patient->getAssignedDoctor()->getName(),
                    $patient->getFullName(),
                    $patient->getDiagnosis()->getName(),
                    $patient->getAssignedDoctor()->getPatientsTreated()
                ));
            } else {
                $this->output->write(sprintf(
                    'Patient %s died in the surgery.',
                    $patient->getFullName()
                ));
            }
        }
    }

    protected function loadDoctors(): Hospital
    {
        return $this;
    }

    protected function loadOperationRooms(): Hospital
    {
        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function loadOutput(): Hospital
    {
        if (!isset($this->config['output']) || empty($this->config['output'])) {
            throw new \Exception('Invalid configuration output');
        }

        switch ($this->config['output']) {
            case 'cli':
                $this->setOutput(new CliOutput());
                break;
            case 'log':
                $this->setOutput(new LogOutput());
                break;
            default:
                throw new \Exception('Adapter not supported');
        }

        return $this;
    }

    public function loadDiseasesThatCanBeTreatedInThisHospital(): Hospital
    {
        $diseases = $this->config['diseases'];

        $this->diseases = [];

        return $this;
    }

    public function loadTriageDoctor(): Hospital
    {
        $this->triageDoctor = new Doctor();
        return $this;
    }

    /**
     * @param int[] $operationRooms
     */
    public function setOperationRooms(array $operationRooms): Hospital
    {
        $this->operationRooms = $operationRooms;
        return $this;
    }

    /**
     * @param Patient[] $waitingList
     */
    public function setWaitingList(array $waitingList): Hospital
    {
        $this->waitingList = $waitingList;
        return $this;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): Hospital
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return Doctor[]
     */
    public function getDoctors(): array
    {
        return $this->doctors;
    }

    /**
     * @param Doctor[] $doctors
     */
    public function setDoctors(array $doctors): Hospital
    {
        $this->doctors = $doctors;
        return $this;
    }

    public function assignDoctorForPatient(Patient $patient): void
    {
        foreach ($this->doctors as $doctor) {
            if ($doctor->canTreat($patient->getDiagnosis())) {
                $patient->setAssignedDoctor($doctor);
                return;
            }
        }
    }
}