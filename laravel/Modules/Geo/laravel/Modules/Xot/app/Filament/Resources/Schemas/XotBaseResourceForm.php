<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
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
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
        ];
    }

    /**
     * Elenco degli step Wizard per form multi‑passaggio (nome ufficiale allineato a Filament **`HasWizard::getSteps()`**).
     * I form lineari lo lasciano vuoto.
     *
     * @return array<string, Step>
     */
    public static function getSteps(): array
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

        if (method_exists(static::class, $methodName)) {
            $schemaResult = static::$methodName();
            /** @var array<Htmlable|string> $schemaComponents */
            $schemaComponents = \is_array($schemaResult) ? array_values($schemaResult) : [];

            return Step::make($name)->schema($schemaComponents);
        }
        dddx($methodName);

        return Step::make($name)->schema([]);
    }
}
