<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Modules\Xot\Models\Module;

/**
 * Stato enabled/disabled di {@see Module} (Sushi registry nwidart).
 */
trait ModuleStatus
{
    public function isEnabled(): bool
    {
        if ($this->enabled !== null) {
            return (bool) $this->enabled;
        }

        if ($this->status !== null) {
            return (bool) $this->status;
        }

        return (bool) ($this->is_active ?? false);
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }
}
