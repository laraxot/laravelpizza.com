<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Modules\Rating\Models\Traits\HasLikes;

/**
 * Anchor PHPStan per {@see HasLikes}: like/dislike su modelli host.
 * Stesso motivo di {@see AbstractRatingsHost} / {@see AbstractHasRatingHost}.
 *
 * @see Modules/Rating/docs/wiki/concepts/phpstan-compliance.md
 */
final class AbstractLikeableHost extends BaseModel
{
    use HasLikes;
}
