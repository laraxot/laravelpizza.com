<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Informations Personnelles',
        'user_info_description' => 'Entrez vos informations personnelles pour créer votre compte',
        'required_consents' => 'Consentement Requis',
        'required_consents_description' => 'Pour procéder à l\'inscription, vous devez accepter les conditions suivantes pour le traitement de vos données personnelles',
        'optional_consents' => 'Consentement Optionnel',
        'optional_consents_description' => 'Ces consentements sont optionnels et n\'affectent pas votre inscription. Vous pouvez les modifier à tout moment depuis votre tableau de bord confidentialité.',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Prénom',
        'last_name' => 'Nom',
        'email' => 'Adresse Email',
        'password' => 'Mot de Passe',
        'password_confirmation' => 'Confirmer le Mot de Passe',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_label' => 'J\'ai lu et compris la Politique de Confidentialité et j\'accepte le traitement de mes données personnelles comme décrit dans la politique.',
        'privacy_policy_hint' => 'Information complète conformément aux Art. 13 et 14 du Règlement (UE) 2016/679 (RGPD)',
        'privacy_policy_required' => 'Vous devez accepter la politique de confidentialité pour procéder à l\'inscription.',
        
        'terms_label' => 'J\'ai lu et accepté les Termes et Conditions d\'Utilisation',
        'terms_hint' => 'Contrat de service conformément à l\'Art. 6(1)(b) du Règlement (UE) 2016/679 (RGPD)',
        'terms_required' => 'Vous devez accepter les termes et conditions pour procéder à l\'inscription.',
        
        'data_processing_label' => 'J\'accepte le traitement de mes données personnelles pour la création et la gestion de mon compte utilisateur',
        'data_processing_hint' => 'Base légale: Exécution du contrat (Art. 6(1)(b) RGPD)',
        'data_processing_required' => 'Vous devez accepter le traitement des données pour procéder à l\'inscription.',
        
        'marketing_label' => 'J\'accepte de recevoir des communications marketing et promotionnelles concernant les événements meetup et nouvelles fonctionnalités',
        'marketing_hint' => 'Le consentement est facultatif et vous pouvez le retirer à tout moment sans conséquences.',
        
        'profiling_label' => 'J\'accepte l\'analyse de mes préférences pour personnaliser l\'expérience utilisateur',
        'profiling_hint' => 'Analyse basée sur les données de navigation et interactions pour améliorer nos services.',
        
        'analytics_label' => 'J\'accepte l\'analyse statistique anonyme des données de navigation pour améliorer les performances du site',
        'analytics_hint' => 'Données collectées de manière anonyme et agrégée à des fins statistiques.',
        
        'third_party_label' => 'J\'accepte le partage de mes données avec des partenaires sélectionnés pour des services intégrés',
        'third_party_hint' => 'Uniquement des partenaires conformes RGPD pour des fins spécifiques et limitées.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'Le mot de passe doit contenir au moins 12 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
    ],

    // === MESSAGES ===
    'required_consent_missing' => 'Vous devez accepter tous les consentements requis pour procéder à l\'inscription.',
    
    'success' => 'Inscription terminée avec succès! Votre compte a été créé en conformité avec le RGPD.',
    'success_message' => 'Bienvenue dans LaravelPizza Meetups! Votre inscription est terminée et tous vos consentements ont été correctement enregistrés.',
    
    'error' => 'Erreur lors de l\'inscription',
    'error_message' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer plus tard. Si le problème persiste, contactez notre support.',
];