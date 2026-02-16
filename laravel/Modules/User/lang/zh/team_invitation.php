<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '团队邀请',
    'group' => '团队',
    'icon' => 'heroicon-o-user-plus',
    'sort' => 37,
  ),
  'label' => '团队邀请',
  'plural_label' => '团队邀请',
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
    'invited_by_id' => 
    array (
      'label' => '邀请人',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'accepted_at' => 
    array (
      'label' => '接受时间',
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
    'resend_invitation' => 
    array (
      'label' => '重新发送邀请',
    ),
    'accept_invitation' => 
    array (
      'label' => '接受邀请',
    ),
    'cancel_invitation' => 
    array (
      'label' => '取消邀请',
    ),
  ),
);
