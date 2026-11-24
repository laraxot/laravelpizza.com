<?php

declare(strict_types=1);

namespace Modules\UI\Services;

<<<<<<< .merge_file_QvbIef
use Modules\Xot\Actions\File\AssetAction;

/**
 * SUPERSEDED — non usare. Residuo on-disk (no-delete senza autorizzazione).
 *
 * `asset()` era solo passthrough di {@see AssetAction}.
=======
/**
 * SUPERSEDED — non usare. Residuo on-disk (no-delete senza autorizzazione).
 *
 * `asset()` era solo passthrough di {@see \Modules\Xot\Actions\File\AssetAction}.
>>>>>>> .merge_file_SXJq8L
 * Zero caller di produzione. Chiamare direttamente:
 * `app(\Modules\Xot\Actions\File\AssetAction::class)->execute($path)`.
 *
 * @deprecated Use AssetAction instead.
 */
<<<<<<< .merge_file_QvbIef
final class UIService {}
=======
final class UIService
{
}
>>>>>>> .merge_file_SXJq8L
