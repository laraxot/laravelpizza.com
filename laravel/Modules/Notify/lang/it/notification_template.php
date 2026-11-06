<?php

declare(strict_types=1);

return [
    'navigation' => ['icon' => 'heroicon-o-document-text', 'label' => 'Template Notifiche', 'group' => 'Sistema', 'sort' => 52],
    'fields' => [
        'name' => ['label' => 'Nome', 'helper' => 'Nome univoco del template', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'name'],
        'subject' => ['label' => 'Oggetto', 'helper' => 'Oggetto della notifica', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'subject'],
        'type' => ['label' => 'Tipo', 'helper' => 'Tipo di notifica', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'type'],
        'body_text' => ['label' => 'Testo Semplice', 'helper' => 'Versione testo semplice della notifica', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'body_text'],
        'body_html' => ['label' => 'HTML', 'helper' => 'Versione HTML della notifica', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'body_html'],
        'preview_data' => ['label' => 'Dati di Anteprima', 'helper' => 'Dati JSON per l\'anteprima', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'preview_data'],
        'resetFilters' => ['label' => 'resetFilters', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'applyFilters' => ['label' => 'applyFilters', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'attachments' => ['label' => 'attachments', 'placeholder' => 'attachments', 'helper_text' => 'attachments', 'description' => 'attachments']],
    'columns' => ['name' => 'Nome', 'subject' => 'Oggetto', 'type' => 'Tipo', 'created_at' => 'Creato il', 'updated_at' => 'Aggiornato il'],
    'actions' => [
        'preview' => 'Anteprima',
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'createAnother' => ['label' => 'createAnother', 'icon' => 'createAnother', 'tooltip' => 'createAnother'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit']],
    'enums' => [
        'notification_type' => ['email' => 'Email', 'sms' => 'SMS', 'push' => 'Notifica Push']],
    'label' => 'Notification Template',
    'plural_label' => 'Notification Template (Plurale)'];
