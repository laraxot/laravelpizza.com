<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\AttachAction as FilamentAttachAction;

/**
 * Base class for AttachAction.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's AttachAction to provide a XotBase layer.
 */
abstract class XotBaseAttachAction extends FilamentAttachAction
{
    // ...
}
