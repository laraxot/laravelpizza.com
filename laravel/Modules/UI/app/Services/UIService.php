<?php

declare(strict_types=1);

namespace Modules\UI\Services;

<<<<<<< HEAD
use Modules\Xot\Actions\File\AssetAction;

final class UIService
{
    public static function asset(string $asset): string
    {
        return app(AssetAction::class)->execute($asset);
    }
=======
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
>>>>>>> laraxot/dev
}
