<?php

declare(strict_types=1);

return [
    'navigation' => ['label' => 'Test SMTP', 'group' => 'Notifiche', 'icon' => 'heroicon-o-envelope-open', 'sort' => 47],
    'label' => 'Test SMTP',
    'plural_label' => 'Test SMTP',
    'fields' => [
        'id' => ['label' => 'ID', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'name' => ['label' => 'Nome', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'host' => ['label' => 'Host', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'host'],
        'port' => ['label' => 'Porta', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'port'],
        'username' => ['label' => 'Nome utente', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'username'],
        'password' => ['label' => 'Password', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'password'],
        'encryption' => ['label' => 'Crittografia', 'tooltip' => '', 'helper_text' => '', 'description' => '', 'placeholder' => 'encryption'],
        'from_address' => ['label' => 'Indirizzo mittente', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'from_name' => ['label' => 'Nome mittente', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'status' => ['label' => 'Stato', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'last_tested_at' => ['label' => 'Ultimo test il', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'created_at' => ['label' => 'Creato il', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'from_email' => ['label' => 'from_email', 'placeholder' => 'from_email', 'helper_text' => 'from_email', 'description' => 'from_email'],
        'from' => ['label' => 'from', 'placeholder' => 'from', 'helper_text' => 'from', 'description' => 'from'],
        'recipient' => ['label' => 'recipient', 'placeholder' => 'recipient', 'helper_text' => 'recipient', 'description' => 'recipient'],
        'subject' => ['label' => 'subject', 'placeholder' => 'subject', 'helper_text' => 'subject', 'description' => 'subject'],
        'body_html' => ['placeholder' => 'body_html']],
    'actions' => [
        'send_test_email' => ['label' => 'Invia email di test'],
        'test_connection' => ['label' => 'Test connessione'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save']],
    'sections' => [
        'SMTP' => ['label' => 'SMTP', 'heading' => 'SMTP'],
        'MAIL' => ['label' => 'MAIL', 'heading' => 'MAIL']]];
