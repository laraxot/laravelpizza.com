<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Schemas\Components;

use Filament\Schemas\Components\Group;

/**
 * Base class for custom Group components following Laraxot philosophy.
 *
 * In the Laraxot framework, all custom Group components should extend
 * XotBaseGroup instead of directly extending Filament\Schemas\Components\Group.
 * This ensures consistency with the framework's architecture and provides
 * a foundation for common Group functionality across the application.
 *
 * @method static static make(string|array|null $name = null) Create a new instance of the component
 */
abstract class XotBaseGroup extends Group
{
    protected function setUp(): void
    {
        parent::setUp();
        // Common setup for all XotBaseGroup components can be added here.
    }
}
