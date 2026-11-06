<?php

declare(strict_types=1);

// Testi della mail di verifica indirizzo (template database `verify-email`, Notify/SpatieEmail).
return [
    'subject' => 'Conferma il tuo indirizzo email',
    'greeting' => 'Gentile {{ first_name }} {{ last_name }},',
    'intro' => 'grazie per esserti registrato su FixCity. Conferma il tuo indirizzo email per attivare l\'account.',
    'action' => 'Conferma email',
    'fallback' => 'Se il pulsante non funziona, copia questo indirizzo nel browser:',
    'ignore' => 'Se non hai creato tu l\'account, puoi ignorare questo messaggio.',
];
