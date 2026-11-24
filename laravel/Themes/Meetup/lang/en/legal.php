<?php

declare(strict_types=1);

// Side boxes of the legal pages (legal/article block: privacy, terms).
// Both key families are kept: `contacts`/`note` (root) and `article.*` (nested package, the only one es/de translate).
return [
    'contacts' => [
        'title' => 'Contacts',
        'intro' => 'For legal or privacy requests, or about the content of the site, write to the contacts below.',
    ],
    'note' => [
        'title' => 'Note',
        'body' => 'These pages describe the main rules and information of the Laravel Pizza service. If you need specific clarifications, contact us before attending an event or sharing personal data.',
    ],
    'article' => [
        'contact_intro' => [
            'message' => 'For legal, privacy or site content requests, you can write to the contacts below.',
        ],
        'note' => [
            'title' => 'Note',
            'message' => 'These pages describe the main rules and information of the Laravel Pizza service. If you need specific clarifications, contact us before attending an event or sharing personal data.',
        ],
    ],
];
