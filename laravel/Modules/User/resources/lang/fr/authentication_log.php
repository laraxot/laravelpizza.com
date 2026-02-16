<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Journaux d\'Authentification',
    'group' => 'Sécurité',
    'icon' => 'heroicon-o-lock-closed',
    'sort' => 36,
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
      'label' => 'Agent Utilisateur',
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
    'view_details' => 
    array (
      'label' => 'Voir les détails',
    ),
    'export_logs' => 
    array (
      'label' => 'Exporter les journaux',
    ),
    'reorderRecords' => 
    array (
      'tooltip' => 'Réorganiser les enregistrements',
    ),
  ),
);
