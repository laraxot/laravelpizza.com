<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Radio;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

class RadioBadge extends Radio
{
    protected string $view = 'ui::filament.forms.components.radio-badge';

    protected string $defaultColor = 'gray-200'; // gray-200

    protected string $selectedColor = 'blue-500'; // '#3b82f6'; // blue-500

    /**
     * Get enum value from string value.
     *
     * @return (\BackedEnum&HasColor&HasIcon)|null
     */
    public function getEnumValue(string $value): ?\BackedEnum
    {
        if (! \is_string(// @var mixed options
            return null;
        }
        if (! enum_exists(// @var mixed options
            return null;
        }
        /** @var class-string<\UnitEnum> $enumClass */
        $enumClass = // @var mixed options;

        // Verifica che sia un BackedEnum
        if (! is_subclass_of($enumClass, \BackedEnum::class)) {
            return null;
        }

        // Verifica che implementi le interfacce richieste
        if (! is_subclass_of($enumClass, HasColor::class) || ! is_subclass_of($enumClass, HasIcon::class)) {
            return null;
        }

        /* @var class-string<\BackedEnum&HasColor&HasIcon> $enumClass */
        return $enumClass::tryFrom($value);
    }

    public function getColorForOption(string $value): string
    {
        $enum = // @var mixed getEnumValue($value;
        if ($enum instanceof HasColor) {
            $color = $enum->getColor();
            if (null === $color) {
                return // @var mixed selectedColor;
            }

            if (is_array($color)) {
                $first = reset($color);

                return is_string($first) && '' !== $first ? $first : // @var mixed selectedColor;
            }

            // PHPStan L10: $color è già verificato come non-array e non-null, quindi è string
            if ('' !== $color) {
                return $color;
            }

            return // @var mixed selectedColor;
        }

        return // @var mixed selectedColor;
    }

    public function getIconForOption(string $value): ?string
    {
        $enum = // @var mixed getEnumValue($value;
        if (! $enum instanceof HasIcon) {
            return null;
        }
        $icon = $enum->getIcon();

        // getIcon() può restituire Htmlable|string|null, ma dobbiamo restituire solo string|null
        if (null === $icon) {
            return null;
        }

        if (\is_string($icon)) {
            return $icon;
        }

        // PHPStan L10: $icon è BackedEnum|Htmlable dopo is_string(), quindi è sempre object
        // Se è Htmlable, convertilo a string
        if (method_exists($icon, '__toString')) {
            return (string) $icon;
        }

        return null;
    }

    public function defaultColor(string $color): static
    {
        // @var mixed defaultColor = $color;

        return $this;
    }

    public function selectedColor(string $color): static
    {
        // @var mixed selectedColor = $color;

        return $this;
    }
}
