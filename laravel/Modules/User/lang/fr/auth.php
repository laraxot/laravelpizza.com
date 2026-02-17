<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Créer un nouveau compte',
        'subtitle' => 'Entrez vos coordonnées pour vous inscrire',
        'name' => 'Nom complet',
        'name_placeholder' => 'Marie Dupont',
        'email' => 'Adresse e-mail',
        'email_placeholder' => 'exemple@email.com',
        'password' => 'Mot de passe',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirmer le mot de passe',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'S\'inscrire',
        'success' => 'Inscription terminée avec succès.',
        'failed' => 'Impossible de terminer l\'inscription.',
        'already_have_account' => 'Vous avez déjà un compte ?',
        'login' => 'Se connecter',
        'error_occurred' => 'Une erreur s\'est produite lors de l\'inscription. Veuillez réessayer.',
        'fields' => [
            'first_name' => 'Prénom',
            'last_name' => 'Nom',
            'email' => 'Adresse e-mail',
            'password' => 'Mot de passe',
            'password_confirmation' => 'Confirmer le mot de passe',
        ],
        'validation' => [
            'password' => [
                'complexity' => 'Le mot de passe doit répondre aux exigences de sécurité.',
            ],
        ],
    ],
    'gdpr' => [
        'privacy_policy' => [
            'required' => 'Vous devez accepter la politique de confidentialité pour continuer.',
        ],
        'terms' => [
            'required' => 'Vous devez accepter les conditions d\'utilisation pour continuer.',
        ],
        'links' => [
            'privacy' => 'la politique de confidentialité',
            'terms' => 'les conditions d\'utilisation',
            'and' => 'et',
            'period' => '.',
        ],
        'privacy_policy_label' => 'J\'ai lu et compris la politique de confidentialité de LaravelPizza.com et j\'accepte le traitement de mes données personnelles tel que décrit dans la politique.',
        'privacy_policy_required' => 'Vous devez accepter la politique de confidentialité pour continuer l\'inscription.',
        'privacy_policy_hint' => 'Avis complet conformément aux articles 13 et 14 du règlement (UE) 2016/679 (RGPD)',
        'terms_label' => 'J\'ai lu et accepté les conditions d\'utilisation de LaravelPizza.com.',
        'terms_required' => 'Vous devez accepter les conditions d\'utilisation pour continuer l\'inscription.',
        'terms_hint' => 'Contrat de service conformément à l\'article 6(1)(b) du règlement (UE) 2016/679 (RGPD)',
        'data_processing_label' => 'J\'accepte le traitement de mes données personnelles (prénom, nom, email) aux fins de création et de gestion de mon compte utilisateur sur LaravelPizza.com, nécessaires pour la fourniture des services demandés.',
        'data_processing_required' => 'Vous devez accepter le traitement des données personnelles pour continuer l\'inscription.',
        'data_processing_hint' => 'Base juridique : Exécution du contrat (art. 6(1)(b) RGPD)',
        'marketing_label' => 'J\'accepte de recevoir des communications marketing et promotionnelles de LaravelPizza.com par email, concernant les événements meetup, nouvelles fonctionnalités et offres spéciales.',
        'marketing_hint' => 'Ce consentement est facultatif et vous pouvez le retirer à tout moment sans conséquences.',
        'cookie_policy_label' => 'J\'accepte l\'utilisation de cookies techniques, analytiques et marketing pour améliorer l\'expérience utilisateur.',
        'cookie_policy_hint' => 'Pour plus d\'informations, veuillez consulter notre politique de cookies.',
        'withdrawal_notice' => 'Vous pouvez retirer votre consentement à tout moment depuis votre tableau de bord confidentialité.',
        'data_minimization' => 'Nous ne collectons que les données strictement nécessaires pour vous fournir les services demandés.',
        'retention_period' => 'Les données personnelles seront conservées pour la période nécessaire aux fins du traitement.',
        'rights_notice' => 'Conformément au RGPD, vous avez le droit d\'accéder, rectifier, supprimer vos données et de vous opposer au traitement.',
        'complaint_right' => 'Vous avez le droit de déposer une plainte auprès de l\'autorité de protection des données.',
        'international_transfers' => 'Les données personnelles ne sont pas transférées vers des pays tiers hors UE.',
        'automated_decisions' => 'Vos données ne font pas l\'objet de décisions automatisées sans intervention humaine.',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];
