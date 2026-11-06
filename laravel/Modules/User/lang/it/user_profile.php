<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_profile.php
return [
    'profile' => [
        'profile' => 'Profilo',
        'my_profile' => 'Il Mio Profilo',
        'subheading' => 'Gestisci le informazioni del tuo profilo',
        'edit_profile' => 'Modifica Profilo',
        'change_password' => 'Cambia Password',
        'personal_info' => 'Informazioni Personali',
        'security' => 'Sicurezza',
        'notifications' => 'Notifiche',
        'preferences' => 'Preferenze',
    ],
];
