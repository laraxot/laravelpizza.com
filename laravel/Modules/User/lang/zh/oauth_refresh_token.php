<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'OAuth刷新令牌',
    'group' => '',
    'icon' => 'heroicon-o-arrow-path',
    'sort' => 34,
  ),
  'label' => 'OAuth刷新令牌',
  'plural_label' => 'OAuth刷新令牌',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'access_token_id' => 
    array (
      'label' => '访问令牌',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'revoked' => 
    array (
      'label' => '已撤销',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires_at' => 
    array (
      'label' => '过期时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'revoke' => 
    array (
      'label' => '撤销',
    ),
  ),
);
