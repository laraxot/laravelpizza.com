<?php

declare(strict_types=1);

namespace Modules\UI\Services\Map;

/**
 * SUPERSEDED — duplicato di {@see \Modules\UI\Adapters\Map\NullGeocodingServiceAdapter}.
 *
 * Zero binding in UIServiceProvider; zero caller. Canonico: Adapters/Map/.
 * Residuo on-disk (no-delete senza autorizzazione). Vedi debt.php #247.
 *
 * @deprecated Use NullGeocodingServiceAdapter instead.
 */
final class NullGeocodingService
{
}
