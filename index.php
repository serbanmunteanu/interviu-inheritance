<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Factory\PatientFactory;
use App\Hospital;

require __DIR__  . '/vendor/autoload.php';

$patients = [
    PatientFactory::create('Andrei', 'Stan', 'headache', 9, true),
    PatientFactory::create('Marian', 'Danila', 'blurred vision', 5, true),
    PatientFactory::create('Mirela', 'Mihai', 'burning sensation', 7, true),
    PatientFactory::create('Nicolae', 'Hutanu', 'anxious', 3, true),
    PatientFactory::create('Andrei', 'Munteanu', 'red eyes', 6, true),
    PatientFactory::create('Marian', 'Perghel', 'memory loss', 2, true),
    PatientFactory::create('Bogdan', 'Fovas', 'liver pain', 9, false),
    PatientFactory::create('Test', 'Test', 'unknown', 9, true),
];

try {
     (new Hospital())
         ->bootstrap()
         ->setWaitingList($patients)
         ->process();
} catch (Exception $e) {
    throw new Exception('Error on bootstrap. Error: ' . $e->getMessage());
}
