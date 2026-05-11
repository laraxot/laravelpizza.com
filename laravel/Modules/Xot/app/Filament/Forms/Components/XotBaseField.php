<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Modules\Xot\Actions\View\GetViewByClassAction;

/**
 * Base class for form components.
 *
 * @method static static make(string $name) Create a new instance of the component
 */
abstract class XotBaseField extends Field
{
    /**
     * Laraxot rule: subclasses must NOT declare a protected $view property.
     * The view is resolved at runtime and can be overridden by the active theme.
     *
     * @return view-string
     */
    public function getView(): string
    {
        $class = static::class;

        if (! str_starts_with($class, 'Modules\\')) {
            return parent::getView();
        }

        return app(GetViewByClassAction::class)->execute($class);
    }
}
