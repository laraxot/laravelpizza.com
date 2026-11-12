<?php

declare(strict_types=1);

/*
 * Alias di pagina di LaravelPizza (Modules\Seo\Datas\SeoConfigData).
 * I default del modulo vengono da Fixcity (about => chi-siamo, contatti => contacts, ...): qui le pagine si chiamano
 * `about` e `contact`, e l'alias predefinito mandava /it/about a /it/chi-siamo, che non esiste (404).
 */
return [
    'path_aliases' => [
        ['alias' => 'chi-siamo', 'target' => 'about'],
        ['alias' => 'contatti', 'target' => 'contact'],
        ['alias' => 'contacts', 'target' => 'contact'],
        ['alias' => 'home', 'target' => ''],
        // "Eventi vicini" non e' mai stato attivo (nessuna geolocalizzazione): la ricerca per citta' sta in /events.
        ['alias' => 'events-near-me', 'target' => 'events'],
        // Il blog non esiste: /articles era una copia vuota dell'elenco eventi.
        ['alias' => 'articles', 'target' => 'events'],
        // Vecchi indirizzi delle sotto-pagine (file piatti events-my.json/events-past.json, ora pages/events/my.json e past.json)
        ['alias' => 'events-my', 'target' => 'events/my'],
        ['alias' => 'events-past', 'target' => 'events/past'],
        // Indirizzi "a orecchio": le pagine di accesso stanno sotto /auth.
        ['alias' => 'login', 'target' => 'auth/login'],
        ['alias' => 'register', 'target' => 'auth/register'],
    ],
];
