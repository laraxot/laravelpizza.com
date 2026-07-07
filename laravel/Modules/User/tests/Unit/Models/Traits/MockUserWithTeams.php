<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Traits\HasTeams;
use Modules\Xot\Models\Traits\RelationX;

/**
 * Modello di supporto per i test del trait HasTeams.
 */
class MockUserWithTeams extends Model
{
    use HasTeams;
    use RelationX;

    protected $table = 'users';

    protected $fillable = ['name', 'email'];

    public function getKey(): int
    {
        return 1;
    }
}
