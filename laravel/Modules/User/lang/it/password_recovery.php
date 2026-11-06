<?php

declare(strict_types=1);

/*
 * Pagine "password dimenticata" e "nuova password" del front office (DCP-290).
 * Il messaggio `sent` e' lo stesso per un indirizzo registrato e per uno sconosciuto: nessuna enumerazione degli account.
 */
return [
    'title' => 'Password dimenticata',
    'intro' => 'Scrivi l’indirizzo email con cui ti sei registrato. Ti invieremo un link per scegliere una nuova password.',
    'submit' => 'Invia il link',
    'sent' => 'Se l’indirizzo è registrato, riceverai a breve un’email con il link per scegliere una nuova password. Controlla anche la cartella dello spam.',
    'back_to_login' => 'Torna all’accesso',
    'reset_title' => 'Scegli una nuova password',
    'reset_intro' => 'Scrivi la nuova password due volte. Poi potrai accedere con la nuova password.',
    'reset_submit' => 'Salva la nuova password',
    'reset_done' => 'La password è stata cambiata. Accedi con la nuova password.',
    'invalid_link' => 'Il link non è valido o è scaduto. Richiedine uno nuovo.',
    'request_new' => 'Richiedi un nuovo link',
    'sending' => 'Invio in corso…',
    'saving' => 'Salvataggio in corso…',
];
