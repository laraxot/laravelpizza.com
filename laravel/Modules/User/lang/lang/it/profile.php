<?php

declare(strict_types=1);

return [
    'account' => [
        'label' => 'Account',
        'description' => 'Gestione delle impostazioni dell\'account utente',
        'help' => 'Configura le informazioni del tuo account personale',
    ],
    'profile' => [
        'label' => 'Profilo',
        'description' => 'Informazioni del profilo utente',
        'help' => 'Visualizza e modifica le informazioni del tuo profilo',
    ],
    'my_profile' => [
        'label' => 'Il mio profilo',
        'description' => 'Gestione del profilo personale',
        'help' => 'Accedi alle impostazioni del tuo profilo personale',
    ],
    'subheading' => [
        'label' => 'Gestisci il tuo profilo.',
        'description' => 'Aggiorna le tue informazioni personali e le impostazioni dell\'account',
        'help' => 'Mantieni aggiornate le tue informazioni per un\'esperienza ottimale',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Identificativo univoco dell\'utente nel sistema',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia di utente nel sistema',
            'options' => [
                'admin' => 'Amministratore',
                'user' => 'Utente',
                'moderator' => 'Moderatore',
                'guest' => 'Ospite',
            ],
        ],
        'user' => [
            'name' => [
                'label' => 'Nome Utente',
                'placeholder' => 'Inserisci il nome utente',
                'help' => 'Nome utilizzato per identificarsi nel sistema',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'utente@email.com',
                'help' => 'Indirizzo email per l\'accesso e le comunicazioni',
            ],
            'phone' => [
                'label' => 'Telefono',
                'placeholder' => '+39 123 456 7890',
                'help' => 'Numero di telefono per contatti',
            ],
        ],
        'photo' => [
            'label' => 'Foto',
            'placeholder' => 'Carica una foto profilo',
            'help' => 'Immagine del profilo utente (formato JPG, PNG)',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona l\'ente',
            'help' => 'Ente di appartenenza dell\'utente',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Numero di matricola dell\'utente',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome di battesimo dell\'utente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'utente@email.com',
            'help' => 'Indirizzo email principale',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'placeholder' => 'Stato di attivazione',
            'help' => 'Indica se l\'utente è attivo nel sistema',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'Data di nascita dell\'utente',
        ],
        'gender' => [
            'label' => 'Genere',
            'placeholder' => 'Seleziona il genere',
            'help' => 'Genere dell\'utente',
            'options' => [
                'male' => 'Maschile',
                'female' => 'Femminile',
                'other' => 'Altro',
                'prefer_not_to_say' => 'Preferisco non dirlo',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma, 123',
            'help' => 'Indirizzo di residenza',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'help' => 'Città di residenza',
        ],
        'postal_code' => [
            'label' => 'Codice Postale',
            'placeholder' => '00100',
            'help' => 'Codice postale della città',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di residenza',
        ],
        'bio' => [
            'label' => 'Biografia',
            'placeholder' => 'Scrivi una breve biografia',
            'help' => 'Descrizione personale o professionale',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'https://tuosito.com',
            'help' => 'Sito web personale o professionale',
        ],
        'social_links' => [
            'label' => 'Link Social',
            'placeholder' => 'Collegamenti ai social media',
            'help' => 'Link ai tuoi profili social media',
        ],
        'language' => [
            'label' => 'Lingua',
            'placeholder' => 'Seleziona la lingua',
            'help' => 'Lingua preferita per l\'interfaccia',
            'options' => [
                'it' => 'Italiano',
                'en' => 'Inglese',
                'fr' => 'Francese',
                'de' => 'Tedesco',
                'es' => 'Spagnolo',
            ],
        ],
        'timezone' => [
            'label' => 'Fuso Orario',
            'placeholder' => 'Seleziona il fuso orario',
            'help' => 'Fuso orario di riferimento',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di registrazione',
            'help' => 'Data di registrazione dell\'account',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => 'Data ultima modifica',
            'help' => 'Data dell\'ultimo aggiornamento del profilo',
        ],
    ],
    'personal_info' => [
        'heading' => 'Informazioni personali',
        'subheading' => 'Gestisci le tue informazioni personali.',
        'description' => 'Aggiorna i tuoi dati anagrafici e di contatto',
        'submit' => [
            'label' => 'Aggiorna',
            'tooltip' => 'Salva le modifiche alle informazioni personali',
            'success' => 'Informazioni personali aggiornate con successo',
            'error' => 'Errore durante l\'aggiornamento delle informazioni',
        ],
        'notify' => 'Profilo aggiornato correttamente!',
    ],
    'security' => [
        'heading' => 'Sicurezza',
        'subheading' => 'Gestisci le impostazioni di sicurezza del tuo account.',
        'description' => 'Configura password, autenticazione a due fattori e altre impostazioni di sicurezza',
        'change_password' => [
            'label' => 'Cambia Password',
            'description' => 'Aggiorna la password del tuo account',
            'current_password' => [
                'label' => 'Password Attuale',
                'placeholder' => 'Inserisci la password attuale',
                'help' => 'Conferma la tua password attuale',
            ],
            'new_password' => [
                'label' => 'Nuova Password',
                'placeholder' => 'Inserisci la nuova password',
                'help' => 'La password deve contenere almeno 8 caratteri',
            ],
            'confirm_password' => [
                'label' => 'Conferma Password',
                'placeholder' => 'Conferma la nuova password',
                'help' => 'Ripeti la nuova password per confermarla',
            ],
        ],
        'two_factor' => [
            'heading' => 'Autenticazione a Due Fattori',
            'description' => 'Aggiungi un livello extra di sicurezza al tuo account',
            'enable' => [
                'label' => 'Abilita 2FA',
                'description' => 'Proteggi il tuo account con l\'autenticazione a due fattori',
            ],
            'disable' => [
                'label' => 'Disabilita 2FA',
                'description' => 'Rimuovi l\'autenticazione a due fattori',
            ],
        ],
    ],
    'preferences' => [
        'heading' => 'Preferenze',
        'subheading' => 'Personalizza la tua esperienza utente.',
        'description' => 'Configura le tue preferenze per l\'interfaccia e le notifiche',
        'notifications' => [
            'label' => 'Notifiche',
            'email_notifications' => [
                'label' => 'Notifiche Email',
                'help' => 'Ricevi notifiche via email',
            ],
            'push_notifications' => [
                'label' => 'Notifiche Push',
                'help' => 'Ricevi notifiche push nel browser',
            ],
            'sms_notifications' => [
                'label' => 'Notifiche SMS',
                'help' => 'Ricevi notifiche via SMS',
            ],
        ],
        'privacy' => [
            'label' => 'Privacy',
            'profile_visibility' => [
                'label' => 'Visibilità Profilo',
                'help' => 'Chi può vedere il tuo profilo',
                'options' => [
                    'public' => 'Pubblico',
                    'private' => 'Privato',
                    'friends' => 'Solo amici',
                ],
            ],
            'show_email' => [
                'label' => 'Mostra Email',
                'help' => 'Rendi visibile la tua email nel profilo pubblico',
            ],
            'show_phone' => [
                'label' => 'Mostra Telefono',
                'help' => 'Rendi visibile il tuo telefono nel profilo pubblico',
            ],
        ],
    ],
    'actions' => [
        'edit_profile' => [
            'label' => 'Modifica Profilo',
            'tooltip' => 'Modifica le informazioni del profilo',
        ],
        'upload_photo' => [
            'label' => 'Carica Foto',
            'tooltip' => 'Carica una nuova foto profilo',
            'success' => 'Foto profilo caricata con successo',
            'error' => 'Errore durante il caricamento della foto',
        ],
        'remove_photo' => [
            'label' => 'Rimuovi Foto',
            'tooltip' => 'Rimuovi la foto profilo',
            'confirmation' => 'Sei sicuro di voler rimuovere la foto profilo?',
            'success' => 'Foto profilo rimossa con successo',
            'error' => 'Errore durante la rimozione della foto',
        ],
        'delete_account' => [
            'label' => 'Elimina Account',
            'tooltip' => 'Elimina definitivamente il tuo account',
            'confirmation' => 'Sei sicuro di voler eliminare definitivamente il tuo account? Questa azione non può essere annullata.',
            'modal_heading' => 'Conferma Eliminazione Account',
            'modal_description' => 'Tutti i tuoi dati verranno eliminati permanentemente. Questa azione è irreversibile.',
            'success' => 'Account eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dell\'account',
        ],
    ],
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Dati anagrafici principali',
        ],
        'contact_info' => [
            'label' => 'Informazioni di Contatto',
            'description' => 'Email, telefono e indirizzi',
        ],
        'professional_info' => [
            'label' => 'Informazioni Professionali',
            'description' => 'Ente, matricola e ruolo',
        ],
        'personal_preferences' => [
            'label' => 'Preferenze Personali',
            'description' => 'Lingua, fuso orario e impostazioni',
        ],
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già in uso',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
        'confirmed' => 'La conferma del campo :attribute non corrisponde',
        'image' => 'Il file deve essere un\'immagine',
        'max_file_size' => 'Il file non può superare :size MB',
        'url' => 'Il campo :attribute deve essere un URL valido',
        'phone' => 'Il numero di telefono deve essere valido',
        'postal_code' => 'Il codice postale deve essere valido',
    ],
    'messages' => [
        'profile_updated' => 'Profilo aggiornato con successo',
        'password_changed' => 'Password cambiata con successo',
        'photo_uploaded' => 'Foto profilo caricata con successo',
        'photo_removed' => 'Foto profilo rimossa',
        'preferences_saved' => 'Preferenze salvate con successo',
        'account_deleted' => 'Account eliminato con successo',
        'error_occurred' => 'Si è verificato un errore',
        'changes_saved' => 'Modifiche salvate',
        'no_changes' => 'Nessuna modifica da salvare',
    ],
];
