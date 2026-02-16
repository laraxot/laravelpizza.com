<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Template Notifiche',
    'plural' => 'Template Notifiche',
  ),
  'navigation' => 
  array (
    'name' => 'Template Notifiche',
    'plural' => 'Template Notifiche',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei modelli per le notifiche',
    ),
    'label' => 'Template Notifiche',
    'icon' => 'notify-template-animated',
    'sort' => '48',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome identificativo del template',
      'placeholder' => 'es: Notifica Scadenza',
      'helper_text' => 'Inserisci un nome descrittivo per il template',
      'help' => 'Inserisci un nome descrittivo per il template',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Descrizione del template',
      'placeholder' => 'es: Template per le notifiche di scadenza',
      'helper_text' => 'Breve descrizione dello scopo del template',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Tipologia di notifica',
      'placeholder' => 'Seleziona il tipo di notifica',
      'helper_text' => 'Il tipo determina il canale di invio della notifica',
      'options' => 
      array (
        'email' => 'Email',
        'sms' => 'SMS',
        'push' => 'Notifica Push',
        'telegram' => 'Telegram',
        'whatsapp' => 'WhatsApp',
      ),
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'tooltip' => 'Oggetto della notifica',
      'placeholder' => 'es: Promemoria appuntamento',
      'helper_text' => 'Oggetto visualizzato nella notifica (es. oggetto email)',
      'description' => '',
    ),
    'content' => 
    array (
      'label' => 'Contenuto',
      'tooltip' => 'Corpo del messaggio',
      'placeholder' => 'Inserisci il testo del messaggio',
      'helper_text' => 'Contenuto principale della notifica',
      'description' => '',
    ),
    'variables' => 
    array (
      'label' => 'Variabili',
      'tooltip' => 'Variabili disponibili',
      'placeholder' => '{{nome}}, {{email}}, ecc.',
      'helper_text' => 'Variabili che possono essere utilizzate nel template',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => 'Stato del template',
      'helper_text' => 'Se attivo, il template può essere utilizzato per l\'invio di notifiche',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data creazione',
      'tooltip' => 'Data di creazione del template',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima modifica',
      'tooltip' => 'Data dell\'ultima modifica del template',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'preview' => 
    array (
      'label' => 'Anteprima',
      'tooltip' => 'Visualizza anteprima del template',
      'icon' => 'heroicon-o-eye',
      'success_message' => 'Anteprima generata con successo',
      'error_message' => 'Errore nella generazione dell\'anteprima',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica',
      'tooltip' => 'Crea una copia del template',
      'icon' => 'heroicon-o-document-duplicate',
      'success_message' => 'Template duplicato con successo',
      'error_message' => 'Errore nella duplicazione del template',
    ),
    'test' => 
    array (
      'label' => 'Test',
      'tooltip' => 'Invia una notifica di test',
      'icon' => 'heroicon-o-paper-airplane',
      'success_message' => 'Notifica di test inviata con successo',
      'error_message' => 'Errore nell\'invio della notifica di test',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
    'template_created' => 'Il template è stato creato con successo',
    'template_updated' => 'Il template è stato aggiornato con successo',
    'template_deleted' => 'Il template è stato eliminato con successo',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
