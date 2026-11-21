<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/en/txt/actions.php
return [
    'save' => [
        'label' => 'Save',
        'success' => 'Content saved successfully',
        'error' => 'Error while saving the content',
        'confirmation' => 'Do you want to save the changes?',
    ],
    'cancel' => [
        'label' => 'Cancel',
        'confirmation' => 'Are you sure you want to cancel? All unsaved changes will be lost.',
    ],
    'activeLocale' => [
        'label' => 'Active Language',
        'description' => 'Select the language for the content translation',
        'help' => 'Change the editing language for multilingual content',
    ],
];
