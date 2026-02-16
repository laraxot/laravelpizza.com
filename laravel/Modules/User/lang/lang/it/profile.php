<?php

declare(strict_types=1);

return array (
  'account' => 
  array (
    'label' => 'Account',
    'description' => 'Gestione delle impostazioni dell\'account utente',
    'help' => 'Configura le informazioni del tuo account personale',
  ),
  'profile' => 
  array (
    'label' => 'Profilo',
    'description' => 'Informazioni del profilo utente',
    'help' => 'Visualizza e modifica le informazioni del tuo profilo',
  ),
  'my_profile' => 
  array (
    'label' => 'Il mio profilo',
    'description' => 'Gestione del profilo personale',
    'help' => 'Accedi alle impostazioni del tuo profilo personale',
  ),
  'subheading' => 
  array (
    'label' => 'Gestisci il tuo profilo.',
    'description' => 'Aggiorna le tue informazioni personali e le impostazioni dell\'account',
    'help' => 'Mantieni aggiornate le tue informazioni per un\'esperienza ottimale',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Identificativo univoco',
      'help' => 'Identificativo univoco dell\'utente nel sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'help' => 'Tipologia di utente nel sistema',
      'options' => 
      array (
        'admin' => 'Amministratore',
        'user' => 'Utente',
        'moderator' => 'Moderatore',
        'guest' => 'Ospite',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Utente',
        'placeholder' => 'Inserisci il nome utente',
        'help' => 'Nome utilizzato per identificarsi nel sistema',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'utente@email.com',
        'help' => 'Indirizzo email per l\'accesso e le comunicazioni',
      ),
      'phone' => 
      array (
        'label' => 'Telefono',
        'placeholder' => '+39 123 456 7890',
        'help' => 'Numero di telefono per contatti',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'photo' => 
    array (
      'label' => 'Foto',
      'placeholder' => 'Carica una foto profilo',
      'help' => 'Immagine del profilo utente (formato JPG, PNG)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ente' => 
    array (
      'label' => 'Ente',
      'placeholder' => 'Seleziona l\'ente',
      'help' => 'Ente di appartenenza dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'matr' => 
    array (
      'label' => 'Matricola',
      'placeholder' => 'Inserisci la matricola',
      'help' => 'Numero di matricola dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome di battesimo dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'utente@email.com',
      'help' => 'Indirizzo email principale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => 'Stato di attivazione',
      'help' => 'Indica se l\'utente è attivo nel sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'help' => 'Data di nascita dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'gender' => 
    array (
      'label' => 'Genere',
      'placeholder' => 'Seleziona il genere',
      'help' => 'Genere dell\'utente',
      'options' => 
      array (
        'male' => 'Maschile',
        'female' => 'Femminile',
        'other' => 'Altro',
        'prefer_not_to_say' => 'Preferisco non dirlo',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Indirizzo di residenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'help' => 'Città di residenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'Codice Postale',
      'placeholder' => '00100',
      'help' => 'Codice postale della città',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese di residenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'bio' => 
    array (
      'label' => 'Biografia',
      'placeholder' => 'Scrivi una breve biografia',
      'help' => 'Descrizione personale o professionale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'website' => 
    array (
      'label' => 'Sito Web',
      'placeholder' => 'https://tuosito.com',
      'help' => 'Sito web personale o professionale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'social_links' => 
    array (
      'label' => 'Link Social',
      'placeholder' => 'Collegamenti ai social media',
      'help' => 'Link ai tuoi profili social media',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'language' => 
    array (
      'label' => 'Lingua',
      'placeholder' => 'Seleziona la lingua',
      'help' => 'Lingua preferita per l\'interfaccia',
      'options' => 
      array (
        'it' => 'Italiano',
        'en' => 'Inglese',
        'fr' => 'Francese',
        'de' => 'Tedesco',
        'es' => 'Spagnolo',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso Orario',
      'placeholder' => 'Seleziona il fuso orario',
      'help' => 'Fuso orario di riferimento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di registrazione',
      'help' => 'Data di registrazione dell\'account',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'placeholder' => 'Data ultima modifica',
      'help' => 'Data dell\'ultimo aggiornamento del profilo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'personal_info' => 
  array (
    'heading' => 'Informazioni personali',
    'subheading' => 'Gestisci le tue informazioni personali.',
    'description' => 'Aggiorna i tuoi dati anagrafici e di contatto',
    'submit' => 
    array (
      'label' => 'Aggiorna',
      'tooltip' => 'Salva le modifiche alle informazioni personali',
      'success' => 'Informazioni personali aggiornate con successo',
      'error' => 'Errore durante l\'aggiornamento delle informazioni',
    ),
    'notify' => 'Profilo aggiornato correttamente!',
  ),
  'security' => 
  array (
    'heading' => 'Sicurezza',
    'subheading' => 'Gestisci le impostazioni di sicurezza del tuo account.',
    'description' => 'Configura password, autenticazione a due fattori e altre impostazioni di sicurezza',
    'change_password' => 
    array (
      'label' => 'Cambia Password',
      'description' => 'Aggiorna la password del tuo account',
      'current_password' => 
      array (
        'label' => 'Password Attuale',
        'placeholder' => 'Inserisci la password attuale',
        'help' => 'Conferma la tua password attuale',
      ),
      'new_password' => 
      array (
        'label' => 'Nuova Password',
        'placeholder' => 'Inserisci la nuova password',
        'help' => 'La password deve contenere almeno 8 caratteri',
      ),
      'confirm_password' => 
      array (
        'label' => 'Conferma Password',
        'placeholder' => 'Conferma la nuova password',
        'help' => 'Ripeti la nuova password per confermarla',
      ),
    ),
    'two_factor' => 
    array (
      'heading' => 'Autenticazione a Due Fattori',
      'description' => 'Aggiungi un livello extra di sicurezza al tuo account',
      'enable' => 
      array (
        'label' => 'Abilita 2FA',
        'description' => 'Proteggi il tuo account con l\'autenticazione a due fattori',
      ),
      'disable' => 
      array (
        'label' => 'Disabilita 2FA',
        'description' => 'Rimuovi l\'autenticazione a due fattori',
      ),
    ),
  ),
  'preferences' => 
  array (
    'heading' => 'Preferenze',
    'subheading' => 'Personalizza la tua esperienza utente.',
    'description' => 'Configura le tue preferenze per l\'interfaccia e le notifiche',
    'notifications' => 
    array (
      'label' => 'Notifiche',
      'email_notifications' => 
      array (
        'label' => 'Notifiche Email',
        'help' => 'Ricevi notifiche via email',
      ),
      'push_notifications' => 
      array (
        'label' => 'Notifiche Push',
        'help' => 'Ricevi notifiche push nel browser',
      ),
      'sms_notifications' => 
      array (
        'label' => 'Notifiche SMS',
        'help' => 'Ricevi notifiche via SMS',
      ),
    ),
    'privacy' => 
    array (
      'label' => 'Privacy',
      'profile_visibility' => 
      array (
        'label' => 'Visibilità Profilo',
        'help' => 'Chi può vedere il tuo profilo',
        'options' => 
        array (
          'public' => 'Pubblico',
          'private' => 'Privato',
          'friends' => 'Solo amici',
        ),
      ),
      'show_email' => 
      array (
        'label' => 'Mostra Email',
        'help' => 'Rendi visibile la tua email nel profilo pubblico',
      ),
      'show_phone' => 
      array (
        'label' => 'Mostra Telefono',
        'help' => 'Rendi visibile il tuo telefono nel profilo pubblico',
      ),
    ),
  ),
  'actions' => 
  array (
    'edit_profile' => 
    array (
      'label' => 'Modifica Profilo',
      'tooltip' => 'Modifica le informazioni del profilo',
    ),
    'upload_photo' => 
    array (
      'label' => 'Carica Foto',
      'tooltip' => 'Carica una nuova foto profilo',
      'success' => 'Foto profilo caricata con successo',
      'error' => 'Errore durante il caricamento della foto',
    ),
    'remove_photo' => 
    array (
      'label' => 'Rimuovi Foto',
      'tooltip' => 'Rimuovi la foto profilo',
      'confirmation' => 'Sei sicuro di voler rimuovere la foto profilo?',
      'success' => 'Foto profilo rimossa con successo',
      'error' => 'Errore durante la rimozione della foto',
    ),
    'delete_account' => 
    array (
      'label' => 'Elimina Account',
      'tooltip' => 'Elimina definitivamente il tuo account',
      'confirmation' => 'Sei sicuro di voler eliminare definitivamente il tuo account? Questa azione non può essere annullata.',
      'modal_heading' => 'Conferma Eliminazione Account',
      'modal_description' => 'Tutti i tuoi dati verranno eliminati permanentemente. Questa azione è irreversibile.',
      'success' => 'Account eliminato con successo',
      'error' => 'Errore durante l\'eliminazione dell\'account',
    ),
  ),
  'sections' => 
  array (
    'basic_info' => 
    array (
      'label' => 'Informazioni Base',
      'description' => 'Dati anagrafici principali',
    ),
    'contact_info' => 
    array (
      'label' => 'Informazioni di Contatto',
      'description' => 'Email, telefono e indirizzi',
    ),
    'professional_info' => 
    array (
      'label' => 'Informazioni Professionali',
      'description' => 'Ente, matricola e ruolo',
    ),
    'personal_preferences' => 
    array (
      'label' => 'Preferenze Personali',
      'description' => 'Lingua, fuso orario e impostazioni',
    ),
  ),
  'validation' => 
  array (
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il valore del campo :attribute è già in uso',
    'min' => 
    array (
      'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
    ),
    'max' => 
    array (
      'string' => 'Il campo :attribute non può superare :max caratteri',
    ),
    'confirmed' => 'La conferma del campo :attribute non corrisponde',
    'image' => 'Il file deve essere un\'immagine',
    'max_file_size' => 'Il file non può superare :size MB',
    'url' => 'Il campo :attribute deve essere un URL valido',
    'phone' => 'Il numero di telefono deve essere valido',
    'postal_code' => 'Il codice postale deve essere valido',
  ),
  'messages' => 
  array (
    'profile_updated' => 'Profilo aggiornato con successo',
    'password_changed' => 'Password cambiata con successo',
    'photo_uploaded' => 'Foto profilo caricata con successo',
    'photo_removed' => 'Foto profilo rimossa',
    'preferences_saved' => 'Preferenze salvate con successo',
    'account_deleted' => 'Account eliminato con successo',
    'error_occurred' => 'Si è verificato un errore',
    'changes_saved' => 'Modifiche salvate',
    'no_changes' => 'Nessuna modifica da salvare',
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
