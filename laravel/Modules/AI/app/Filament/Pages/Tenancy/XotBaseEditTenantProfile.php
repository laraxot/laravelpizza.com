<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages\Tenancy;

use Filament\Pages\Tenancy\EditTenantProfile as FilamentEditTenantProfile;

/**
 * Base class for EditTenantProfile.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's EditTenantProfile to provide a XotBase layer.
 */
abstract class XotBaseEditTenantProfile extends FilamentEditTenantProfile {}
