<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Enter template name',
      'help' => 'The identifying name of the template',
      'tooltip' => 'This field is required',
      'helper_text' => 'Inserisci un nome descrittivo per il template',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Subject',
      'placeholder' => 'Enter notification subject',
      'help' => 'The subject that will appear in the notification',
      'tooltip' => 'This field is required',
      'helper_text' => 'Oggetto visualizzato nella notifica (es. oggetto email)',
      'description' => '',
    ),
    'body_text' => 
    array (
      'label' => 'Text',
      'placeholder' => 'Enter notification text',
      'help' => 'The text content of the notification',
      'tooltip' => 'This field is required',
      'helper_text' => '',
      'description' => '',
    ),
    'body_html' => 
    array (
      'label' => 'HTML',
      'placeholder' => 'Enter notification HTML content',
      'help' => 'The HTML content of the notification',
      'tooltip' => 'This field is required',
      'helper_text' => '',
      'description' => '',
    ),
    'preview_data' => 
    array (
      'label' => 'Preview Data',
      'placeholder' => 'Enter preview data',
      'help' => 'The data used to display the preview',
      'tooltip' => 'JSON format',
      'helper_text' => '',
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
  'navigation' => 
  array (
    'label' => 'Notification Templates',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei modelli per le notifiche',
    ),
    'icon' => 'heroicon-o-bell',
    'name' => 'Template Notifiche',
    'plural' => 'Template Notifiche',
    'sort' => '48',
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Template created successfully',
      'updated' => 'Template updated successfully',
      'deleted' => 'Template deleted successfully',
    ),
    'errors' => 
    array (
      'not_found' => 'Template not found',
      'unauthorized' => 'Unauthorized',
    ),
    'error' => 'Si è verificato un errore durante l\'operazione',
    'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
    'template_created' => 'Il template è stato creato con successo',
    'template_updated' => 'Il template è stato aggiornato con successo',
    'template_deleted' => 'Il template è stato eliminato con successo',
  ),
  'resource' => 
  array (
    'name' => 'Template Notifiche',
    'plural' => 'Template Notifiche',
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
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
