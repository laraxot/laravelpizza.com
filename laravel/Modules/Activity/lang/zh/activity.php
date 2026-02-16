<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => '活动',
    'plural' => '活动',
    'group' => 
    array (
      'name' => '监控',
      'description' => '系统活动监控',
    ),
    'label' => '活动',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => '用户',
      'placeholder' => '选择用户',
      'help' => '执行操作的用户',
      'name' => 
      array (
        'label' => '姓名',
        'placeholder' => '输入姓名',
        'help' => '用户的全名',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => '邮箱',
        'placeholder' => '输入邮箱',
        'help' => '用户邮箱地址',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => '角色',
        'placeholder' => '选择角色',
        'help' => '用户在系统中的角色',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => '操作',
      'placeholder' => '选择操作',
      'help' => '执行的操作类型',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => '创建',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => '更新',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => '删除',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => '查看',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => '下载',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => '上传',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => '登录',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => '登出',
          'icon' => 'heroicon-o-arrow-left-on-rectangle',
          'color' => 'gray',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => '主题',
      'placeholder' => '选择主题',
      'help' => '操作影响的对象',
      'type' => 
      array (
        'label' => '类型',
        'placeholder' => '对象类型',
        'help' => '对象的类或类型',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'ID',
        'placeholder' => '对象ID',
        'help' => '对象的唯一标识符',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => '姓名',
        'placeholder' => '对象名称',
        'help' => '对象的描述性名称',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => '描述',
      'placeholder' => '输入描述',
      'help' => '活动的详细描述',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'IP地址',
      'placeholder' => '例如 192.168.1.1',
      'help' => '执行操作的IP地址',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => '用户代理',
      'placeholder' => '浏览器和操作系统',
      'help' => '关于用户浏览器和系统的信息',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => '日期',
      'placeholder' => '选择日期和时间',
      'help' => '活动创建的日期和时间',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => '属性',
      'placeholder' => '附加属性',
      'help' => '活动的附加数据',
      'old' => 
      array (
        'label' => '旧值',
        'placeholder' => '之前的值',
        'help' => '更改前的值',
      ),
      'new' => 
      array (
        'label' => '新值',
        'placeholder' => '当前值',
        'help' => '更改后的值',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => '显示/隐藏列',
      'help' => '配置列可见性',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => '重新排序记录',
      'help' => '重新排序表中的记录',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => '重置筛选器',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => '应用筛选器',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => '用户',
      'placeholder' => '按用户筛选',
      'help' => '按用户筛选活动',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => '操作',
      'placeholder' => '按操作筛选',
      'help' => '按操作类型筛选活动',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => '主题类型',
      'placeholder' => '按主题类型筛选',
      'help' => '按主题类型筛选活动',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => '日期范围',
      'placeholder' => '选择范围',
      'help' => '按日期范围筛选活动',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => '今天',
        'yesterday' => '昨天',
        'last_7_days' => '最近7天',
        'last_30_days' => '最近30天',
        'this_month' => '本月',
        'last_month' => '上个月',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'IP地址',
      'placeholder' => '按IP筛选',
      'help' => '按IP地址筛选活动',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => '查看详情',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => '详情加载成功',
      'error' => '加载详情时出错',
      'confirmation' => '您想查看此活动的详情吗？',
    ),
    'export' => 
    array (
      'label' => '导出',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => '导出完成',
      'error' => '导出时出错',
      'confirmation' => '您想导出选定的活动吗？',
    ),
    'clear_old' => 
    array (
      'label' => '清理旧数据',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => '旧活动删除成功',
      'error' => '清理活动时出错',
      'confirmation' => '您确定要删除旧活动吗？此操作无法撤销。',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => '删除选定',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => '选定活动删除成功',
      'error' => '删除活动时出错',
      'confirmation' => '您确定要删除选定的活动吗？',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => '所选筛选器未找到活动',
    'cleared' => '旧活动删除成功',
    'exported' => '活动导出成功',
    'loading' => '正在加载活动...',
    'error_loading' => '加载活动时出错',
    'empty_state' => 
    array (
      'title' => '没有记录的活动',
      'description' => '还没有活动显示。当用户开始与系统交互时，活动将出现在这里。',
    ),
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 
      array (
        'label' => 'CSV',
        'mime_type' => 'text/csv',
        'extension' => 'csv',
        'icon' => 'heroicon-o-document-text',
      ),
      'excel' => 
      array (
        'label' => 'Excel',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'extension' => 'xlsx',
        'icon' => 'heroicon-o-table-cells',
      ),
      'pdf' => 
      array (
        'label' => 'PDF',
        'mime_type' => 'application/pdf',
        'extension' => 'pdf',
        'icon' => 'heroicon-o-document',
      ),
    ),
    'columns' => 
    array (
      'date' => 
      array (
        'label' => '日期',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => '用户',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => '操作',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => '主题',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => '描述',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => '活动_{date}_{time}',
    'max_records' => '10000',
  ),
  'permissions' => 
  array (
    'view' => 'activities.view',
    'create' => 'activities.create',
    'update' => 'activities.update',
    'delete' => 'activities.delete',
    'export' => 'activities.export',
    'clear_old' => 'activities.clear_old',
  ),
  'pagination' => 
  array (
    'per_page' => '25',
    'options' => 
    array (
      0 => '10',
      1 => '25',
      2 => '50',
      3 => '100',
    ),
  ),
  'cache' => 
  array (
    'ttl' => '300',
    'tags' => 
    array (
      0 => 'activities',
      1 => 'monitoring',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
