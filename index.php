<?php

use App\Hospital;

require_once __DIR__  . '/../../vendor/autoload.php';

$patients = [];
$hospital = new Hospital();

try {
    $hospital
        ->bootstrap()
        ->setWaitingList($patients)
        ->process();
} catch (Exception $e) {
    echo 'Error when bootstrap the application. Error ' . $e->getMessage();
}