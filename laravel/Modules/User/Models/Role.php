<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasXotFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    public static function firstOrCreate(array $attributes, array $values = []): self
    {
        // @phpstan-ignore-next-line
        return parent::firstOrCreate($attributes, $values);
    }
}
