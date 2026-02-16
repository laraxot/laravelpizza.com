<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche email e dei relativi template',
    ),
    'label' => 'Email Templates',
    'plural' => 'Email Templates',
    'singular' => 'Email Template',
    'icon' => 'heroicon-o-envelope',
    'sort' => '1',
    'name' => 'Template Email',
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
      'label' => 'Mailable Class',
      'placeholder' => 'Enter the Mailable class name',
      'help' => 'The PHP class that handles email sending',
      'helper_text' => 'Classe PHP che gestisce l\'invio dell\'email',
      'description' => 'mailable',
      'tooltip' => '',
    ),
    'subject' => 
    array (
      'label' => 'Subject',
      'placeholder' => 'Enter the email subject',
      'help' => 'The subject that will appear in the email',
      'helper_text' => 'Oggetto dell\'email',
      'description' => 'subject',
      'tooltip' => '',
    ),
    'html_template' => 
    array (
      'label' => 'HTML Content',
      'placeholder' => 'Enter the email HTML content',
      'help' => 'The email content in HTML format',
      'helper_text' => 'Contenuto HTML del template email',
      'description' => 'html_template',
      'tooltip' => '',
    ),
    'text_template' => 
    array (
      'label' => 'Text Content',
      'placeholder' => 'Enter the email text content',
      'help' => 'Text version of the email for clients that don\'t support HTML',
      'helper_text' => 'Versione testuale del template email',
      'description' => 'text_template',
      'tooltip' => '',
    ),
    'version' => 
    array (
      'label' => 'Version',
      'help' => 'Template version number',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'helper_text' => 'Data di creazione del template',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Modified',
      'helper_text' => 'Data dell\'ultima modifica del template',
      'tooltip' => '',
      'description' => '',
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
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Search templates...',
    'version' => 
    array (
      'label' => 'Version',
      'placeholder' => 'Select version',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Template',
      'modal' => 
      array (
        'heading' => 'Create Email Template',
        'description' => 'Enter the details for the new email template',
        'submit' => 'Create',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'modal' => 
      array (
        'heading' => 'Edit Email Template',
        'description' => 'Modify the email template details',
        'submit' => 'Save',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'modal' => 
      array (
        'heading' => 'Delete Email Template',
        'description' => 'Are you sure you want to delete this template? This action cannot be undone.',
        'submit' => 'Delete',
      ),
    ),
    'restore' => 
    array (
      'label' => 'Restore',
    ),
    'force_delete' => 
    array (
      'label' => 'Force Delete',
      'modal' => 
      array (
        'heading' => 'Force Delete Email Template',
        'description' => 'Are you sure you want to permanently delete this template? This action cannot be undone.',
        'submit' => 'Force Delete',
      ),
    ),
    'new_version' => 
    array (
      'label' => 'New Version',
      'modal' => 
      array (
        'heading' => 'Create New Version',
        'description' => 'Create a new version of the email template',
        'submit' => 'Create Version',
      ),
    ),
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
  ),
  'messages' => 
  array (
    'created' => 'Email template created successfully.',
    'updated' => 'Email template updated successfully.',
    'deleted' => 'Email template deleted successfully.',
    'restored' => 'Email template restored successfully.',
    'force_deleted' => 'Email template permanently deleted.',
    'version_created' => 'New template version created successfully.',
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
    'template_created' => 'Il template email è stato creato con successo',
    'template_updated' => 'Il template email è stato aggiornato con successo',
    'template_deleted' => 'Il template email è stato eliminato con successo',
  ),
  'sections' => 
  array (
    'template' => 
    array (
      'label' => 'Template',
      'description' => 'Main template information',
    ),
    'versions' => 
    array (
      'label' => 'Versions',
      'description' => 'Template version history',
    ),
    'logs' => 
    array (
      'label' => 'Logs',
      'description' => 'Template sending history',
    ),
    'main' => 'Informazioni Principali',
    'content' => 'Contenuto',
    'styling' => 'Stile',
    'settings' => 'Impostazioni',
    'variables' => 'Variabili',
  ),
  'resource' => 
  array (
    'name' => 'Template Email',
    'plural' => 'Template Email',
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
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
