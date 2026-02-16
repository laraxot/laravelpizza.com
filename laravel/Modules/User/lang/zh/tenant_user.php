<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '租户用户',
    'group' => '租户',
    'icon' => 'heroicon-o-user-circle',
    'sort' => 39,
  ),
  'label' => '租户用户',
  'plural_label' => '租户用户',
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
      'label' => '用户',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'tenant_id' => 
    array (
      'label' => '租户',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'role' => 
    array (
      'label' => '角色',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => '创建时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => '更新时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'change_role' => 
    array (
      'label' => '更改角色',
    ),
    'remove_user' => 
    array (
      'label' => '移除用户',
    ),
  ),
);
