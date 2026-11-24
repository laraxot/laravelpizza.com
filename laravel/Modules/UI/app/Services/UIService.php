<?php

declare(strict_types=1);

namespace Modules\UI\Services;

/**
 * SUPERSEDED — non usare. Residuo on-disk (no-delete senza autorizzazione).
 *
 * `asset()` era solo passthrough di {@see \Modules\Xot\Actions\File\AssetAction}.
 * Zero caller di produzione. Chiamare direttamente:
 * `app(\Modules\Xot\Actions\File\AssetAction::class)->execute($path)`.
 *
 * @deprecated Use AssetAction instead.
 */
final class UIService
{
}
