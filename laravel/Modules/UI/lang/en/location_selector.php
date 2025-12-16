<?php

declare(strict_types=1);

return [
    'region' => [
        'label' => 'Region',
        'placeholder' => 'Select a region',
        'help' => 'Choose the region of interest',
    ],
    'province' => [
        'label' => 'Province',
        'placeholder' => 'Select a province',
        'help' => 'First select a region',
    ],
    'cap' => [
        'label' => 'Postal Code',
        'placeholder' => 'Select a postal code',
        'help' => 'First select region and province',
    ],
    'validation' => [
        'region_required_for_province' => 'You must select a region before choosing the province',
        'region_province_required_for_cap' => 'You must select region and province before choosing the postal code',
    ],
];
