<?php

declare(strict_types=1);

return [
    'edit_user' => [
        'title' => 'Modifica Profilo Utente',
        'description' => 'Aggiorna le informazioni del profilo utente',
        'sections' => [
            'personal_info' => [
                'title' => 'Informazioni Personali',
                'description' => 'Dati anagrafici e contatti',
            ],
            'preferences' => [
                'title' => 'Preferenze',
                'description' => 'Impostazioni personali e lingua',
            ],
            'security' => [
                'title' => 'Sicurezza',
                'description' => 'Password e impostazioni di sicurezza',
            ],
            'admin_settings' => [
                'title' => 'Impostazioni Amministratore',
                'description' => 'Configurazioni riservate agli amministratori',
            ],
        ],
        'fields' => [
            'profile_photo_path' => [
                'label' => 'Foto Profilo',
                'placeholder' => 'Carica una foto profilo',
                'help' => 'Formati supportati: JPEG, PNG, WebP. Dimensione massima: 2MB',
            ],
            'first_name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome',
                'help' => 'Il tuo nome di battesimo',
            ],
            'last_name' => [
                'label' => 'Cognome',
                'placeholder' => 'Inserisci il cognome',
                'help' => 'Il tuo cognome',
            ],
            'name' => [
                'label' => 'Nome Completo',
                'placeholder' => 'Inserisci il nome completo',
                'help' => 'Nome e cognome come devono apparire nel sistema',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci l\'indirizzo email',
                'help' => 'Indirizzo email per accesso e comunicazioni',
            ],
            'lang' => [
                'label' => 'Lingua',
                'placeholder' => 'Seleziona la lingua',
                'help' => 'Lingua dell\'interfaccia utente',
                'options' => [
                    'it' => 'Italiano',
                    'en' => 'English',
                    'es' => 'Español',
                    'fr' => 'Français',
                    'de' => 'Deutsch',
                ],
            ],
            'password' => [
                'label' => 'Nuova Password',
                'placeholder' => 'Inserisci una nuova password',
                'help' => 'Lascia vuoto per mantenere la password attuale',
            ],
            'password_confirmation' => [
                'label' => 'Conferma Password',
                'placeholder' => 'Conferma la nuova password',
                'help' => 'Ripeti la nuova password per conferma',
            ],
            'is_otp' => [
                'label' => 'Autenticazione a Due Fattori (OTP)',
                'help' => 'Abilita l\'autenticazione a due fattori per maggiore sicurezza',
            ],
            'password_expires_at' => [
                'label' => 'Scadenza Password',
                'placeholder' => 'Seleziona data e ora di scadenza',
                'help' => 'Data e ora in cui la password scadrà',
            ],
            'is_active' => [
                'label' => 'Account Attivo',
                'help' => 'Determina se l\'account è attivo e può accedere al sistema',
            ],
        ],
        'actions' => [
            'save' => [
                'label' => 'Salva Modifiche',
                'tooltip' => 'Salva le modifiche apportate al profilo',
            ],
            'cancel' => [
                'label' => 'Annulla',
                'tooltip' => 'Annulla le modifiche e ripristina i valori originali',
            ],
        ],
        'messages' => [
            'saved' => 'Profilo aggiornato con successo',
            'cancelled' => 'Modifiche annullate',
            'error' => 'Si è verificato un errore durante il salvataggio',
            'unauthorized' => 'Non sei autorizzato a modificare questo profilo',
        ],
        'validation' => [
            'email_unique' => 'Questo indirizzo email è già in uso',
            'password_confirmation' => 'La conferma password non corrisponde',
            'required' => 'Dieses Feld ist erforderlich',
        ],
    ],
    'registration' => [
        'title' => 'Registrazione Utente',
        'description' => 'Crea un nuovo account utente',
        'fields' => [
            'type' => [
                'label' => 'Tipo Utente',
                'placeholder' => 'Seleziona il tipo di utente',
                'help' => 'Il tipo di account che stai creando',
            ],
        ],
        'messages' => [
            'success' => 'Registrazione completata con successo',
            'error' => 'Si è verificato un errore durante la registrazione',
        ],
    ],
    'login' => [
        'title' => 'Accesso',
        'description' => 'Accedi al tuo account',
        'fields' => [
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci la tua email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Inserisci la tua password',
            ],
            'remember' => [
                'label' => 'Ricordami',
            ],
        ],
        'actions' => [
            'login' => [
                'label' => 'Accedi',
            ],
            'forgot_password' => [
                'label' => 'Password dimenticata?',
            ],
        ],
        'messages' => [
            'success' => 'Accesso effettuato con successo',
            'error' => 'Credenziali non valide',
        ],
    ],
    'logout' => [
        'title' => 'Disconnessione',
        'description' => 'Esci dal tuo account',
        'actions' => [
            'logout' => [
                'label' => 'Disconnetti',
            ],
            'confirm' => [
                'label' => 'Conferma',
            ],
            'cancel' => [
                'label' => 'Annulla',
            ],
        ],
        'messages' => [
            'success' => 'Disconnessione effettuata con successo',
            'confirm' => 'Sei sicuro di voler uscire?',
        ],
    ],
];
