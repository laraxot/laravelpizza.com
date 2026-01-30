<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name', 'description', 'colors', 'fonts',
        'version', 'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'colors' => 'array',
            'fonts' => 'array',
        ];
    }
}
