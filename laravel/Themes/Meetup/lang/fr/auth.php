<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Bon retour sur Laravel Pizza Meetups ! 🍕',
        'subtitle' => 'Connectez-vous pour vous inscrire aux meetups et gérer vos réservations.',
        'page_title' => 'Se connecter',
    ],
    'logout' => [
        'in_progress' => 'Déconnexion en cours…',
    ],
    'password' => [
        'request' => [
            'title' => 'Mot de passe oublié ?',
            'subtitle' => 'Saisissez l\'e-mail de votre compte : nous vous enverrons un lien pour en choisir un nouveau.',
            'email' => 'E-mail',
            'submit' => 'Envoyer le lien',
            'back_to_login' => 'Retour à la connexion',
        ],
        'reset' => [
            'title' => 'Choisissez un nouveau mot de passe',
            'subtitle' => 'Au moins 8 caractères. Une fois enregistré, vous êtes connecté.',
            'email' => 'E-mail',
            'password' => 'Nouveau mot de passe',
            'password_confirmation' => 'Répétez le nouveau mot de passe',
            'submit' => 'Enregistrer',
        ],
        'confirm' => [
            'title' => 'Confirmez votre mot de passe',
            'subtitle' => 'Zone protégée : saisissez à nouveau votre mot de passe pour continuer.',
            'password' => 'Mot de passe',
            'submit' => 'Confirmer',
            'forgot' => 'Mot de passe oublié ?',
        ],
    ],
    'verify' => [
        'title' => 'Vérifiez vos e-mails',
        'subtitle' => 'Nous vous avons envoyé un lien pour confirmer votre adresse e-mail.',
        'resent' => 'Nous vous avons envoyé un nouveau lien de confirmation.',
        'resend' => 'Rien reçu ? Envoyer un autre lien',
        'logout' => 'Se déconnecter',
    ],
];
