<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Modules\Gdpr\Models\Traits\HasGdpr;

/** Probe host so PHPStan analyses HasGdpr trait in app context. */
final class GdprPhpstanTraitProbe extends BaseModel
{
    use HasGdpr;

    protected $table = 'gdpr_phpstan_trait_probe';

    /** @var list<string> */
    protected $guarded = [];
}
