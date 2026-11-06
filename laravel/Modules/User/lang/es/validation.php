<?php

declare(strict_types=1);

// Validazione es del modulo User: la base e' il set completo di Modules/Xot, qui si aggiungono le regole che Xot non ha e i messaggi propri di User.
// Prima era una copia byte per byte del file italiano e, caricata dopo quella di Xot, la oscurava (DCP-146).
$base = (array) require base_path('Modules/Xot/lang/es/validation.php');

return array_replace_recursive(
    $base,
    [
        'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
        'ends_with' => 'El campo :attribute debe terminar con uno de los siguientes valores: :values.',
        'gt' => [
            'numeric' => 'El campo :attribute debe ser mayor que :value.',
            'file' => 'El campo :attribute debe ser mayor que :value kilobytes.',
            'string' => 'El campo :attribute debe tener más de :value caracteres.',
            'array' => 'El campo :attribute debe tener más de :value elementos.',
        ],
        'gte' => [
            'numeric' => 'El campo :attribute debe ser mayor o igual que :value.',
            'file' => 'El campo :attribute debe ser mayor o igual que :value kilobytes.',
            'string' => 'El campo :attribute debe tener :value caracteres o más.',
            'array' => 'El campo :attribute debe tener :value elementos o más.',
        ],
        'ipv4' => 'El campo :attribute debe ser una dirección IPv4 válida.',
        'ipv6' => 'El campo :attribute debe ser una dirección IPv6 válida.',
        'lt' => [
            'numeric' => 'El campo :attribute debe ser menor que :value.',
            'file' => 'El campo :attribute debe ser menor que :value kilobytes.',
            'string' => 'El campo :attribute debe tener menos de :value caracteres.',
            'array' => 'El campo :attribute debe tener menos de :value elementos.',
        ],
        'lte' => [
            'numeric' => 'El campo :attribute debe ser menor o igual que :value.',
            'file' => 'El campo :attribute debe ser menor o igual que :value kilobytes.',
            'string' => 'El campo :attribute debe tener como máximo :value caracteres.',
            'array' => 'El campo :attribute no debe tener más de :value elementos.',
        ],
        'mimetypes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
        'multiple_of' => 'El campo :attribute debe ser un múltiplo de :value.',
        'not_regex' => 'El formato del campo :attribute no es válido.',
        'password' => [
            'letters' => 'El campo :attribute debe contener al menos una letra.',
            'mixed' => 'El campo :attribute debe contener al menos una letra mayúscula y una minúscula.',
            'numbers' => 'El campo :attribute debe contener al menos un número.',
            'symbols' => 'El campo :attribute debe contener al menos un símbolo.',
            'uncompromised' => 'El :attribute indicado ha aparecido en una filtración de datos. Elige otro :attribute.',
        ],
        'starts_with' => 'El campo :attribute debe empezar con uno de los siguientes valores: :values.',
        'uploaded' => 'No se ha podido subir el campo :attribute.',
        'uuid' => 'El campo :attribute debe ser un UUID válido.',
        'email_already_taken' => 'Este correo electrónico ya está en uso por otro usuario.',
        'password_confirmation' => 'La confirmación de la contraseña no coincide.',
        'password_current_required' => 'La contraseña actual es obligatoria.',
        'password_current_incorrect' => 'La contraseña actual no es correcta.',
        'name_required' => 'El nombre es obligatorio.',
        'email_required' => 'El correo electrónico es obligatorio.',
        'email_format' => 'El correo electrónico debe tener un formato válido.',
        'phone_format' => 'El número de teléfono debe tener un formato válido.',
        'birth_date_before' => 'La fecha de nacimiento debe ser anterior a hoy.',
    ],
);
