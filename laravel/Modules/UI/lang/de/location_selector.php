<?php

declare(strict_types=1);

return [
    'region' => [
        'label' => 'Region',
        'placeholder' => 'Region auswählen',
        'help' => 'Wählen Sie die Region von Interesse',
    ],
    'province' => [
        'label' => 'Provinz',
        'placeholder' => 'Provinz auswählen',
        'help' => 'Zuerst eine Region auswählen',
    ],
    'cap' => [
        'label' => 'PLZ',
        'placeholder' => 'PLZ auswählen',
        'help' => 'Zuerst Region und Provinz auswählen',
    ],
    'validation' => [
        'region_required_for_province' => 'Sie müssen eine Region auswählen, bevor Sie die Provinz wählen',
        'region_province_required_for_cap' => 'Sie müssen Region und Provinz auswählen, bevor Sie die PLZ wählen',
    ],
];
