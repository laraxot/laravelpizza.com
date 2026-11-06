<?php

declare(strict_types=1);

// Testi della mail di reimpostazione password (template database `reset-password`, creato da EnsureResetPasswordMailTemplateAction).
return [
    'subject' => 'Reimposta la tua password',
    'greeting' => 'Gentile utente,',
    'intro' => 'Abbiamo ricevuto una richiesta di reimpostazione della password per il tuo account su :app. Usa il pulsante qui sotto per sceglierne una nuova.',
    'action' => 'Reimposta la password',
    'fallback' => 'Se il pulsante non funziona, copia questo indirizzo nel browser:',
    'ignore' => 'Se non hai richiesto tu la reimpostazione, puoi ignorare questo messaggio: la tua password non cambia.',
];
