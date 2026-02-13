<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'title' => 'Commencez votre voyage Pizza 🍕', // Moved from nested 'register' array
    'subtitle' => 'Rejoignez notre communauté croissante amateurs de pizza et développeurs. Accès exclusif aux meetups et tutoriels.', // Moved from nested 'register' array
    'submit' => 'Rejoindre la communauté', // Moved from nested 'register' array
    'submitting' => 'Nous préparons votre four...', // Moved from nested 'register' array

    // === STATS ===
    'stats' => [
        'active_developers' => 'Communauté en Croissance',
        'monthly_meetups' => 'Événements à Venir',
        'community_support' => 'Support 24/7',
    ],

    // === FORM ===
    'form' => [
        'cta_title' => 'Créez Votre Compte Gratuit',
        'cta_subtitle' => 'Aucune carte requise - 100% gratuit pour toujours!',
        'terms_notice' => 'En vous inscrivant, vous acceptez nos Conditions et Politique de Confidentialité',
    ],

    // === BENEFITS CTA ===
    'benefits' => [
        'community' => [
            'title' => 'Rejoignez la Communauté',
            'description' => 'Connectez-vous avec des professionnels et passionnés de Laravel',
            'cta' => 'Accès gratuit immédiat après inscription',
        ],
        'tutorials' => [
            'title' => 'Tutoriels & Ateliers Exclusifs',
            'description' => 'Accès prioritaire aux contenus premium et formations',
            'cta' => 'Obtenez un accès exclusif', // Changed from 'Valeur 997€/an - Gratuit pour membres'
        ],
        'networking' => [
            'title' => 'Réseautage & Carrière',
            'description' => 'Opportunités de collaboration et croissance professionnelle',
            'cta' => 'Recruté par les meilleures entreprises Laravel',
        ],
    ],
    'social_proof' => 'Rejoignez la communauté LaravelPizza',
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
        'trust_badges' => 'Badges de confiance',
        'registration_form' => 'Formulaire d\'inscription',
        'benefits' => 'Avantages',
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

    // === CLICKBAIT & MARKETING ===
    'clickbait' => [
        'active_developers' => 'Développeurs Actifs',
        'monthly_meetups' => 'Meetups Mensuels',
        'community_support' => 'Support Communautaire',
        'free_access' => 'Accès GRATUIT immédiat après inscription',
        'worth_free' => 'Obtenez un accès exclusif', // Changed from 'Valeur 997€/an - GRATUIT pour les membres'
        'get_hired' => 'Soyez recruté par les meilleures entreprises Laravel',
        'join_now' => 'Rejoignez MAINTENANT avant la fermeture de l\'inscription!',
        'create_account' => 'Créez Votre Compte GRATUIT',
        'no_card_required' => 'Aucune carte de crédit requise - 100% GRATUIT pour toujours!',
        'by_registering' => 'En vous inscrivant, vous acceptez nos Conditions et Politique de Confidentialité',
    ],

    // === SEO KEYWORDS ===
    'seo' => [
        'description' => 'Rejoignez la communauté LaravelPizza pour des meetups exclusifs, des tutoriels premium et du réseautage. Accès gratuit aux ateliers et aux événements communautaires.',
        'laravel_meetup' => 'meetup Laravel',
        'laravel_community' => 'communauté Laravel',
        'php_developer_community' => 'communauté développeurs PHP',
        'laravel_tutorials' => 'tutoriels Laravel',
        'laravel_workshops' => 'ateliers Laravel',
        'laravel_networking' => 'réseau Laravel',
        'laravelpizza' => 'LaravelPizza',
    ],
];
