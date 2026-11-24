<?php

declare(strict_types=1);

namespace Modules\UI\Services\Map;

<<<<<<< .merge_file_vY0tls
use Modules\UI\Adapters\Map\NullMapServiceAdapter;

/**
 * SUPERSEDED — duplicato di {@see NullMapServiceAdapter}.
=======
/**
 * SUPERSEDED — duplicato di {@see \Modules\UI\Adapters\Map\NullMapServiceAdapter}.
>>>>>>> .merge_file_ZxgUjp
 *
 * Zero binding in UIServiceProvider; zero caller. Canonico: Adapters/Map/.
 * Residuo on-disk (no-delete senza autorizzazione). Vedi debt.php #247.
 *
 * @deprecated Use NullMapServiceAdapter instead.
 */
<<<<<<< .merge_file_vY0tls
final class NullMapService {}
=======
final class NullMapService
{
}
>>>>>>> .merge_file_ZxgUjp
