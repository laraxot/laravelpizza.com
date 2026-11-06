<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/txt/validation.php
return [
    'title_required' => 'The title is required',
    'slug_unique' => 'Questo slug è già in uso',
    'email_format' => 'Inserisci un indirizzo email valido',
    'url_format' => 'Inserisci un URL valido',
    'phone_format' => 'Inserisci un numero di telefono valido',
    'image_size' => 'L\'immagine deve essere inferiore a 5MB',
    'video_format' => 'Formato video non supportato',
    'required_field' => 'This field is required',
    'max_length' => 'Il testo è troppo lungo (massimo :max caratteri)',
    'min_length' => 'Il testo è troppo corto (minimo :min caratteri)',
];
