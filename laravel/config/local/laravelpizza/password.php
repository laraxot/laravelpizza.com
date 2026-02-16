<?php

declare(strict_types=1);

return [
    'otp_expiration_minutes' => 15,
    'otp_length' => 6,
    'expires_in' => 90,
    'min' => 12, // Più sicuro per meetups tech Laravel
    'mixedCase' => true,
    'letters' => true,
    'numbers' => true,
    'symbols' => true,
    'uncompromised' => true,
    'compromisedThreshold' => 0, // Zero tolerance per data breaches nel 2025
];
