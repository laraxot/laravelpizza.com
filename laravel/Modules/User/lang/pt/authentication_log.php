<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 'Autenticação',
    'icon' => 'heroicon-o-shield-exclamation',
    'label' => 'Registros de Autenticação',
    'sort' => 5,
  ),
  'label' => 'Registro de Autenticação',
  'plural_label' => 'Registros de Autenticação',
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
      'label' => 'Usuário',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'Endereço IP',
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
      'label' => 'Acesso Em',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'logout_at' => 
    array (
      'label' => 'Desconexão Em',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login_method' => 
    array (
      'label' => 'Método de Acesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'success' => 
    array (
      'label' => 'Sucesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'reorderRecords' => 
    array (
      'tooltip' => 'Reordenar Registros',
      'icon' => 'reorderRecords',
      'label' => 'Reordenar Registros',
    ),
    'view_details' => 
    array (
      'label' => 'Ver Detalhes',
    ),
    'export_logs' => 
    array (
      'label' => 'Exportar Registros',
    ),
  ),
);
