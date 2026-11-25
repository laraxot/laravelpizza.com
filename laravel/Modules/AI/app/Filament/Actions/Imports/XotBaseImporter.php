<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Imports;

use Filament\Actions\Imports\Importer as FilamentImporter;

/**
 * Base class for Importer.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's Importer to provide a XotBase layer.
 */
abstract class XotBaseImporter extends FilamentImporter {}
