<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\TextInput as FilamentTextInput;

/**
 * Base class for TextInput.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's TextInput to provide a XotBase layer.
 */
abstract class XotBaseTextInput extends FilamentTextInput {}
