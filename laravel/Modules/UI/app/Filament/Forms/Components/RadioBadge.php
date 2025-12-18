<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use BackedEnum;
use Filament\Forms\Components\Radio;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Webmozart\Assert\Assert;

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
        if (! is_string($this->options)) {
            return null;
        }
        if (! enum_exists($this->options)) {
            return null;
        }
        /** @var class-string<\UnitEnum> $enumClass */
        $enumClass = $this->options;

        // Verifica che sia un BackedEnum
        if (! is_subclass_of($enumClass, \BackedEnum::class)) {
            return null;
        }

        // Verifica che implementi le interfacce richieste
        if (! is_subclass_of($enumClass, HasColor::class) || ! is_subclass_of($enumClass, HasIcon::class)) {
            return null;
        }

        /** @var class-string<\BackedEnum&HasColor&HasIcon> $enumClass */
        $res = $enumClass::tryFrom($value);

        return $res;
    }

    public function getColorForOption(string $value): string
    {
        Assert::nullOrString($color = $this->getEnumValue($value)?->getColor());

        return $color ?? $this->selectedColor;
    }

    public function getIconForOption(string $value): ?string
    {
        $icon = $this->getEnumValue($value)?->getIcon();

        // getIcon() può restituire Htmlable|string|null, ma dobbiamo restituire solo string|null
        if (null === $icon) {
            return null;
        }

        if (is_string($icon)) {
            return $icon;
        }

        // Se è Htmlable, convertilo a string
        if (is_object($icon) && method_exists($icon, '__toString')) {
            return (string) $icon;
        }

        return null;
    }

    public function defaultColor(string $color): static
    {
        $this->defaultColor = $color;

        return $this;
    }

    public function selectedColor(string $color): static
    {
        $this->selectedColor = $color;

        return $this;
    }
}
