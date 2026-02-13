<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'register' => [
        'title' => 'Commencez votre voyage Pizza 🍕',
        'subtitle' => 'Rejoignez 5.000+ amateurs de pizza et développeurs. Accès exclusif aux meetups et tutoriels.',
        'submit' => 'Rejoindre la communauté',
        'submitting' => 'Nous préparons votre four...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'Prénom',
            'placeholder' => 'Jean',
            'helper_text' => 'Entrez votre prénom pour compléter votre profil',
        ],
        'last_name' => [
            'label' => 'Nom',
            'placeholder' => 'Dupont',
            'helper_text' => 'Entrez votre nom pour compléter votre profil',
        ],
        'email' => [
            'label' => 'Votre meilleure email',
            'placeholder' => 'jean.dupont@exemple.fr',
            'helper_text' => 'Nous enverrons un email de confirmation à l\'adresse fournie',
        ],
        'password' => [
            'label' => 'Mot de passe sécurisé',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Doit contenir au moins 12 caractères, majuscule, minuscule, chiffre et symbole',
        ],
        'password_confirmation' => [
            'label' => 'Confirmer le mot de passe',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Répétez le mot de passe pour confirmer',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Informations Personnelles',
        'user_info_description' => 'Entrez vos informations personnelles pour créer votre compte',
        'required_consents' => 'Consentement Requis',
        'required_consents_description' => 'Pour procéder à l\'inscription, vous devez accepter les conditions suivantes pour le traitement de vos données personnelles',
        'optional_consents' => 'Consentement Optionnel',
        'optional_consents_description' => 'Ces consentements sont optionnels et n\'affectent pas votre inscription. Vous pouvez les modifier à tout moment depuis votre tableau de bord confidentialité.',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consentements de confidentialité',
        'privacy_policy_label' => 'J\'ai lu et compris la Politique de Confidentialité et j\'accepte le traitement de mes données personnelles comme décrit dans la politique.',
        'privacy_policy_hint' => 'Information complète conformément aux Art. 13 et 14 du Règlement (UE) 2016/679 (RGPD)',
        'privacy_policy_required' => 'Vous devez accepter la politique de confidentialité pour procéder à l\'inscription.',
        'privacy_checkbox_html' => 'J\'ai lu la <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Politique de Confidentialité</a>',
        'terms_label' => 'J\'ai lu et accepté les Termes et Conditions d\'Utilisation',
        'terms_hint' => 'Contrat de service conformément à l\'Art. 6(1)(b) du Règlement (UE) 2016/679 (RGPD)',
        'terms_required' => 'Vous devez accepter les termes et conditions pour procéder à l\'inscription.',
        'terms_checkbox_html' => 'J\'accepte les <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Termes et Conditions</a>',
        'marketing_label' => 'Je veux recevoir des conseils sur la pizza et des invitations aux meetups (optionnel)',
        'marketing_hint' => 'Le consentement est facultatif et vous pouvez le retirer à tout moment sans conséquences.',
        'required_consent_missing' => 'Vous devez accepter tous les consentements requis pour procéder à l\'inscription.',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Lire la politique de confidentialité',
        'read_terms' => 'Lire les termes et conditions',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Le mot de passe doit contenir au moins 12 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
    ],

    // === MESSAGES ===
    'already_registered' => 'Vous avez déjà un compte?',
    'login' => 'Se connecter',
    'required_consent_missing' => 'Vous devez accepter tous les consentements requis pour procéder à l\'inscription.',
    'success' => 'Inscription terminée avec succès! Votre compte a été créé en conformité avec le RGPD.',
    'success_message' => 'Bienvenue dans LaravelPizza Meetups! Votre inscription est terminée et tous vos consentements ont été correctement enregistrés.',
    'error' => 'Erreur lors de l\'inscription',
    'error_message' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer plus tard. Si le problème persiste, contactez notre support.',
];
