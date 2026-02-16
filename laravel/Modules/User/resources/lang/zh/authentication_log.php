<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '认证日志',
    'group' => '安全',
    'icon' => 'heroicon-o-lock-closed',
    'sort' => 36,
  ),
  'label' => '认证日志',
  'plural_label' => '认证日志',
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
    'ip_address' => 
    array (
      'label' => 'IP地址',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => '用户代理',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login_at' => 
    array (
      'label' => '登录时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'logout_at' => 
    array (
      'label' => '注销时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login_method' => 
    array (
      'label' => '登录方法',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'success' => 
    array (
      'label' => '成功',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => '查看详情',
    ),
    'export_logs' => 
    array (
      'label' => '导出日志',
    ),
    'reorderRecords' => 
    array (
      'tooltip' => '重新排序记录',
    ),
  ),
);
