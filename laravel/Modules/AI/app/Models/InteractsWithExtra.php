<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Modules\Xot\Models\Traits\HasExtraTrait;

/**
 * Base per modelli che espongono la relazione morphOne Extra.
 */
abstract class InteractsWithExtra extends BaseModel
{
    use HasExtraTrait;
}
