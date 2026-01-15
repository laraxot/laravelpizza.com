<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter name',
            'help' => 'Identifying name of the element',
            'description' => 'Object name',
            'helper_text' => '',
        ],
        'edit-name' => [
            'label' => 'Edit name',
            'placeholder' => 'New name',
            'help' => 'Modify the existing name',
            'description' => 'Action to modify the name',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Change state',
            'placeholder' => 'Select new state',
            'help' => 'Modify the current state',
            'description' => 'Action to change the state',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'State',
            'placeholder' => 'Select a state',
            'help' => 'Current state of the element',
            'description' => 'Current system condition',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Enter a message',
            'help' => 'Informative message',
            'description' => 'Message text',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Invalid state instance',
        'record_not_found' => 'Record not found',
        'transition_completed' => [
            'title' => 'Transition completed',
            'body' => 'State transition has been completed successfully',
        ],
        'transition_error' => [
            'title' => 'Transition error',
        ],
    ],
];
