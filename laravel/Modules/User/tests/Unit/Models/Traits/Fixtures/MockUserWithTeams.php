<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models\Traits\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Traits\HasTeams;

class MockUserWithTeams extends Model
{
    use HasTeams;

    protected $table = 'users';

    protected $fillable = ['name', 'email'];

    public function getKey(): int
    {
        return 1;
    }
}
