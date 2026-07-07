<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\Traits\HasGdpr;

/** Probe host so PHPStan analyses HasGdpr trait. */
final class HasGdprDummy extends Model
{
    use HasGdpr;

    protected $table = 'gdpr_has_gdpr_dummy';

    protected $guarded = [];
}
