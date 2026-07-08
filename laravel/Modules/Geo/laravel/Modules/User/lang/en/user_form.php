<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => ['label' => 'email', 'placeholder' => 'email', 'helper_text' => 'email', 'description' => 'email'],
        'password' => ['label' => 'password', 'placeholder' => 'password', 'helper_text' => 'password', 'description' => 'password'],
        'remember' => ['label' => 'remember', 'placeholder' => 'remember', 'helper_text' => 'remember', 'description' => 'remember'],
        'first_name' => ['label' => 'first_name', 'placeholder' => 'first_name', 'helper_text' => 'first_name', 'description' => 'first_name'],
        'last_name' => ['label' => 'last_name', 'placeholder' => 'last_name', 'helper_text' => 'last_name', 'description' => 'last_name'],
        'password_confirmation' => ['label' => 'password_confirmation', 'placeholder' => 'password_confirmation', 'helper_text' => 'password_confirmation', 'description' => 'password_confirmation'],
    ],
    'actions' => [
        'showPassword' => ['label' => 'showPassword', 'icon' => 'showPassword', 'tooltip' => 'showPassword'],
        'hidePassword' => ['label' => 'hidePassword', 'icon' => 'hidePassword', 'tooltip' => 'hidePassword'],
    ],
];
