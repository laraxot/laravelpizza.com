<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name', 'description', 'colors', 'fonts',
        'version', 'is_active',
    ];

    protected $casts = [
        'colors' => 'array',
        'fonts' => 'array',
    ];
}
