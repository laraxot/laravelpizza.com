<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages\Tenancy;

use Filament\Pages\Tenancy\RegisterTenant as FilamentRegisterTenant;

/**
 * Base class for RegisterTenant.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's RegisterTenant to provide a XotBase layer.
 */
abstract class XotBaseRegisterTenant extends FilamentRegisterTenant {}
