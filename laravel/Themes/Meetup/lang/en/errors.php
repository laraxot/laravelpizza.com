<?php

declare(strict_types=1);

// Pagine di errore (laravel/resources/views/errors/*, Themes/Meetup/resources/views/errors/page.blade.php)
return [
    '403' => [
        'title' => 'Access denied',
        'message' => 'This page isn\'t available for your account.',
    ],
    '404' => [
        'title' => 'Page not found',
        'message' => 'The page you\'re looking for doesn\'t exist or has moved. Maybe the event is already over?',
    ],
    '419' => [
        'title' => 'Session expired',
        'message' => 'This page was open for too long. Reload it and try again.',
    ],
    '429' => [
        'title' => 'Too many requests',
        'message' => 'You\'ve made a lot of requests in a short time. Wait a minute and try again.',
    ],
    '500' => [
        'title' => 'Something went wrong',
        'message' => 'We hit a technical problem. Please try again in a few minutes.',
    ],
    '503' => [
        'title' => 'Back soon',
        'message' => 'We\'re updating the site. Please try again in a few minutes.',
    ],
    'label' => 'Error',
    'actions' => [
        'home' => 'Back to home',
        'events' => 'See upcoming events',
        'reload' => 'Reload the page',
        'login' => 'Sign in',
    ],
];
