<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '团队成员',
        'group' => '团队',
        'icon' => 'heroicon-o-users',
        'sort' => 38,
    ],
    'label' => '团队成员',
    'plural_label' => '团队成员',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_id' => [
            'label' => '用户',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'team_id' => [
            'label' => '团队',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'role' => [
            'label' => '角色',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'joined_at' => [
            'label' => '加入时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => '更改角色',
        ],
        'remove_user' => [
            'label' => '移除用户',
        ],
    ],
];
