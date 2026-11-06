<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => 'Konfiguration speichern',
    ],
    'help' => [
        'title' => 'Konfigurationsanleitung',
        'description' => 'Konfigurieren Sie die OAuth-Zugangsdaten der Anbieter, damit sich Benutzer mit ihren Social-Media-Konten anmelden können.',
        'google_title' => 'Google OAuth',
        'google_step1' => 'Öffnen Sie die <a href=":url" target="_blank" rel="noopener" class="underline">Google Cloud Console</a> und erstellen Sie ein Projekt (oder wählen Sie ein vorhandenes aus).',
        'google_step2' => 'Aktivieren Sie die erforderlichen APIs und konfigurieren Sie den OAuth-Zustimmungsbildschirm.',
        'google_step3' => 'Erstellen Sie Zugangsdaten vom Typ „OAuth-Client-ID“ für eine Webanwendung.',
        'google_step4' => 'Kopieren Sie die Client-ID und das Client-Geheimnis und fügen Sie sie in das obige Formular ein.',
        'redirect_url_note' => 'Weiterleitungs-URL',
        'redirect_url_description' => 'Legen Sie die im Formular angezeigte Callback-URL als autorisierten Weiterleitungs-URI fest.',
    ],
    'security' => [
        'title' => 'Sicherheitshinweis',
        'description' => 'Die Zugangsdaten werden sicher gespeichert. Geben Sie sie nicht weiter und tragen Sie sie niemals in öffentliche Repositories ein.',
    ],
];
