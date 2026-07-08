<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Profilo',
        'plural' => 'Profili',
        'group' => [
            'name' => 'Content',
        ],
        'sort' => 56,
        'icon' => 'heroicon-o-user',
        'label' => 'Profilo',
    ],
    'fields' => [
        'type' => 'Tipo',
        'name' => 'Nome',
        'guard_name' => 'Guard',
        'permissions' => 'Permessi',
        'roles' => 'Ruoli',
        'updated_at' => 'Aggiornato il',
        'user_name' => 'Nome Utente',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'email',
        'is_active' => 'attivo ?',
    ],
    'setting' => [
        'date' => 'Data',
        'action' => 'Azione',
        'market' => 'Articolo',
        'outcome' => 'Ammontare',
        'option' => 'Opzione',
        'welcome' => 'Regalo di benvenuto',
        'rating_article' => 'Scommessa effettuata',
        'rating_article_winner' => 'Vincente',
        'admin_add_credit_to_profile' => 'Aggiunta crediti dall\'amministratore',
        'admin_remove_credit_to_profile' => 'Sottrazione crediti dall\'amministratore',
    ],
];
