<?php

declare(strict_types=1);

// Validazione en del modulo User: la base e' il set completo di Modules/Xot, qui si aggiungono le regole che Xot non ha e i messaggi propri di User.
// Prima era una copia byte per byte del file italiano e, caricata dopo quella di Xot, la oscurava (DCP-146).
$base = (array) require base_path('Modules/Xot/lang/en/validation.php');

return array_replace_recursive(
    $base,
    [
        'date_equals' => 'The :attribute field must be a date equal to :date.',
        'ends_with' => 'The :attribute field must end with one of the following: :values.',
        'gt' => [
            'numeric' => 'The :attribute field must be greater than :value.',
            'file' => 'The :attribute field must be greater than :value kilobytes.',
            'string' => 'The :attribute field must be greater than :value characters.',
            'array' => 'The :attribute field must have more than :value items.',
        ],
        'gte' => [
            'numeric' => 'The :attribute field must be greater than or equal to :value.',
            'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
            'string' => 'The :attribute field must be greater than or equal to :value characters.',
            'array' => 'The :attribute field must have :value items or more.',
        ],
        'ipv4' => 'The :attribute field must be a valid IPv4 address.',
        'ipv6' => 'The :attribute field must be a valid IPv6 address.',
        'lt' => [
            'numeric' => 'The :attribute field must be less than :value.',
            'file' => 'The :attribute field must be less than :value kilobytes.',
            'string' => 'The :attribute field must be less than :value characters.',
            'array' => 'The :attribute field must have less than :value items.',
        ],
        'lte' => [
            'numeric' => 'The :attribute field must be less than or equal to :value.',
            'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
            'string' => 'The :attribute field must be less than or equal to :value characters.',
            'array' => 'The :attribute field must not have more than :value items.',
        ],
        'mimetypes' => 'The :attribute field must be a file of type: :values.',
        'multiple_of' => 'The :attribute field must be a multiple of :value.',
        'not_regex' => 'The :attribute field format is invalid.',
        'password' => [
            'letters' => 'The :attribute field must contain at least one letter.',
            'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
            'numbers' => 'The :attribute field must contain at least one number.',
            'symbols' => 'The :attribute field must contain at least one symbol.',
            'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
        ],
        'starts_with' => 'The :attribute field must start with one of the following: :values.',
        'uploaded' => 'The :attribute failed to upload.',
        'uuid' => 'The :attribute field must be a valid UUID.',
        'email_already_taken' => 'This email address is already used by another user.',
        'password_confirmation' => 'The password confirmation does not match.',
        'password_current_required' => 'The current password is required.',
        'password_current_incorrect' => 'The current password is incorrect.',
        'name_required' => 'The name is required.',
        'email_required' => 'The email is required.',
        'email_format' => 'The email must have a valid format.',
        'phone_format' => 'The phone number must have a valid format.',
        'birth_date_before' => 'The date of birth must be before today.',
    ],
);
