<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\ExtraContract;
use Modules\Xot\Models\Traits\HasExtraTrait;

/**
 * Concrete probe for HasExtraTrait unit tests.
 *
 * @property ExtraContract|null $extra
 */
class HasExtraTraitProbeModel extends Model
{
    use HasExtraTrait;

    protected $table = 'has_extra_trait_probes';

    /** @var list<string> */
    protected $fillable = ['name'];
}
