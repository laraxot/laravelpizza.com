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
    ],
];
