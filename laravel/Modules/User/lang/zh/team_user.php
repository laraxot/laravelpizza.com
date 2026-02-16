<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '团队成员',
    'group' => '团队',
    'icon' => 'heroicon-o-users',
    'sort' => 38,
  ),
  'label' => '团队成员',
  'plural_label' => '团队成员',
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
    'team_id' => 
    array (
      'label' => '团队',
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
    'joined_at' => 
    array (
      'label' => '加入时间',
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
