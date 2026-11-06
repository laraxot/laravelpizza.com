<?php

declare(strict_types=1);

namespace Modules\Gdpr\Datas;

use Modules\Gdpr\Enums\CookieCategory;
use Spatie\LaravelData\Data;

/**
 * Un cookie dell'inventario: `purpose` e `duration` sono gia' tradotti nella lingua della richiesta.
 */
final class CookieData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly CookieCategory $category,
        public readonly string $purpose,
        public readonly string $duration,
    ) {}
}
