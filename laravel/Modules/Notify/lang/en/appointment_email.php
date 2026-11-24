<?php

declare(strict_types=1);

return [
    'common' => [
        'greeting' => [
            'label' => 'Dear :name,',
        ],
        'details' => [
            'title' => 'Appointment details',
        ],
        'status' => [
            'description' => 'We would like to inform you that your appointment has been :status.',
        ],
        'regards' => [
            'label' => 'Kind regards,',
        ],
        'team' => [
            'label' => 'The project team',
        ],
        'auto_generated' => [
            'description' => 'This email was sent automatically. Please do not reply to this message.',
        ],
        'rights_reserved' => [
            'label' => 'All rights reserved',
        ],
        'view_button' => [
            'label' => 'View Appointment',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Date',
        ],
        'time' => [
            'label' => 'Time',
        ],
        'type' => [
            'label' => 'Type',
        ],
        'doctor' => [
            'label' => 'Doctor',
        ],
        'location' => [
            'label' => 'Location',
        ],
        'notes' => [
            'label' => 'Notes',
        ],
        'cancellation_reason' => [
            'label' => 'Cancellation reason',
        ],
        'rescheduling_reason' => [
            'label' => 'Rescheduling reason',
        ],
    ],
    'sections' => [
        'reminder' => [
            'title' => 'Appointment Reminder',
            'description' => 'This is a reminder that your appointment at our facility is scheduled for :when.',
        ],
        'confirmed' => [
            'title' => 'Appointment Confirmation',
            'description' => 'We are pleased to confirm your appointment at our facility.',
        ],
        'cancelled' => [
            'title' => 'Appointment Cancellation',
        ],
        'rescheduled' => [
            'title' => 'Appointment Change',
        ],
        'generic' => [
            'title' => 'Appointment Notification',
        ],
    ],
    'reminder' => [
        'tomorrow' => [
            'label' => 'tomorrow',
        ],
        'countdown' => [
            'description' => 'Only 1 day left until your appointment!',
        ],
        'arrive_early' => [
            'description' => 'Please arrive 15 minutes before the scheduled time and bring with you:',
        ],
        'bring' => [
            'id' => 'A valid ID document',
            'health_card' => 'Health insurance card',
            'reports' => 'Any previous reports or test results',
            'medications' => 'A list of the medications you are taking',
        ],
        'cancel_notice' => [
            'description' => 'If you are unable to attend the appointment, please contact us as soon as possible to reschedule it.',
        ],
        'manage_button' => [
            'label' => 'Manage Appointment',
        ],
    ],
    'confirmed' => [
        'arrive_early' => [
            'description' => 'Please arrive 15 minutes before the scheduled time to complete any administrative procedures.',
        ],
        'cancel_notice' => [
            'description' => 'If you are unable to attend the appointment, please contact us at least 24 hours in advance to reschedule it.',
        ],
        'questions' => [
            'description' => 'If you have any questions or need clarification, please do not hesitate to contact us.',
        ],
    ],
    'cancelled' => [
        'status' => [
            'label' => 'cancelled',
        ],
        'details' => [
            'title' => 'Cancelled appointment details',
        ],
        'rebook' => [
            'description' => 'If you would like to book a new appointment, you can do so through our online booking system or by contacting our office directly.',
        ],
        'new_button' => [
            'label' => 'Book New Appointment',
        ],
    ],
    'rescheduled' => [
        'status' => [
            'label' => 'rescheduled',
        ],
        'previous_details' => [
            'title' => 'Previous details',
        ],
        'new_details' => [
            'title' => 'New appointment details',
        ],
        'incompatible_notice' => [
            'description' => 'If the new time does not suit your schedule, please contact us as soon as possible so we can find an alternative.',
        ],
    ],
    'generic' => [
        'default' => [
            'message' => 'We would like to inform you about your appointment at our facility.',
        ],
        'contact_notice' => [
            'description' => 'For any information or needs, please do not hesitate to contact us.',
        ],
    ],
];
