<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload as FilamentSpatieMediaLibraryFileUpload;

/**
 * Base class for custom Media Library upload fields following Laraxot philosophy.
 *
 * Custom upload fields extend this class instead of Filament's SpatieMediaLibraryFileUpload directly.
 *
 * @method static static make(?string $name = null) Create a new instance of the component
 */
abstract class XotBaseSpatieMediaLibraryFileUpload extends FilamentSpatieMediaLibraryFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
