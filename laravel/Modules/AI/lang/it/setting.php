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
        'free_models_only' => [
            'label' => 'Solo modelli gratuiti',
            'placeholder' => '',
            'helper_text' => 'Se attivo, i modelli a pagamento vengono scartati prima di ogni chiamata (OpenRouter: solo :free e openrouter/free).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_providers' => [
            'label' => 'Fornitori per le immagini',
            'placeholder' => '',
            'helper_text' => 'In ordine: se il primo non risponde si prova il successivo (groq, openrouter).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_models' => [
            'label' => 'Modelli per le immagini',
            'placeholder' => '',
            'helper_text' => 'Per fornitore; più modelli separati da virgola (OpenRouter li prova in ordine).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_timeout' => [
            'label' => 'Timeout immagini (secondi)',
            'placeholder' => '',
            'helper_text' => 'Attesa massima per leggere una foto.',
            'tooltip' => '',
            'description' => '',
        ],
        'image_model' => [
            'label' => 'Modello per modificare immagini',
            'placeholder' => '',
            'helper_text' => 'Solo OpenRouter. Nessun modello gratuito genera immagini.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_providers' => [
            'label' => 'Fornitori dell\'assistente',
            'placeholder' => '',
            'helper_text' => 'In ordine: se il primo non risponde si prova il successivo.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_models' => [
            'label' => 'Modelli dell\'assistente',
            'placeholder' => '',
            'helper_text' => 'Modello di testo per fornitore.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_timeout' => [
            'label' => 'Timeout assistente (secondi)',
            'placeholder' => '',
            'helper_text' => 'Attesa massima di una risposta in chat.',
            'tooltip' => '',
            'description' => '',
        ],
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
            'helper_text' => 'Casualità delle previsioni: da 0 (deterministico) a 2.',
            'tooltip' => '',
            'description' => '',
        ],
        'chat_temperature' => [
            'label' => 'Temperatura delle bozze',
            'placeholder' => '0.6',
            'helper_text' => 'Casualità delle bozze di previsione: da 0 (deterministico) a 2.',
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
        'add' => [
            'label' => 'add',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'reorder' => [
            'label' => 'reorder',
        ],
    ],
];
