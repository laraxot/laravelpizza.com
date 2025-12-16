<?php

declare(strict_types=1);

use Modules\User\Models\Profile;
use Modules\User\Models\User;

return [
    'adm_theme' => 'AdminLTE',
    'enable_ads' => false,
    'model' => [
        'article' => 'Modules\Blog\Models\Article',
        'category' => 'Modules\Blog\Models\Category',
        'profile' => Profile::class,
        'user' => User::class,
    ],
];
