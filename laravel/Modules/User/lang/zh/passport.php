<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Passport',
    'group' => '安全',
    'icon' => 'heroicon-o-shield-check',
    'sort' => 35,
  ),
  'label' => 'Passport',
  'plural_label' => 'Passport',
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
      'label' => '名称',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client_id' => 
    array (
      'label' => '客户端ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client_secret' => 
    array (
      'label' => '客户端密钥',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'redirect' => 
    array (
      'label' => '重定向',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'personal_access_client' => 
    array (
      'label' => '个人访问客户端',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_client' => 
    array (
      'label' => '密码客户端',
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
  ),
  'actions' => 
  array (
    'create_client' => 
    array (
      'label' => '创建客户端',
    ),
    'revoke' => 
    array (
      'label' => '撤销',
    ),
  ),
);
