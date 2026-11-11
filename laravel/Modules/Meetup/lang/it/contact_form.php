<?php

declare(strict_types=1);

// Modulo Contatti (Http/Livewire/ContactForm) e mail agli organizzatori.
return [
    'fields' => [
        'name' => 'Nome',
        'email' => 'Email',
        'message' => 'Messaggio',
        'privacy' => 'consenso privacy',
    ],
    'privacy_html' => 'Ho letto l\'<a href=":url" class="underline text-red-600" target="_blank" rel="noopener">informativa privacy</a> e accetto che i miei dati siano usati solo per rispondermi.',
    'submit' => 'Invia il messaggio',
    'throttle' => 'Troppi invii ravvicinati: riprova tra :minutes minuti.',
    'sent' => [
        'title' => 'Messaggio inviato, grazie!',
        'body' => 'Ti risponderemo all\'indirizzo email che hai indicato.',
    ],
    'mail' => [
        'subject' => 'Nuovo messaggio dal sito: :name',
        'from' => 'Da: :name <:email>',
        'language' => 'Lingua del sito: :locale',
    ],
];
