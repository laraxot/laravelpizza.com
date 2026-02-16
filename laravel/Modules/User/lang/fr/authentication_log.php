<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 'Authentification',
    'icon' => 'heroicon-o-shield-exclamation',
    'label' => 'Journaux d\'Authentification',
    'sort' => 5,
  ),
  'label' => 'Journal d\'Authentification',
  'plural_label' => 'Journaux d\'Authentification',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_id' => 
    array (
      'label' => 'Utilisateur',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'Adresse IP',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'User Agent',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login_at' => 
    array (
      'label' => 'Connexion le',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'logout_at' => 
    array (
      'label' => 'Déconnexion le',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login_method' => 
    array (
      'label' => 'Méthode de connexion',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'success' => 
    array (
      'label' => 'Succès',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'reorderRecords' => 
    array (
      'tooltip' => 'Réorganiser les Enregistrements',
      'icon' => 'reorderRecords',
      'label' => 'Réorganiser les Enregistrements',
    ),
    'view_details' => 
    array (
      'label' => 'Voir les détails',
    ),
    'export_logs' => 
    array (
      'label' => 'Exporter les journaux',
    ),
  ),
);
