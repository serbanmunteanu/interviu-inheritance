<?php

namespace App;

use App\Factory\DiseaseFactory;
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
        return $this
            ->loadOutput()
            ->loadDiseasesThatCanBeTreatedInThisHospital()
            ->loadDoctors()
            ->loadTriageDoctor()
            ->loadOperationRooms();
    }

    public function process(): void
    {
        if (empty($this->waitingList)) {
            $this->output->write('Triage queue is empty.');
            return;
        }

        $patientTreatCounter = 0;
        $patientDeadCounter = 0;
        $patientNotTreated = 0;

        foreach ($this->waitingList as $patient) {
            if (!$patient->haveInsurance()) {
                $this->output->write(sprintf(
                    'Patient %s doesn\'t have insurance and will not be processed.',
                    $patient->getFullName()
                ));
                $patientNotTreated++;
                continue;
            }

            $this->triageDoctor->consult($patient, $this->diseases);

            if (is_null($patient->getDiagnosis())) {
                $this->output->write(sprintf(
                    'Patient %s cannot be diagnosed or the disease cannot be treated here.',
                    $patient->getFullName()
                ));
                $patientNotTreated++;
                continue;
            }

            if (empty($this->operationRooms) || $patient->canDie()) {
                $this->output->write(sprintf(
                    'Patient %s is dead to to high level of pain.',
                    $patient->getFullName()
                ));
                $patientDeadCounter++;
                continue;
            }

            $this->assignDoctorForPatient($patient);
            $operationRoomNumber = array_pop($this->operationRooms);

            $surgery = new Surgery($patient, $operationRoomNumber, $this->output);
            $surgery->execute();

            if ($surgery->isASuccess()) {
                $patientTreatCounter++;
                $this->output->write(sprintf(
                    'Stunning result !!! Doctor %s treat patient %s from disease %s and have %d success surgeries.',
                    $patient->getAssignedDoctor()->getName(),
                    $patient->getFullName(),
                    $patient->getDiagnosis()->getName(),
                    $patient->getAssignedDoctor()->getPatientsTreated()
                ));
            } else {
                $patientDeadCounter++;
                $this->output->write(sprintf(
                    'Patient %s died in the surgery.',
                    $patient->getFullName()
                ));
            }
        }

        $this->output->write("Final results for queue --- \n Treated: $patientTreatCounter \n Dead: $patientDeadCounter \n Not treated: $patientNotTreated");
    }

    protected function loadDoctors(): Hospital
    {
        $doctors = [];
        foreach ($this->config['doctors'] as $doctorData) {
            $doctors[] = (new Doctor())
                ->setName($doctorData['name'])
                ->setPatientsTreated($doctorData['patientsTreated'])
                ->setKnowHowToTreat(Doctor::getKnowledgeOfDiseases($this->diseases, $doctorData['knowledge']));
        }

        $this->doctors = $doctors;
        return $this;
    }

    protected function loadOperationRooms(): Hospital
    {
        $this->operationRooms = $this->config['operationRooms'];
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

        $this->output = match ($this->config['output']) {
            'cli' => new CliOutput(),
            'log' => new LogOutput(),
            default => throw new \Exception('Adapter not supported'),
        };

        return $this;
    }

    protected function loadDiseasesThatCanBeTreatedInThisHospital(): Hospital
    {
        $diseases = [];
        foreach ($this->config['diseases'] as $diseaseData) {
            $diseases[] = DiseaseFactory::create(
                $diseaseData['name'],
                $diseaseData['symptom'],
                $diseaseData['chanceToCure']
            );
        }

        $this->diseases = $diseases;
        return $this;
    }

    protected function loadTriageDoctor(): Hospital
    {
        $this->triageDoctor = $this->doctors[array_rand($this->doctors)];
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

    protected function assignDoctorForPatient(Patient $patient): void
    {
        foreach ($this->doctors as $doctor) {
            if ($doctor->canTreat($patient->getDiagnosis())) {
                $patient->setAssignedDoctor($doctor);
                return;
            }
        }
    }
}