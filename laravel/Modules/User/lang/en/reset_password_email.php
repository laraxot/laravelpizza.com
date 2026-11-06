<?php

declare(strict_types=1);

// Testi della mail di reimpostazione password (template database `reset-password`, creato da EnsureResetPasswordMailTemplateAction).
return [
    'subject' => 'Reset your password',
    'greeting' => 'Dear user,',
    'intro' => 'We received a request to reset the password of your :app account. Use the button below to choose a new one.',
    'action' => 'Reset password',
    'fallback' => 'If the button does not work, copy this address into your browser:',
    'ignore' => 'If you did not request this, you can ignore this message: your password will not change.',
];
