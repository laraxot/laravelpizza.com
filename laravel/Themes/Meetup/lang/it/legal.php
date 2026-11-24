<?php

declare(strict_types=1);

// Riquadri laterali delle pagine legali (blocco legal/article: privacy, termini).
// Entrambe le famiglie di chiavi restano: `contacts`/`note` (root) e `article.*` (pacchetto annidato, l'unica che es/de traducono).
return [
    'contacts' => [
        'title' => 'Contatti',
        'intro' => 'Per richieste legali, privacy o contenuti del sito puoi scrivere ai riferimenti qui sotto.',
    ],
    'note' => [
        'title' => 'Nota',
        'body' => 'Queste pagine descrivono le regole e le informazioni principali del servizio Laravel Pizza. Se hai bisogno di chiarimenti specifici, contattaci prima di partecipare a un evento o di condividere dati personali.',
    ],
    'article' => [
        'contact_intro' => [
            'message' => 'Per richieste legali, privacy o contenuti del sito puoi scrivere ai riferimenti qui sotto.',
        ],
        'note' => [
            'title' => 'Nota',
            'message' => 'Queste pagine descrivono le regole e le informazioni principali del servizio Laravel Pizza. Se hai bisogno di chiarimenti specifici, contattaci prima di partecipare a un evento o di condividere dati personali.',
        ],
    ],
];
