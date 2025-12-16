<?php

declare(strict_types=1);

return [
    'alert' => [
        'title' => 'Alert',
        'types' => [
            'info' => 'Information',
            'success' => 'Success',
            'warning' => 'Warning',
            'error' => 'Error',
        ],
        'actions' => [
            'dismiss' => 'Dismiss',
        ],
    ],
    'button' => [
        'types' => [
            'primary' => 'Primary',
            'secondary' => 'Secondary',
            'danger' => 'Danger',
            'warning' => 'Warning',
            'info' => 'Info',
            'success' => 'Success',
        ],
        'sizes' => [
            'xs' => 'Extra Small',
            'sm' => 'Small',
            'md' => 'Medium',
            'lg' => 'Large',
            'xl' => 'Extra Large',
        ],
    ],
    'card' => [
        'actions' => [
            'expand' => 'Expand',
            'collapse' => 'Collapse',
            'close' => 'Close',
        ],
    ],
    'modal' => [
        'actions' => [
            'close' => 'Close',
            'confirm' => 'Confirm',
            'cancel' => 'Cancel',
        ],
    ],
    'form' => [
        'fields' => [
            'required' => 'Required field',
            'optional' => 'Optional',
        ],
        'validation' => [
            'required' => 'This field is required',
            'email' => 'Please enter a valid email address',
            'min' => 'Please enter at least :min characters',
            'max' => 'Please enter no more than :max characters',
        ],
        'actions' => [
            'submit' => 'Submit',
            'reset' => 'Reset',
            'cancel' => 'Cancel',
        ],
    ],
    'table' => [
        'actions' => [
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view' => 'View',
        ],
        'empty' => 'No data available',
        'pagination' => [
            'previous' => 'Previous',
            'next' => 'Next',
            'showing' => 'Showing',
            'to' => 'to',
            'of' => 'of',
            'results' => 'results',
        ],
    ],
    'tabs' => [
        'actions' => [
            'previous' => 'Previous',
            'next' => 'Next',
        ],
    ],
    'loading' => [
        'text' => 'Loading...',
    ],
    'error' => [
        'title' => 'Error',
        'description' => 'An error has occurred',
        'actions' => [
            'retry' => 'Retry',
            'back' => 'Back',
        ],
    ],
];
