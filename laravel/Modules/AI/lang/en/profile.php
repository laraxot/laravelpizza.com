<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Profile',
        'plural' => 'Profiles',
        'group' => [
            'name' => 'Content',
        ],
    ],
    'fields' => [
        'type' => 'Type',
        'name' => 'Name',
        'guard_name' => 'Guard',
        'permissions' => 'Permissions',
        'roles' => 'Roles',
        'updated_at' => 'Updated on',
        'user_name' => 'User Name',
        'first_name' => 'First Name',
        'last_name' => 'Last name',
        'email' => 'email',
        'is_active' => 'active?',
    ],

    'setting' => [
        'date' => 'Date',
        'action' => 'Action',
        'market' => 'Item',
        'outcome' => 'Amount',
        'option' => 'Option',
        'welcome' => 'Welcome gift',
        'rating_article' => 'Bet placed',
        'rating_article_winner' => 'Winning',
        'admin_add_credit_to_profile' => 'Adding credits by the administrator',
        'admin_remove_credit_to_profile' => 'Subtraction of credits from the administrator',
    ],
];
