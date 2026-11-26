<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Modules\Rating\Models\Traits\HasRating;

/**
 * Anchor PHPStan per {@see HasRating}: i consumer reali sono host cross-modulo;
 * senza una classe in `app/` il trait risulta `trait.unused` (i fixture sotto
 * `tests/` non entrano nell'analisi di `Modules`).
 *
 * @see Modules/Rating/docs/wiki/concepts/phpstan-compliance.md
 */
final class AbstractHasRatingHost extends BaseModel
{
    use HasRating;
}
