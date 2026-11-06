<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\ManageRecords as FilamentManageRecords;

/**
 * Base class for ManageRecords.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's ManageRecords to provide a XotBase layer.
 */
abstract class XotBaseManageRecords extends FilamentManageRecords {}
