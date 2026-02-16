<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Canale di Notifica',
  ),
  'navigation' => 
  array (
    'group' => 'Sistema',
    'label' => 'Canali di Notifica',
    'icon' => 'notify-channel-animated',
    'sort' => '47',
    'description' => 'Gestione dei canali di comunicazione per le notifiche',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome identificativo del canale',
      'placeholder' => 'es: Email Marketing',
      'help' => 'Inserisci un nome univoco per identificare il canale',
      'helper_text' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Driver',
      'tooltip' => 'Tipo di servizio utilizzato per l\'invio',
      'help' => 'Seleziona il driver appropriato per questo canale',
      'options' => 
      array (
        'mail' => 
        array (
          'label' => 'Email',
          'tooltip' => 'Invio tramite server SMTP',
        ),
        'database' => 
        array (
          'label' => 'Database',
          'tooltip' => 'Salvataggio nel database',
        ),
        'broadcast' => 
        array (
          'label' => 'Broadcast',
          'tooltip' => 'Invio tramite websocket',
        ),
        'sms' => 
        array (
          'label' => 'SMS',
          'tooltip' => 'Invio tramite gateway SMS',
        ),
        'telegram' => 
        array (
          'label' => 'Telegram',
          'tooltip' => 'Invio tramite bot Telegram',
        ),
        'slack' => 
        array (
          'label' => 'Slack',
          'tooltip' => 'Invio tramite webhook Slack',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'configuration' => 
    array (
      'label' => 'Configurazione',
      'tooltip' => 'Parametri di configurazione del canale',
      'help' => 'Configura i parametri necessari per il funzionamento del canale',
      'options' => 
      array (
        'host' => 
        array (
          'label' => 'Host',
          'tooltip' => 'Indirizzo del server',
          'placeholder' => 'es: smtp.gmail.com',
        ),
        'port' => 
        array (
          'label' => 'Porta',
          'tooltip' => 'Porta di connessione',
          'placeholder' => 'es: 587',
        ),
        'username' => 
        array (
          'label' => 'Username',
          'tooltip' => 'Nome utente per l\'autenticazione',
          'placeholder' => 'es: user@example.com',
        ),
        'password' => 
        array (
          'label' => 'Password',
          'tooltip' => 'Password per l\'autenticazione',
          'help' => 'La password verrà criptata prima del salvataggio',
        ),
        'encryption' => 
        array (
          'label' => 'Crittografia',
          'tooltip' => 'Metodo di crittografia',
          'options' => 
          array (
            'tls' => 
            array (
              'label' => 'TLS',
              'tooltip' => 'Transport Layer Security',
            ),
            'ssl' => 
            array (
              'label' => 'SSL',
              'tooltip' => 'Secure Sockets Layer',
            ),
          ),
        ),
        'from_address' => 
        array (
          'label' => 'Indirizzo mittente',
          'tooltip' => 'Indirizzo email del mittente',
          'placeholder' => 'es: noreply@example.com',
        ),
        'from_name' => 
        array (
          'label' => 'Nome mittente',
          'tooltip' => 'Nome visualizzato del mittente',
          'placeholder' => 'es: Sistema Notifiche',
        ),
        'api_key' => 
        array (
          'label' => 'API Key',
          'tooltip' => 'Chiave API per l\'autenticazione',
          'help' => 'Chiave fornita dal servizio per l\'autenticazione',
        ),
        'api_secret' => 
        array (
          'label' => 'API Secret',
          'tooltip' => 'Chiave segreta API',
          'help' => 'Non condividere mai questa chiave',
        ),
        'bot_token' => 
        array (
          'label' => 'Token Bot',
          'tooltip' => 'Token del bot Telegram',
          'help' => 'Ottieni il token da @BotFather su Telegram',
        ),
        'chat_id' => 
        array (
          'label' => 'ID Chat',
          'tooltip' => 'ID della chat Telegram',
          'help' => 'ID del gruppo o canale Telegram',
        ),
        'webhook_url' => 
        array (
          'label' => 'URL Webhook',
          'tooltip' => 'URL per le chiamate webhook',
          'placeholder' => 'es: https://hooks.slack.com/services/...',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'is_default' => 
    array (
      'label' => 'Predefinito',
      'tooltip' => 'Imposta come canale predefinito',
      'help' => 'Il canale predefinito verrà utilizzato quando non specificato diversamente',
      'helper_text' => '',
      'description' => '',
    ),
    'is_enabled' => 
    array (
      'label' => 'Abilitato',
      'tooltip' => 'Stato di attivazione del canale',
      'help' => 'Disabilita temporaneamente il canale senza eliminarlo',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'test_connection' => 
    array (
      'label' => 'Testa connessione',
      'tooltip' => 'Verifica la configurazione del canale',
      'icon' => 'heroicon-o-signal',
      'color' => 'info',
    ),
    'send_test' => 
    array (
      'label' => 'Invia test',
      'tooltip' => 'Invia un messaggio di test',
      'icon' => 'heroicon-o-paper-airplane',
      'color' => 'primary',
      'confirmation' => 
      array (
        'title' => 'Conferma test',
        'message' => 'Vuoi inviare un messaggio di test?',
        'confirm' => 'Sì, invia',
        'cancel' => 'No, annulla',
      ),
    ),
  ),
  'messages' => 
  array (
    'connection_success' => 
    array (
      'title' => 'Connessione Riuscita',
      'message' => 'La connessione al canale è stata stabilita con successo',
    ),
    'connection_failed' => 
    array (
      'title' => 'Errore di Connessione',
      'message' => 'Impossibile connettersi al canale: :error',
    ),
    'test_sent' => 
    array (
      'title' => 'Test Inviato',
      'message' => 'Il messaggio di test è stato inviato con successo',
    ),
    'test_failed' => 
    array (
      'title' => 'Errore Test',
      'message' => 'Impossibile inviare il messaggio di test: :error',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
