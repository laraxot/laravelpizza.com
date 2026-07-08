<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Naam',
            'placeholder' => 'Voer naam in',
            'help' => 'Identificerende naam van het element',
            'description' => 'Objectnaam',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'edit-name' => [
            'label' => 'Naam bewerken',
            'placeholder' => 'Nieuwe naam',
            'help' => 'Bestaande naam wijzigen',
            'description' => 'Actie om de naam te wijzigen',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'change-state' => [
            'label' => 'Status wijzigen',
            'placeholder' => 'Selecteer nieuwe status',
            'help' => 'Huidige status wijzigen',
            'description' => 'Actie om de status te wijzigen',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'Status',
            'placeholder' => 'Selecteer een status',
            'help' => 'Huidige status van het element',
            'description' => 'Huidige systeemconditie',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Bericht',
            'placeholder' => 'Voer een bericht in',
            'help' => 'Informatief bericht',
            'description' => 'Berichttekst',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Ongeldige statusinstantie',
        'record_not_found' => 'Record niet gevonden',
        'transition_completed' => [
            'title' => 'Overgang voltooid',
            'body' => 'Statusovergang is succesvol voltooid',
        ],
        'transition_error' => [
            'title' => 'Overgangsfout',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
