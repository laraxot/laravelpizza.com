<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name', 'subject', 'content', 'variables',
        'categories', 'version', 'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'categories' => 'array',
    ];
}
