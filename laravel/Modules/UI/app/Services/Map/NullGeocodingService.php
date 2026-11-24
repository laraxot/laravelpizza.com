<?php

declare(strict_types=1);

namespace Modules\UI\Services\Map;

<<<<<<< .merge_file_IAMXCW
use Modules\UI\Adapters\Map\NullGeocodingServiceAdapter;

/**
 * SUPERSEDED — duplicato di {@see NullGeocodingServiceAdapter}.
=======
/**
 * SUPERSEDED — duplicato di {@see \Modules\UI\Adapters\Map\NullGeocodingServiceAdapter}.
>>>>>>> .merge_file_kBgd51
 *
 * Zero binding in UIServiceProvider; zero caller. Canonico: Adapters/Map/.
 * Residuo on-disk (no-delete senza autorizzazione). Vedi debt.php #247.
 *
 * @deprecated Use NullGeocodingServiceAdapter instead.
 */
<<<<<<< .merge_file_IAMXCW
final class NullGeocodingService {}
=======
final class NullGeocodingService
{
}
>>>>>>> .merge_file_kBgd51
