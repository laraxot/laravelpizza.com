<?php

declare(strict_types=1);

return [
    'actions' => [
        'register' => 'Register for this event',
        'login_to_register' => 'Sign in to register',
        'unregister' => 'Cancel registration',
        'loading' => 'One moment…',
    ],
    'state' => [
        'registered' => 'You are registered for this event.',
        'full' => 'Sold out: this event has reached its maximum capacity.',
        'spots_left' => '{0} No spots left|{1} :count spot left|[2,*] :count spots left',
    ],
    'messages' => [
        'registered' => 'You are in! We sent you a confirmation email.',
        'unregistered' => 'Your registration has been cancelled.',
        'full' => 'Sorry, this event is full.',
        'already_registered' => 'You are already registered for this event.',
        'not_registered' => 'You are not registered for this event.',
        'started' => 'This event has already started: registrations are closed.',
        'closed' => 'Registrations for this event are not open.',
    ],
    'mail' => [
        'subject' => 'Registration confirmed: :title',
        'greeting' => 'Hi!',
        'intro' => 'Your registration for ":title" is confirmed.',
        'date' => 'When: :date',
        'venue' => 'Where: :venue',
        'action' => 'View the event',
    ],
    'reminder' => [
        'subject' => 'Tomorrow: :title',
        'intro' => 'A friendly reminder that ":title" is tomorrow. See you there!',
        'cant_come' => 'Can\'t make it anymore? Cancel your registration from the event page so someone else can take your seat.',
    ],
    'add_to_calendar' => 'Add to calendar',
];
