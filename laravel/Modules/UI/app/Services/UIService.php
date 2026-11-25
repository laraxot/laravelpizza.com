<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\Xot\Actions\File\AssetAction;

/**
 * SUPERSEDED — non usare. Residuo on-disk (no-delete senza autorizzazione).
 *
 * `asset()` era solo passthrough di {@see AssetAction}.
 * Zero caller di produzione. Chiamare direttamente:
 * `app(\Modules\Xot\Actions\File\AssetAction::class)->execute($path)`.
 *
 * @deprecated Use AssetAction instead.
 * @see Modules/UI/docs/philosophy.md
 */
final class UIService {}
