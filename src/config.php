<?php

return [
    'output' => 'log',
    'diseases' => [
        [
            'name' => 'Brain cancer',
            'symptom' => 'headache',
            'chanceToCure' => 30
        ],
        [
            'name' => 'Diabetes',
            'symptom' => 'blurred vision',
            'chanceToCure' => 55
        ],
        [
            'name' => 'Chlamydia',
            'symptom' => 'burning sensation',
            'chanceToCure' => 70
        ],
        [
            'name' => 'Depression',
            'symptom' => 'anxious',
            'chanceToCure' => 50
        ],
        [
            'name' => 'Conjunctivitis',
            'symptom' => 'red eyes',
            'chanceToCure' => 90
        ],
        [
            'name' => 'Alzheimer',
            'symptom' => 'memory loss',
            'chanceToCure' => 20
        ],
        [
            'name' => 'Hepatitis',
            'symptom' => 'liver pain',
            'chanceToCure' => 45
        ]
    ],
    'doctors' => [
        [
            'name' => 'Oneida Hulda',
            'patientsTreated' => 19,
            'knowledge' => ['Hepatitis', 'Conjunctivitis']
        ],
        [
            'name' => 'Otto Su',
            'patientsTreated' => 2,
            'knowledge' => ['Alzheimer']
        ],
        [
            'name' => 'Lender Radomira',
            'patientsTreated' => 10,
            'knowledge' => ['Depression']
        ],
        [
            'name' => 'Ciriaco Pyri',
            'patientsTreated' => 0,
            'knowledge' => ['Diabetes', 'Chlamydia']
        ],
        [
            'name' => 'Astride Yevfimiy',
            'patientsTreated' => 30,
            'knowledge' => ['Brain cancer']
        ],
    ],
    'operationRooms' => [
        1, 2, 3, 4, 5
    ],
];
