<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Contacts',
        'group' => 'Content Management',
        'icon' => 'heroicon-o-phone',
        'color' => 'primary',
        'sort' => '10',
    ],
    'model' => [
        'label' => 'Contact',
        'plural' => 'Contacts',
        'description' => 'Manage the studio contact information',
    ],
    'fields' => [
        'title' => [
            'label' => 'Contact Title',
            'placeholder' => 'Enter the title (e.g. Dental Practice)',
            'help' => 'Main name or title to identify the contact',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Briefly describe the studio\'s business',
            'help' => 'Short description of the activities and services offered',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Contact Email',
            'placeholder' => 'name@example.com',
            'help' => 'Main email address for communications',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Phone Number',
            'placeholder' => '+39 06 1234567',
            'help' => 'Studio main phone number',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Full Address',
            'placeholder' => '123 Main Street - 10001 New York',
            'help' => 'Full physical address of the studio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'map_url' => [
            'label' => 'Link Mappa',
            'placeholder' => 'https://maps.google.com/...',
            'help' => 'URL to open the location on Google Maps or similar services',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New Contact',
            'modal_heading' => 'Add new contact',
            'modal_description' => 'Enter the contact information',
            'success' => 'Contact created successfully',
            'error' => 'Error while creating the contact',
        ],
        'edit' => [
            'label' => 'Edit',
            'modal_heading' => 'Edit contact',
            'modal_description' => 'Update the contact information',
            'success' => 'Contact updated successfully',
            'error' => 'Error while updating',
        ],
        'delete' => [
            'label' => 'Delete',
            'modal_heading' => 'Delete contact',
            'modal_description' => 'Are you sure you want to delete this contact?',
            'success' => 'Contact deleted successfully',
            'error' => 'Error while deleting',
            'confirmation' => 'This action cannot be undone',
        ],
    ],
    'messages' => [
        'empty_state' => 'No contacts configured',
        'loading' => 'Loading contacts...',
        'saved' => 'Changes saved successfully',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
