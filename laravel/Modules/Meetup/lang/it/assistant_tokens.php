<?php

declare(strict_types=1);

// Pagina "Collega un assistente AI" (Http/Livewire/AssistantTokens, livewire/assistant-tokens.blade.php).
return [
    'intro' => 'Con un token personale Claude, Cursor e gli altri assistenti compatibili con MCP possono cercare i meetup e iscriverti a tuo nome, con le stesse regole del sito.',
    'server' => [
        'title' => 'Indirizzo del server',
        'help' => 'Nel tuo assistente aggiungi un server MCP di tipo HTTP con questo indirizzo e il token come intestazione Authorization: Bearer.',
    ],
    'create' => [
        'title' => 'Nuovo token',
        'description' => 'Dai al token il nome dell\'assistente o del computer dove lo usi: così sai cosa revocare.',
        'submit' => 'Crea il token',
    ],
    'fields' => [
        'name' => 'Nome del token',
    ],
    'placeholders' => [
        'name' => 'Es. Claude sul portatile',
    ],
    'created' => [
        'title' => 'Token creato: copialo adesso',
        'warning' => 'Per sicurezza non lo mostriamo più. Se lo perdi, revocalo e creane un altro.',
        'label' => 'Token per :name',
        'copy' => 'Copia il token',
        'copied' => 'Copiato',
        'config' => 'Esempio di configurazione',
        'done' => 'Fatto, l\'ho copiato',
    ],
    'list' => [
        'title' => 'Token attivi',
        'empty' => 'Non hai ancora nessun token: nessun assistente può usare il sito a tuo nome.',
        'created_at' => 'Creato il :date',
        'expires_at' => 'scade il :date',
        'revoke' => 'Revoca',
        'revoke_confirm' => 'Revocare questo token? L\'assistente che lo usa smette subito di funzionare.',
        'revoked' => 'Token revocato.',
    ],
    'safety' => 'Tratta il token come una password: chi lo ha può iscriverti e cancellare le tue iscrizioni. L\'assistente chiede sempre conferma prima di farlo.',
    'back' => 'Torna a Modifica il profilo',
    'link' => [
        'title' => 'Assistenti AI',
        'description' => 'Collega Claude, Cursor o un altro assistente al tuo account per cercare meetup e iscriverti.',
        'action' => 'Collega un assistente AI',
    ],
];
