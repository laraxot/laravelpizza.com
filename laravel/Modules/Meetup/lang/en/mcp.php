<?php

declare(strict_types=1);

// Messages of the MCP server tools (Modules\Meetup\Mcp): the agent reads them and often repeats them to the user.
return [
    'messages' => [
        'registered' => 'Registration to ":title" confirmed. We sent the summary email with the calendar file.',
        'already_registered' => 'You are already registered to ":title".',
        'unregistered' => 'Registration to ":title" cancelled: the seat is available again.',
    ],
    'errors' => [
        'unauthenticated' => 'A user is required: connect the client with a Laravel Pizza Meetups personal token.',
        'not_found' => 'No published event with slug ":slug". Use search_events to find the slug.',
        'full' => '":title" is full: no seats left.',
        'started' => '":title" has already started: registrations are closed.',
        'not_registered' => 'You are not registered to ":title".',
        'closed' => 'Registrations to ":title" are not open.',
    ],
];
