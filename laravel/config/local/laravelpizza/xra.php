<?php

declare(strict_types=1);

return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'Meetup',
    'primary_lang' => 'it',
    'pub_theme' => 'Meetup',
    // Pagina dopo login e registrazione: l'area personale di LaravelPizza è "I miei eventi".
    'post_login_path' => '/events/my',
    // Casella che riceve i messaggi del modulo Contatti (vuota = MAIL_FROM_ADDRESS).
    'contact_email' => env('CONTACT_EMAIL'),
    // Niente Gravatar: la cookie policy promette zero richieste a terzi; gli avatar senza foto mostrano le iniziali.
    'gravatar' => false,
    'search_action' => 'it/videos',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => false,
    'register_adm_theme' => false,
    'register_pub_theme' => true,
];
