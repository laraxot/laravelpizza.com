<?php

declare(strict_types=1);

// Modulo Contatti (Http/Livewire/ContactForm) e mail agli organizzatori.
return [
    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message',
        'privacy' => 'privacy consent',
    ],
    'privacy_html' => 'I have read the <a href=":url" class="underline text-red-600" target="_blank" rel="noopener">privacy notice</a> and agree that my data is used only to reply to me.',
    'submit' => 'Send message',
    'throttle' => 'Too many messages in a row: try again in :minutes minutes.',
    'sent' => [
        'title' => 'Message sent, thank you!',
        'body' => 'We will reply to the email address you provided.',
    ],
    'mail' => [
        'subject' => 'New message from the website: :name',
        'from' => 'From: :name <:email>',
        'language' => 'Site language: :locale',
    ],
];
