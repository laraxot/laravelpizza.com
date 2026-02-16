<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 'Sistema',
    'label' => 'Contatti Notifiche',
    'icon' => 'notify-contacts-animated',
    'sort' => 49,
    'description' => 'Gestione dei contatti per l\'invio delle notifiche',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del contatto',
      'placeholder' => 'es: Mario Rossi',
      'help' => 'Inserisci il nome completo del contatto',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => 'Indirizzo email del contatto',
      'placeholder' => 'es: mario.rossi@example.com',
      'help' => 'Inserisci un indirizzo email valido',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'tooltip' => 'Numero di telefono del contatto',
      'placeholder' => 'es: +39 123 456 7890',
      'help' => 'Inserisci il numero con prefisso internazionale',
      'helper_text' => '',
      'description' => '',
    ),
    'telegram_chat_id' => 
    array (
      'label' => 'Chat ID Telegram',
      'tooltip' => 'ID della chat Telegram del contatto',
      'placeholder' => 'es: 123456789',
      'help' => 'ID numerico fornito dal bot Telegram',
      'helper_text' => '',
      'description' => '',
    ),
    'group' => 
    array (
      'label' => 'Gruppo',
      'tooltip' => 'Gruppo di appartenenza del contatto',
      'placeholder' => 'es: Amministrazione',
      'help' => 'Organizza i contatti in gruppi per facilitarne la gestione',
      'options' => 
      array (
        'admin' => 
        array (
          'label' => 'Amministratori',
          'tooltip' => 'Staff amministrativo',
        ),
        'users' => 
        array (
          'label' => 'Utenti',
          'tooltip' => 'Utenti standard',
        ),
        'support' => 
        array (
          'label' => 'Supporto',
          'tooltip' => 'Team di supporto',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'tooltip' => 'Canali di notifica preferiti',
      'help' => 'Seleziona i canali attraverso cui il contatto desidera ricevere le notifiche',
      'options' => 
      array (
        'email' => 
        array (
          'label' => 'Email',
          'tooltip' => 'Notifiche via email',
        ),
        'sms' => 
        array (
          'label' => 'SMS',
          'tooltip' => 'Notifiche via SMS',
        ),
        'telegram' => 
        array (
          'label' => 'Telegram',
          'tooltip' => 'Notifiche via Telegram',
        ),
        'push' => 
        array (
          'label' => 'Push',
          'tooltip' => 'Notifiche push sul browser',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'preferences' => 
    array (
      'label' => 'Preferenze',
      'tooltip' => 'Preferenze di notifica',
      'help' => 'Configura le preferenze per le notifiche',
      'options' => 
      array (
        'frequency' => 
        array (
          'label' => 'Frequenza',
          'tooltip' => 'Frequenza di invio delle notifiche',
          'options' => 
          array (
            'immediate' => 
            array (
              'label' => 'Immediata',
              'tooltip' => 'Invia le notifiche immediatamente',
            ),
            'daily' => 
            array (
              'label' => 'Giornaliera',
              'tooltip' => 'Raggruppa le notifiche in un digest giornaliero',
            ),
            'weekly' => 
            array (
              'label' => 'Settimanale',
              'tooltip' => 'Raggruppa le notifiche in un digest settimanale',
            ),
          ),
        ),
        'quiet_hours' => 
        array (
          'label' => 'Ore di silenzio',
          'tooltip' => 'Periodo in cui non inviare notifiche',
          'help' => 'Le notifiche verranno inviate al termine del periodo di silenzio',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => 'Stato di attivazione del contatto',
      'help' => 'Disattiva temporaneamente l\'invio di notifiche a questo contatto',
      'helper_text' => '',
      'description' => '',
    ),
    'last_notified_at' => 
    array (
      'label' => 'Ultima notifica',
      'tooltip' => 'Data e ora dell\'ultima notifica inviata',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'test_notification' => 
    array (
      'label' => 'Invia test',
      'tooltip' => 'Invia una notifica di test al contatto',
      'icon' => 'heroicon-o-paper-airplane',
      'color' => 'primary',
      'confirmation' => 
      array (
        'title' => 'Conferma invio test',
        'message' => 'Vuoi inviare una notifica di test a questo contatto?',
        'confirm' => 'Sì, invia test',
        'cancel' => 'No, annulla',
      ),
    ),
    'import' => 
    array (
      'label' => 'Importa contatti',
      'tooltip' => 'Importa contatti da file CSV',
      'icon' => 'heroicon-o-arrow-up-tray',
      'color' => 'success',
    ),
    'export' => 
    array (
      'label' => 'Esporta contatti',
      'tooltip' => 'Esporta contatti in CSV',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'info',
    ),
    'verify_contacts' => 
    array (
      'label' => 'Verifica contatti',
      'tooltip' => 'Verifica la validità dei contatti',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'warning',
    ),
  ),
  'messages' => 
  array (
    'test_sent' => 
    array (
      'title' => 'Test Inviato',
      'message' => 'La notifica di test è stata inviata con successo al contatto',
    ),
    'test_failed' => 
    array (
      'title' => 'Errore Test',
      'message' => 'Impossibile inviare la notifica di test: :error',
    ),
    'import_success' => 
    array (
      'title' => 'Importazione Completata',
      'message' => ':count contatti importati con successo',
    ),
    'import_failed' => 
    array (
      'title' => 'Errore Importazione',
      'message' => 'Errore durante l\'importazione dei contatti: :error',
    ),
    'export_success' => 
    array (
      'title' => 'Esportazione Completata',
      'message' => 'I contatti sono stati esportati con successo',
    ),
    'verification_complete' => 
    array (
      'title' => 'Verifica Completata',
      'message' => 'La verifica dei contatti è stata completata. :valid validi, :invalid non validi',
    ),
  ),
  'filters' => 
  array (
    'group' => 
    array (
      'label' => 'Gruppo',
      'tooltip' => 'Filtra per gruppo di appartenenza',
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'tooltip' => 'Filtra per canali attivi',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Filtra per stato di attivazione',
    ),
    'last_notified' => 
    array (
      'label' => 'Ultima notifica',
      'tooltip' => 'Filtra per data ultima notifica',
    ),
  ),
  'label' => 'Contacts',
  'plural_label' => 'Contacts (Plurale)',
);
