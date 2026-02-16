<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Trabalho Falhado',
    'group' => 'Trabalhos Falhados',
    'icon' => 'heroicon-o-exclamation-triangle',
    'sort' => 27,
  ),
  'label' => 'Trabalho Falhado',
  'plural_label' => 'Trabalhos Falhados',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'label' => 'Conexão',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Fila',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Carga Útil',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'exception' => 
    array (
      'label' => 'Exceção',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Falhado Em',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Tentar Novamente',
    ),
    'delete' => 
    array (
      'label' => 'Excluir',
    ),
    'retry_all' => 
    array (
      'label' => 'Tentar Todos Novamente',
    ),
    'delete_all' => 
    array (
      'label' => 'Excluir Todos',
    ),
  ),
);
