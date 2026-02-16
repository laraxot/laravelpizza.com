<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => '待处理任务',
    'group' => '任务',
    'icon' => 'heroicon-o-clock',
    'sort' => 30,
  ),
  'label' => '待处理任务',
  'plural_label' => '待处理任务',
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
      'label' => '连接',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => '队列',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => '内容',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => '尝试次数',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => '保留时间',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => '可用时间',
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
    'process' => 
    array (
      'label' => '处理',
    ),
    'retry' => 
    array (
      'label' => '重试',
    ),
  ),
);
