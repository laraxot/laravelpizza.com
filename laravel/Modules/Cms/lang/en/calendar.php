<?php

declare(strict_types=1);

return [
    'calendar' => [
        'title' => 'Calendar',
        'description' => 'Manage your appointments',
        'types' => [
            'patient' => 'Patient Calendar',
            'doctor' => 'Doctor Calendar',
            'admin' => 'Administrator Calendar',
        ],
        'events' => [
            'title' => 'Appointment',
            'start' => 'Start',
            'end' => 'End',
            'patient' => 'Patient',
            'doctor' => 'Doctor',
            'status' => 'Status',
            'type' => 'Type',
        ],
        'actions' => [
            'create' => 'New Appointment',
            'edit' => 'Edit Appointment',
            'delete' => 'Delete Appointment',
            'view' => 'View Details',
        ],
        'messages' => [
            'created' => 'Appointment created successfully',
            'updated' => 'Appointment updated successfully',
            'deleted' => 'Appointment deleted successfully',
        ],
    ],
    'buttons' => [
        'today' => 'Today',
        'month' => 'Month',
        'week' => 'Week',
        'day' => 'Day',
    ],
    'labels' => [
        'all_day' => 'All day',
        'no_events' => 'No events',
    ],
    'errors' => [
        'load_failed' => 'Unable to load events',
        'save_failed' => 'Unable to save the event',
        'delete_failed' => 'Unable to delete the event',
    ],
    'success' => [
        'event_created' => 'Event created successfully',
        'event_updated' => 'Event updated successfully',
        'event_deleted' => 'Event deleted successfully',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
