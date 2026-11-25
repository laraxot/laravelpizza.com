<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry as FilamentEntry;

/**
 * Base class for Entry.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's Entry to provide a XotBase layer.
 */
abstract class XotBaseEntry extends FilamentEntry {}
