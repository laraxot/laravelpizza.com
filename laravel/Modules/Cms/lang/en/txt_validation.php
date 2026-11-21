<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/en/txt_validation.php
return [
    'validation' => [
        'title_required' => 'The title is required',
        'slug_unique' => 'This slug is already in use',
        'email_format' => 'Enter a valid email address',
        'url_format' => 'Enter a valid URL',
        'phone_format' => 'Enter a valid phone number',
        'image_size' => 'The image must be smaller than 5MB',
        'video_format' => 'Unsupported video format',
        'required_field' => 'This field is required',
        'max_length' => 'The text is too long (maximum :max characters)',
        'min_length' => 'The text is too short (minimum :min characters)',
    ],
];
