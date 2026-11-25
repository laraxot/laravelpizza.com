<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Models\Policies\Concerns\RequiresOperationalPermissions;

/**
 * Base policy per moduli con permessi operativi (non bypass `{modulo}::admin`).
 *
 * Estesa dalle policy Roosko/Waste/Warehouse/Processing/Weighing/Labeling/Rentri.
 * ADR: `docs/wiki/decisions/module-admin-role-policy-bypass.md`.
 */
abstract class OperationalXotBasePolicy extends XotBasePolicy
{
    use RequiresOperationalPermissions;
}
