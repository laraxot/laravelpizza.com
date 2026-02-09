<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Inizia il tuo Viaggio nella Pizza 🍕',
        'subtitle' => 'Unisciti a 5.000+ appassionati e developer. Accesso esclusivo a meetup e tutorial.',
        'submit' => 'Entra nella Community ora',
        'submitting' => 'Stiamo preparando il forno...',
        'already_have_account' => 'Sei già dei nostri?',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'La tua migliore Email',
        'password' => 'Password Sicura',
        'password_confirmation' => 'Conferma Password',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_required' => 'Accetta l\'informativa privacy per procedere.',
        'terms_required' => 'Accetta i termini e condizioni per procedere.',
        'marketing_label' => 'Voglio ricevere consigli sulla pizza e inviti ai meetup (Opzionale)',
        
        'privacy_checkbox_html' => 'Ho letto l\'<a href=":privacy_url" target="_blank" class="underline font-bold">Informativa Privacy</a>',
        'terms_checkbox_html' => 'Accetto i <a href=":terms_url" target="_blank" class="underline font-bold">Termini e Condizioni</a>',

        'title' => 'Consensi Obbligatori',
        'required_consent_missing' => 'Devi accettare tutti i consensi obbligatori per procedere.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La password deve contenere almeno 12 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.',
    ],

    // === MESSAGES ===
    'success' => 'Registrazione completata! Benvenuto in famiglia.',
    'success_message' => 'Il tuo account è pronto. Ora puoi esplorare tutti i meetup!',
    'error' => 'Ops! Qualcosa è andato storto.',
    'error_message' => 'Riprova tra un istante, stiamo sistemando il problema.',

    'login' => 'Accedi',
    'already_registered' => 'Hai già un account?',
];