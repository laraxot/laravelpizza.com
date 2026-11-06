<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'model' => [
            'label' => 'Modello di completion',
            'placeholder' => 'gpt-3.5-turbo-instruct',
            'helper_text' => 'Modello usato per generare le previsioni (GeneratePredictionsAction).',
            'tooltip' => '',
            'description' => '',
        ],
        'chat_model' => [
            'label' => 'Modello chat',
            'placeholder' => 'gpt-4o-mini',
            'helper_text' => 'Modello usato per le bozze di previsione (GeneratePredictionDraftsAction).',
            'tooltip' => '',
            'description' => '',
        ],
        'temperature' => [
            'label' => 'Temperatura delle previsioni',
            'placeholder' => '0.7',
            'helper_text' => 'Casualita\' delle previsioni: da 0 (deterministico) a 2.',
            'tooltip' => '',
            'description' => '',
        ],
        'chat_temperature' => [
            'label' => 'Temperatura delle bozze',
            'placeholder' => '0.6',
            'helper_text' => 'Casualita\' delle bozze di previsione: da 0 (deterministico) a 2.',
            'tooltip' => '',
            'description' => '',
        ],
        'max_tokens' => [
            'label' => 'Token massimi per previsione',
            'placeholder' => '1500',
            'helper_text' => 'Lunghezza massima della risposta generata per le previsioni.',
            'tooltip' => '',
            'description' => '',
        ],
        'timeout' => [
            'label' => 'Timeout richieste (secondi)',
            'placeholder' => '30',
            'helper_text' => 'Attesa massima per ogni richiesta di classificazione e suggerimento dei ticket.',
            'tooltip' => '',
            'description' => '',
        ],
        'retry_attempts' => [
            'label' => 'Tentativi per richiesta',
            'placeholder' => '3',
            'helper_text' => 'Quante volte riprovare una richiesta ticket fallita, con attesa crescente tra un tentativo e l\'altro.',
            'tooltip' => '',
            'description' => '',
        ],
        'openai_base_url' => [
            'label' => 'Indirizzo base delle API',
            'placeholder' => 'https://api.openai.com/v1',
            'helper_text' => 'Indirizzo delle API compatibili con OpenAI usate per i ticket, senza barra finale. La chiave API resta nel file .env.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
