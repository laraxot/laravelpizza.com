<?php

declare(strict_types=1);

namespace Modules\Xot\Traits\Filament;

use Illuminate\Support\Str;

trait HasCustomModelLabel
{
    /**
     * Get the plural label of the resource.
     */
    public static function getPluralModelLabel(): string
    {
        $label = static::$pluralModelLabel ?? Str::plural(static::getModelLabel());

        return __($label);
    }

    /**
     * Get the singular label of the resource.
     */
    public static function getModelLabel(): string
    {
        if (isset(static::$modelLabel)) {
            return __(static::$modelLabel);
        }

        return __(Str::title(Str::snake(class_basename(static::getModel()), ' ')));
    }

    /**
     * Get the navigation label of the resource.
     */
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::getPluralModelLabel();
    }

    /**
     * Get the breadcrumb of the resource.
     */
    public static function getBreadcrumb(): string
    {
        return static::getModelLabel();
    }
}
