<?php

declare(strict_types=1);

// Testi della mail di reimpostazione password (template database `reset-password`, creato da EnsureResetPasswordMailTemplateAction).
return [
    'subject' => 'Passwort zurücksetzen',
    'greeting' => 'Guten Tag,',
    'intro' => 'Wir haben eine Anfrage zum Zurücksetzen des Passworts für Ihr :app-Konto erhalten. Wählen Sie über die Schaltfläche unten ein neues Passwort.',
    'action' => 'Passwort zurücksetzen',
    'fallback' => 'Falls die Schaltfläche nicht funktioniert, kopieren Sie diese Adresse in Ihren Browser:',
    'ignore' => 'Wenn Sie das Zurücksetzen nicht angefordert haben, können Sie diese Nachricht ignorieren: Ihr Passwort bleibt unverändert.',
];
