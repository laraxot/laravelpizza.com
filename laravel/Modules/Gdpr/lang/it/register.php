<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'register' => [
        'title' => 'Unisciti alla Pizza Revolution 🍕',
        'subtitle' => 'Entra nella community di 5.000+ developer e appassionati. Meetup esclusivi, tutorial e networking ti aspettano.',
        'submit' => 'Crea il mio account gratis',
        'submitting' => 'Stiamo preparando il tuo account...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'La tua migliore Email',
        'password' => 'Password sicura',
        'password_confirmation' => 'Conferma Password',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consensi Privacy',
        'privacy_checkbox_html' => 'Ho letto e accetto l\'<a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Informativa Privacy</a>',
        'privacy_policy_required' => 'Devi accettare l\'informativa privacy per procedere.',
        'terms_checkbox_html' => 'Ho letto e accetto i <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Termini e Condizioni</a>',
        'terms_required' => 'Devi accettare i termini e condizioni per procedere.',
        'marketing_label' => 'Voglio ricevere consigli sulla pizza e inviti ai meetup (facoltativo)',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La password deve contenere almeno 12 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.',
    ],

    // === MESSAGES ===
    'already_registered' => 'Hai già un account?',
    'login' => 'Accedi subito',
    'success' => 'Benvenuto nella famiglia! 🎉',
    'success_message' => 'Il tuo account è pronto. Ora puoi esplorare tutti i meetup!',
    'error' => 'Ops! Qualcosa è andato storto.',
    'error_message' => 'Riprova tra un istante, stiamo sistemando il problema.',
];