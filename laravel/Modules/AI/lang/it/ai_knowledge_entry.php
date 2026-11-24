<?php

declare(strict_types=1);

return [
    'label' => 'Voce della base di conoscenza',
    'plural_label' => 'Base di conoscenza',
    'navigation' => ['group' => 'Assistente AI', 'label' => 'Base di conoscenza'],
    'fields' => [
        'id' => ['label' => 'ID'],
        'section' => ['label' => 'Domanda e risposta'],
        'collection' => ['label' => 'Raccolta', 'helper_text' => 'Identifica il progetto o il cliente (es. fixcity-faq).'],
        'question' => ['label' => 'Domanda tipo'],
        'answer' => ['label' => 'Risposta ufficiale', 'helper_text' => "L'assistente risponde solo con queste informazioni: tienile aggiornate."],
        'tags' => ['label' => 'Parole chiave'],
        'is_active' => ['label' => 'Attiva'],
        'updated_at' => ['label' => 'Aggiornata il'],
    ],
];
