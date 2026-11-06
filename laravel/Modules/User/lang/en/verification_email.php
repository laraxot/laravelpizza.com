<?php

declare(strict_types=1);

// Testi della mail di verifica indirizzo (template database `verify-email`, Notify/SpatieEmail).
return [
    'subject' => 'Confirm your email address',
    'greeting' => 'Dear {{ first_name }} {{ last_name }},',
    'intro' => 'thank you for signing up to FixCity. Please confirm your email address to activate your account.',
    'action' => 'Confirm email',
    'fallback' => 'If the button does not work, copy this address into your browser:',
    'ignore' => 'If you did not create this account, you can ignore this message.',
];
