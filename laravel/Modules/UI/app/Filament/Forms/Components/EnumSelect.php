<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

/**
 * EnumSelect - Reusable component for PHP-backed enums in Filament v5.
 */
final class EnumSelect extends Select
{
    protected string|\Closure|null $enumClass = null;

    protected bool $showIcons = false;

    protected bool $allowHtml = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->native(false);

        $this->options(fn (): array => $this->generateOptions());
    }

    /**
     * Create a new EnumSelect component.
     * Signature must match Filament\\Forms\\Components\\Field::make(?string $name = null).
     */
    public static function make(?string $name = null): static
    {
        /** @var static $component */
        $component = parent::make($name);

        return $component->native(false);
    }

    public function enum(string|\Closure|null $enum): static
    {
        $this->enumClass = $enum;

        return $this;
    }

    public function icons(bool $show = true): static
    {
        $this->showIcons = $show;

        return $this;
    }

    public function htmlLabels(bool $allow = true): static
    {
        $this->allowHtml = $allow;

        return $this;
    }

    public function getEnumClass(): ?string
    {
        $enumClass = $this->evaluate($this->enumClass);

        return is_string($enumClass) && '' !== $enumClass ? $enumClass : null;
    }

    public function hasIcons(): bool
    {
        return $this->showIcons;
    }

    public function allowsHtml(): bool
    {
        return $this->allowHtml;
    }

    public function placeholderWhenNoSelection(string $placeholder): static
    {
        $this->placeholder($placeholder);

        return $this;
    }

    public function convertToEnum(mixed $value): ?\BackedEnum
    {
        $enumClass = $this->getEnumClass();

        if (null === $enumClass || null === $value || '' === $value) {
            return null;
        }

        if (! is_int($value) && ! is_string($value)) {
            return null;
        }

        $this->validateEnumClass($enumClass);
        /** @var class-string<\BackedEnum> $enumClass */
        $enum = $enumClass::tryFrom($value);

        return $enum instanceof \BackedEnum ? $enum : null;
    }

    protected function generateOptions(): array
    {
        $enumClass = $this->evaluate($this->enumClass);

        if (! is_string($enumClass) || '' === $enumClass) {
            return [];
        }

        $this->validateEnumClass($enumClass);
        /** @var class-string<\BackedEnum> $enumClass */
        $options = [];

        foreach ($enumClass::cases() as $case) {
            if (! $case instanceof \BackedEnum) {
                continue;
            }

            $options[$case->value] = $this->formatOption($case);
        }

        return $options;
    }

    protected function formatOption(\BackedEnum $case): string
    {
        $label = $this->getCaseLabel($case);
        $icon = $this->showIcons ? $this->getCaseIcon($case) : null;

        if ($this->allowHtml) {
            return $this->formatHtmlLabel($label, $icon);
        }

        return $label;
    }

    protected function getCaseLabel(\BackedEnum $case): string
    {
        if ($case instanceof HasLabel) {
            $label = $case->getLabel();

            if (is_string($label) && '' !== $label) {
                return $label;
            }
        }

        if (method_exists($case, 'label')) {
            $label = $case->label();
            if (is_string($label) && '' !== $label) {
                return $label;
            }
        }

        return $case->name;
    }

    protected function getCaseIcon(\BackedEnum $case): ?string
    {
        if (! $this->showIcons) {
            return null;
        }

        if ($case instanceof HasIcon) {
            $icon = $case->getIcon();

            return is_string($icon) && '' !== $icon ? $icon : null;
        }

        if (method_exists($case, 'icon')) {
            $icon = $case->icon();

            return is_string($icon) && '' !== $icon ? $icon : null;
        }

        return null;
    }

    protected function formatHtmlLabel(string $label, ?string $icon): string
    {
        if (! $icon) {
            return $label;
        }

        if (str_starts_with($icon, '<svg')) {
            return '<span class="flex items-center gap-2"><span class="inline-flex">'.$icon.'</span>'.$label.'</span>';
        }

        return '<span class="flex items-center gap-2"><i class="'.$icon.'"></i>'.$label.'</span>';
    }

    protected function validateEnumClass(string $enumClass): void
    {
        if (! enum_exists($enumClass)) {
            throw new \InvalidArgumentException("Enum class [{$enumClass}] does not exist.");
        }

        if (! is_subclass_of($enumClass, \BackedEnum::class)) {
            throw new \InvalidArgumentException("Enum class [{$enumClass}] must be a backed enum.");
        }
    }
}
