<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Commencez votre voyage Pizza 🍕',
        'subtitle' => 'Rejoignez 5.000+ amateurs de pizza et développeurs. Accès exclusif aux meetups et tutoriels.',
        'submit' => 'Rejoindre la communauté',
        'submitting' => 'Nous préparons votre four...',
    ],
    'benefits' => [
        'community' => [
            'title' => '5,000+ Communauté de Développeurs',
            'description' => 'Connectez-vous avec des professionnels et passionnés de Laravel',
        ],
        'tutorials' => [
            'title' => 'Tutoriels & Ateliers Exclusifs',
            'description' => 'Accès prioritaire aux contenus premium et formations',
        ],
        'networking' => [
            'title' => 'Réseautage & Carrière',
            'description' => 'Opportunités de collaboration et croissance professionnelle',
        ],
    ],
    'social_proof' => 'Rejoignez 5,000+ développeurs dans le monde',
    'fields' => [
        'first_name' => [
            'label' => 'Prénom',
            'placeholder' => 'Mario',
            'helper_text' => 'Entrez votre prénom pour compléter votre profil',
        ],
        'last_name' => [
            'label' => 'Nom',
            'placeholder' => 'Rossi',
            'helper_text' => 'Entrez votre nom pour compléter votre profil',
        ],
        'email' => [
            'label' => 'Votre meilleure email',
            'placeholder' => 'mario.rossi@exemple.com',
            'helper_text' => 'Nous vous enverrons un email de confirmation à cette adresse',
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
    'sections' => [
        'user_info' => 'Informations Personnelles',
        'user_info_description' => 'Entrez vos informations personnelles pour créer votre compte',
        'required_consents' => 'Consentement Requis',
        'required_consents_description' => 'Pour procéder à l\'inscription, vous devez accepter les conditions suivantes pour le traitement de vos données personnelles',
        'optional_consents' => 'Consentement Optionnel',
        'optional_consents_description' => 'Ces consentements sont optionnels et n\'affectent pas votre inscription. Vous pouvez les modifier à tout moment depuis votre profil.',
    ],
    'consents' => [
        'title' => 'Consentements Confidentialité',
        'privacy_policy_label' => 'J\'ai lu et compris la politique de confidentialité et j\'accepte le traitement de mes données personnelles comme décrit dans la politique.',
        'privacy_policy_hint' => 'Avis complet conformément aux articles 13 et 14 du règlement (UE) 2016/679 (RGPD)',
        'privacy_policy_required' => 'Veuillez accepter la politique de confidentialité pour procéder.',
        'privacy_checkbox_html' => 'J\'ai lu la <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">politique de confidentialité</a>',
        'terms_label' => 'J\'ai lu et accepté les conditions générales',
        'terms_hint' => 'Contrat de service conformément à l\'article 6(1)(b) du règlement (UE) 2016/679 (RGPD)',
        'terms_required' => 'Veuillez accepter les conditions générales pour procéder.',
        'terms_checkbox_html' => 'J\'accepte les <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">conditions générales</a>',
        'marketing_label' => 'Je veux recevoir des conseils sur la pizza et des invitations aux meetups (optionnel)',
        'marketing_hint' => 'Le consentement est optionnel et vous pouvez le révoquer à tout moment sans conséquences.',
    ],
    'actions' => [
        'read_privacy_policy' => 'Lire politique de confidentialité',
        'read_terms' => 'Lire conditions générales',
    ],
    'validation' => [
        'password_complexity' => 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.',
    ],
    'already_registered' => 'Vous avez déjà un compte ?',
    'login' => 'Se connecter',
    'required_consent_missing' => 'Vous devez accepter tous les consentements requis pour procéder.',
    'success' => 'Inscription réussie ! Votre compte a été créé en conformité avec le RGPD.',
    'success_message' => 'Bienvenue dans LaravelPizza Meetups ! Votre inscription est complète et tous vos consentements ont été correctement enregistrés.',
    'error' => 'Erreur d\'inscription',
    'error_message' => 'Une erreur s\'est produite lors de l\'inscription. Veuillez réessayer plus tard. Si le problème persiste, contactez notre support.',
];