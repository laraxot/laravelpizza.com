<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\Traits\HasCommonScopes;

/**
 * Lightweight fixture model to unit test HasCommonScopes in isolation,
 * without touching a real database (query builder SQL is inspected instead
 * of executed for the scope methods; the boolean helpers run pure PHP).
 */
class HasCommonScopesProbe extends Model
{
    use HasCommonScopes;

    protected $table = 'has_common_scopes_probes';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];
}
