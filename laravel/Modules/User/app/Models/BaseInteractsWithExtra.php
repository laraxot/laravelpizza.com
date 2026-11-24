<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\InteractsWithExtra as XotInteractsWithExtra;

/**
 * Alias User verso lo SSoT Xot (HasExtraTrait).
 */
abstract class BaseInteractsWithExtra extends XotInteractsWithExtra {}
