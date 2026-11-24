<?php

declare(strict_types=1);

namespace Modules\UI\Services\Map;

use Modules\UI\Adapters\Map\NullMapServiceAdapter;

/**
 * SUPERSEDED — duplicato di {@see NullMapServiceAdapter}.
 *
 * Zero binding in UIServiceProvider; zero caller. Canonico: Adapters/Map/.
 * Residuo on-disk (no-delete senza autorizzazione). Vedi debt.php #247.
 *
 * @deprecated Use NullMapServiceAdapter instead.
 */
final class NullMapService {}
