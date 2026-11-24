<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Policies;

use Modules\Xot\Models\Policies\Concerns\RequiresOperationalPermissions;
use Modules\Xot\Models\Policies\XotBasePolicy;

/**
 * Policy minima che usa solo il trait `RequiresOperationalPermissions`: serve a provare, senza
 * dipendere da un modulo operativo (Roosko vive in un altro progetto), che il ruolo del pannello
 * non bypassa i permessi operativi.
 *
 * @see Modules/Xot/docs/wiki/decisions/module-admin-role-policy-bypass.md perche' il trait esiste e cosa il test protegge
 */
final class OperationalPermissionsPolicyProbe extends XotBasePolicy
{
    use RequiresOperationalPermissions;
}
