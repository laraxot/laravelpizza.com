<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Select as FilamentSelect;

/**
 * Base class for custom Select components following Laraxot philosophy.
 *
 * In the Laraxot framework, all custom Select components should extend
 * XotBaseSelect instead of directly extending Filament\Forms\Components\Select.
 * This ensures consistency with the framework's architecture and provides
 * a foundation for common Select functionality across the application.
 *
 * @method static static make(string $name) Create a new instance of the component
 */
abstract class XotBaseSelect extends FilamentSelect
{
    protected function setUp(): void
    {
        parent::setUp();
        // Common setup for all XotBaseSelect components can be added here.
    }
}
