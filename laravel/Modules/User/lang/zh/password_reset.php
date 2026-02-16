<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '密码重置',
    'group' => '安全',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => '密码重置',
  'plural_label' => '密码重置',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => '邮箱',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token' => 
    array (
      'label' => '令牌',
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
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => '重新发送邮件',
    ),
    'view_request' => 
    array (
      'label' => '查看请求',
    ),
  ),
);
