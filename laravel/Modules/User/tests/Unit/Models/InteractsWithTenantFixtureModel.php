<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Traits\InteractsWithTenant;

final class InteractsWithTenantFixtureModel extends Model
{
    use InteractsWithTenant;

    protected $table = 'worksites';

    protected $guarded = [];
}
