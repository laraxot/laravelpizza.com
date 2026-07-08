<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Radio;

/**
 * Base class for custom Radio components following Laraxot philosophy.
 *
 * In the Laraxot framework, all custom Radio components should extend
 * XotBaseRadio instead of directly extending Filament\Forms\Components\Radio.
 * This ensures consistency with the framework's architecture and provides
 * a foundation for common Radio functionality across the application.
 *
 * @method static static make(string $name) Create a new instance of the component
 */
abstract class XotBaseRadio extends Radio
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
