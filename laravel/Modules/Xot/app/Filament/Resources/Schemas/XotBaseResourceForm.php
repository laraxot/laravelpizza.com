<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class XotBaseResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getFormSchema())
            ->columns(static::getFormSchemaColumns());
    }

    public static function getFormSchemaColumns(): int
    {
        return 1;
    }

    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
        ];
    }

    public static function getWizardSteps(): array
    {
        return [];
    }

    protected static function getStepByName(string $name): Step
    {
        $methodName = Str::of($name)
            ->snake()
            ->studly()
            ->prepend('get')
            ->append('Schema')
            ->toString();
        $module_low = Str::of(static::class)->between('Modules\\', '\\Filament')->lower()->toString();
        $group = Str::of(class_basename(static::class))->kebab()->toString();
        $base_key = $module_low.'::'.$group.'.steps.';

        $labelKey = $base_key.$name.'.label';
        $descriptionKey = $base_key.$name.'.description';

        if (method_exists(static::class, $methodName)) {
            $schemaResult = static::$methodName();
            /** @var array<int, SchemaComponent> $schemaComponents */
            $schemaComponents = \is_array($schemaResult) ? array_values($schemaResult) : [];

            return Step::make(__($labelKey))
                ->label(__($labelKey))
                ->description(__($descriptionKey))
                ->schema($schemaComponents);
        }
        dddx($methodName);

        return Step::make(__($labelKey))->schema([]);
    }
}
