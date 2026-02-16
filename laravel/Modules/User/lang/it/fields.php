<?php

declare(strict_types=1);

return [
    'name' => 'Nome',
    'slug' => 'Slug',
    'email' => 'Email',
    'created_at' => 'Creato il',
    'updated_at' => 'Aggiornato il',
    'role' => 'Ruolo',
    'id.label' => 'ID',
    'name.label' => 'Nome',
    'slug.label' => 'Slug',
    'actions' => [
        'attach_user' => 'Attacca utente',
    ],
    'new_password' => [
        'label' => 'Nuova Password',
        'placeholder' => 'Inserisci la tua nuova password',
    ],
    'confirm_password' => [
        'label' => 'Conferma Password',
        'placeholder' => 'Conferma la tua nuova password',
    ],
    'navigation' => [
        'name' => 'Fields',
        'plural' => 'Fields',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Fields',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Fields',
    'plural_label' => 'Fields (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
];
