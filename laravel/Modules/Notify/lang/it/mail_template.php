<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Template Email',
    'plural' => 'Template Email',
  ),
  'navigation' => 
  array (
    'name' => 'Template Email',
    'plural' => 'Template Email',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche email e dei relativi template',
    ),
    'label' => 'Template Email',
    'icon' => 'heroicon-o-envelope',
    'sort' => 1,
  ),
  'sections' => 
  array (
    'main' => 'Informazioni Principali',
    'content' => 'Contenuto',
    'styling' => 'Stile',
    'settings' => 'Impostazioni',
    'variables' => 'Variabili',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'helper_text' => 'Identificativo univoco del template',
      'tooltip' => '',
      'description' => '',
    ),
    'mailable' => 
    array (
      'label' => 'Classe Mailable',
      'helper_text' => 'Classe PHP che gestisce l\'invio dell\'email',
      'placeholder' => 'es: App\\Mail\\WelcomeEmail',
      'description' => 'mailable',
      'tooltip' => '',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'helper_text' => 'Oggetto dell\'email',
      'placeholder' => 'Inserisci l\'oggetto dell\'email',
      'description' => 'subject',
      'tooltip' => '',
    ),
    'html_template' => 
    array (
      'label' => 'Template HTML',
      'helper_text' => 'Contenuto HTML del template email',
      'placeholder' => 'Inserisci il codice HTML',
      'description' => 'html_template',
      'tooltip' => '',
    ),
    'text_template' => 
    array (
      'label' => 'Template Testo',
      'helper_text' => 'Versione testuale del template email',
      'placeholder' => 'Inserisci la versione testuale',
      'description' => 'text_template',
      'tooltip' => '',
    ),
    'from_email' => 
    array (
      'label' => 'Email mittente',
      'helper_text' => 'Indirizzo email del mittente',
      'placeholder' => 'noreply@example.com',
      'tooltip' => '',
      'description' => '',
    ),
    'from_name' => 
    array (
      'label' => 'Nome mittente',
      'helper_text' => 'Nome visualizzato del mittente',
      'placeholder' => 'Nome Azienda',
      'tooltip' => '',
      'description' => '',
    ),
    'variables' => 
    array (
      'label' => 'Variabili disponibili',
      'helper_text' => 'Elenco delle variabili che possono essere utilizzate nel template',
      'placeholder' => 'es: {{name}}, {{email}}',
      'tooltip' => '',
      'description' => '',
    ),
    'is_markdown' => 
    array (
      'label' => 'Usa Markdown',
      'helper_text' => 'Indica se il template utilizza la sintassi Markdown',
      'tooltip' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'helper_text' => 'Stato attuale del template',
      'tooltip' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data creazione',
      'helper_text' => 'Data di creazione del template',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima modifica',
      'helper_text' => 'Data dell\'ultima modifica del template',
      'tooltip' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'layout',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'slug',
      'description' => 'slug',
      'helper_text' => 'slug',
      'placeholder' => 'slug',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'description' => 'Nome del template',
      'helper_text' => 'Nome descrittivo per identificare il template',
      'placeholder' => 'Es: Benvenuto, Conferma ordine, Reset password',
      'label' => 'Nome Template',
      'tooltip' => '',
    ),
    'params' => 
    array (
      'label' => 'Parametri',
      'helper_text' => 'Inserisci i parametri separati da virgola che possono essere utilizzati nel template',
      'placeholder' => 'name, email, date, company',
      'description' => 'Parametri disponibili per il template email',
      'tooltip' => '',
    ),
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'sms_template' => 
    array (
      'description' => 'sms_template',
      'helper_text' => 'sms_template',
      'placeholder' => 'sms_template',
      'label' => 'sms_template',
      'tooltip' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'view',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'create' => 
    array (
      'label' => 'create',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'counter' => 
    array (
      'label' => 'counter',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'html_layout_path' => 
    array (
      'description' => 'html_layout_path',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'preview' => 
    array (
      'label' => 'Anteprima',
      'tooltip' => 'Visualizza anteprima dell\'email',
      'success_message' => 'Anteprima generata con successo',
      'error_message' => 'Errore nella generazione dell\'anteprima',
    ),
    'test' => 
    array (
      'label' => 'Invia test',
      'tooltip' => 'Invia un\'email di test',
      'success_message' => 'Email di test inviata con successo',
      'error_message' => 'Errore nell\'invio dell\'email di test',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica',
      'tooltip' => 'Crea una copia del template',
      'success_message' => 'Template duplicato con successo',
      'error_message' => 'Errore nella duplicazione del template',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta il template in formato JSON',
      'success_message' => 'Template esportato con successo',
      'error_message' => 'Errore nell\'esportazione del template',
    ),
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa un template da un file JSON',
      'success_message' => 'Template importato con successo',
      'error_message' => 'Errore nell\'importazione del template',
    ),
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
    'template_created' => 'Il template email è stato creato con successo',
    'template_updated' => 'Il template email è stato aggiornato con successo',
    'template_deleted' => 'Il template email è stato eliminato con successo',
  ),
  'status' => 
  array (
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'failed' => 'Fallita',
    'opened' => 'Aperta',
    'clicked' => 'Cliccata',
    'bounced' => 'Respinta',
    'spam' => 'Segnalata come spam',
  ),
  'model' => 
  array (
    'label' => 'mail template.model',
  ),
  'label' => 'Mail Template',
  'plural_label' => 'Mail Template (Plurale)',
);
