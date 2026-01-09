<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => '附加用户',
        'associate_user' => '关联用户',
        'user_actions' => '用户操作',
        'view' => '查看',
        'edit' => '编辑',
        'detach' => '分离',
        'row_actions' => '操作',
        'delete_selected' => '删除选中',
        'confirm_detach' => '您确定要分离此用户吗？',
        'confirm_delete' => '您确定要删除选中的用户吗？',
        'success_attached' => '用户附加成功',
        'success_detached' => '用户分离成功',
        'success_deleted' => '用户删除成功',
        'toggle_layout' => '切换布局',
        'create' => '创建用户',
        'delete' => '删除用户',
        'associate' => '关联用户',
        'bulk_delete' => '删除选中',
        'bulk_detach' => '分离选中',
        'impersonate' => '模拟用户',
        'stop_impersonating' => '停止模拟',
        'block' => '封禁',
        'unblock' => '解封',
        'send_reset_link' => '发送重置链接',
        'verify_email' => '验证邮箱',
    ],
    'fields' => [
        'name' => [
            'label' => '姓名',
            'placeholder' => '输入姓名',
            'description' => '姓名',
            'helper_text' => '',
        ],
        'email' => [
            'label' => '邮箱',
            'placeholder' => '输入邮箱',
            'description' => '邮箱',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => '创建日期',
        ],
        'updated_at' => [
            'label' => '最后修改',
        ],
        'role' => [
            'label' => '角色',
        ],
        'active' => '活跃',
        'id' => [
            'label' => 'ID',
        ],
        'password' => [
            'label' => '密码',
            'placeholder' => '输入密码',
            'description' => '密码',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => '确认密码',
            'placeholder' => '确认密码',
        ],
        'email_verified_at' => [
            'label' => '邮箱验证时间',
        ],
        'current_password' => [
            'label' => '当前密码',
            'placeholder' => '输入当前密码',
        ],
        'roles' => [
            'label' => '角色',
        ],
        'permissions' => [
            'label' => '权限',
        ],
        'status' => [
            'label' => '状态',
            'options' => [
                'active' => '活跃',
                'inactive' => '不活跃',
                'blocked' => '已封禁',
            ],
        ],
        'last_login' => [
            'label' => '最后登录',
        ],
        'avatar' => [
            'label' => '头像',
        ],
        'language' => [
            'label' => '语言',
        ],
        'timezone' => [
            'label' => '时区',
        ],
        'password_expires_at' => [
            'label' => '密码过期时间',
        ],
        'verified' => [
            'label' => '已验证',
        ],
        'unverified' => [
            'label' => '未验证',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'isActive' => [
            'label' => 'isActive',
        ],
        'deactivate' => [
            'label' => 'deactivate',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'changePassword' => [
            'label' => 'changePassword',
        ],
    ],
    'filters' => [
        'active_users' => '活跃用户',
        'creation_date' => '创建日期',
        'date_from' => '从',
        'date_to' => '到',
        'verified' => '已验证用户',
        'unverified' => '未验证用户',
    ],
    'messages' => [
        'no_records' => '未找到用户',
        'loading' => '加载用户中...',
        'search' => '搜索用户...',
        'credentials_incorrect' => '提供的凭据不正确。',
        'created' => '用户创建成功',
        'updated' => '用户更新成功',
        'deleted' => '用户删除成功',
        'blocked' => '用户封禁成功',
        'unblocked' => '用户解封成功',
        'reset_link_sent' => '重置链接已发送',
        'email_verified' => '邮箱验证成功',
        'impersonating' => '您正在模拟用户 :name',
        'login_success' => '登录成功',
        'validation_error' => '验证错误',
        'login_error' => '登录过程中发生错误。请稍后重试。',
    ],
    'modals' => [
        'create' => [
            'heading' => '创建用户',
            'description' => '创建新用户记录',
            'actions' => [
                'submit' => '创建',
                'cancel' => '取消',
            ],
        ],
        'edit' => [
            'heading' => '编辑用户',
            'description' => '修改用户信息',
            'actions' => [
                'submit' => '保存更改',
                'cancel' => '取消',
            ],
        ],
        'delete' => [
            'heading' => '删除用户',
            'description' => '您确定要删除此用户吗？',
            'actions' => [
                'submit' => '删除',
                'cancel' => '取消',
            ],
        ],
        'associate' => [
            'heading' => '关联用户',
            'description' => '选择要关联的用户',
            'actions' => [
                'submit' => '关联',
                'cancel' => '取消',
            ],
        ],
        'detach' => [
            'heading' => '分离用户',
            'description' => '您确定要分离此用户吗？',
            'actions' => [
                'submit' => '分离',
                'cancel' => '取消',
            ],
        ],
        'bulk_delete' => [
            'heading' => '删除选中用户',
            'description' => '您确定要删除选中的用户吗？',
            'actions' => [
                'submit' => '删除选中',
                'cancel' => '取消',
            ],
        ],
        'bulk_detach' => [
            'heading' => '分离选中用户',
            'description' => '您确定要分离选中的用户吗？',
            'actions' => [
                'submit' => '分离选中',
                'cancel' => '取消',
            ],
        ],
    ],
    'navigation' => [
        'name' => '用户',
        'plural' => '用户',
        'group' => [
            'name' => '用户管理',
            'description' => '用户及其权限管理',
        ],
        'label' => '用户',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'validation' => [
        'email_unique' => '此邮箱已被使用',
        'password_min' => '密码必须至少有 :min 个字符',
        'password_confirmed' => '密码不匹配',
        'current_password' => '当前密码不正确',
    ],
    'permissions' => [
        'view_users' => '查看用户',
        'create_users' => '创建用户',
        'edit_users' => '编辑用户',
        'delete_users' => '删除用户',
        'impersonate_users' => '模拟用户',
        'manage_roles' => '管理角色',
    ],
    'model' => [
        'label' => '用户',
    ],
];
