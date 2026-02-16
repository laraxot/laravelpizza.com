<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Test SMTP',
    'group' => 'Notifications',
    'icon' => 'heroicon-o-envelope-open',
    'sort' => 47,
  ),
  'label' => 'Test SMTP',
  'plural_label' => 'Tests SMTP',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nom',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'host' => 
    array (
      'label' => 'Hôte',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'port' => 
    array (
      'label' => 'Port',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'username' => 
    array (
      'label' => 'Nom d\'Utilisateur',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Mot de Passe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'encryption' => 
    array (
      'label' => 'Chiffrement',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'from_address' => 
    array (
      'label' => 'Adresse Expéditeur',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'from_name' => 
    array (
      'label' => 'Nom Expéditeur',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Statut',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_tested_at' => 
    array (
      'label' => 'Dernier Test À',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Créé À',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body_html' => 
    array (
      'description' => 'Corps HTML',
      'helper_text' => 'Contenu HTML de l\'email',
      'label' => '',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'logout' => 
    array (
      'tooltip' => 'Déconnexion',
      'icon' => 'logout',
      'label' => 'Déconnexion',
    ),
    'emailFormActions' => 
    array (
      'tooltip' => 'Actions du Formulaire Email',
      'icon' => 'emailFormActions',
      'label' => 'Actions du Formulaire Email',
    ),
    'profile' => 
    array (
      'tooltip' => 'Profil',
      'icon' => 'profile',
    ),
    'send_test_email' => 
    array (
      'label' => 'Envoyer Email de Test',
    ),
    'test_connection' => 
    array (
      'label' => 'Tester la Connexion',
    ),
  ),
);
