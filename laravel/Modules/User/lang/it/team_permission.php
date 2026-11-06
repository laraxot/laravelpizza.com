<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Permesso Team',
        'plural' => 'Permessi Team',
        'label' => 'Permessi Team',
        'group' => ['name' => 'Gestione Utenti', 'description' => 'Gestione permessi specifici per team'],
        'sort' => 15,
        'icon' => 'heroicon-o-shield-check',
    ],
    'fields' => [
        'edit' => ['label' => 'Modifica Permesso Team', 'success' => 'Permesso team aggiornato con successo', 'error' => 'Errore durante l\'aggiornamento del permesso team'],
        'delete' => ['label' => 'Elimina Permesso Team', 'success' => 'Permesso team eliminato con successo', 'error' => 'Errore durante l\'eliminazione del permesso team', 'confirmation' => 'Sei sicuro di voler eliminare questo permesso team?', 'icon' => 'delete', 'tooltip' => 'delete'],
        'createAnother' => ['label' => 'createAnother', 'icon' => 'createAnother', 'tooltip' => 'createAnother'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save'],
    ],
    'label' => 'Team Permission',
    'plural_label' => 'Team Permission (Plurale)',
];
