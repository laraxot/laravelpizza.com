<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modules\User\Models\PersonalAccessToken.
 *
 * @property int                             $id
 * @property string                          $tokenable_type
 * @property int                             $tokenable_id
 * @property string                          $name
 * @property string                          $token
 * @property string|null                     $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class PersonalAccessToken extends Model
{
    use HasXotFactory;

    protected $connection = 'user';
    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'abilities' => 'array',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
