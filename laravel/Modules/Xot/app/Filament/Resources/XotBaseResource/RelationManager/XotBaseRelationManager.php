<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\XotBaseResource\RelationManager;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Components\Component;
use Filament\Tables;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Traits\HasXotTable;

/**
 * @property class-string<XotBaseResource> $resource
 */
abstract class XotBaseRelationManager extends RelationManager
{
    use HasXotTable;

    protected static string $relationship = '';

    /**
     * @var class-string<XotBaseResource>
     */
    protected static string $resource;

    public static function getModuleName(): string
    {
        return Str::between(static::class, 'Modules\\', '\Filament');
    }

    public static function getNavigationLabel(): string
    {
        return __(static::class.'.navigation.label');
    }

    public static function getNavigationGroup(): string
    {
        return __(static::class.'.navigation.group');
    }

    // final public function form(Schema $schema): Schema
    // {
    //     return $schema->components($getFormSchema());
    // }
    /**
     * Get form schema.
     *
     * @return array<string|int, Component>
     */
    final public function getFormSchema(): array
    {
        return $this->getResource();
    }

    /**
     * Get table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [];

        // return $this->getResource();
    }

    protected static function getPluralModelLabel(): string
    {
        return __(static::class.'.plural_model_label');
    }

    // public function table(Table $table): Table
    // {
    //     /** @var class-string<Model> $resource */
    //     $resource = $this->getResource();
    //     Assert::classExists($resource);
    //     if (method_exists($resource, 'getTableColumns')) {
    //         /** @var array<string, Tables\Columns\Column> $columns */
    //         $columns = $resource::getTableColumns();
    //         return $table->columns($columns);
    //     }
    //     return $table->columns($getTableColumns());
    // }
    // /**
    //  * Get table columns.
    //  *
    //  * @return array<string, Tables\Columns\Column>
    //  */
    // protected function getTableColumns(): array
    // {
    //     return [];
    // }
    /**
     * Get the resource class.
     *
     * @return class-string<XotBaseResource>
     */
    protected function getResource(): string
    {
        // Use static property if available
        if (isset(static::$resource) && is_string(static::$resource)) {
            if (is_subclass_of(static::$resource, XotBaseResource::class)) {
                /* @var class-string<XotBaseResource> */
                return static::$resource;
            }
        }

        // Fallback: derive the resource class name from the relation manager name
        $class = static::class;
        $resourceName = Str::of(class_basename($this))
            ->beforeLast('RelationManager')
            ->singular()
            ->append('Resource')
            ->toString();
        $ns = Str::of($class)
            ->before('Resources\\')
            ->append('Resources\\')
            ->toString();
        $resourceClass = $ns.$resourceName;

        if (! class_exists($resourceClass)) {
            throw new \Exception("Cannot find resource class {$resourceClass}");
        }

        if (! is_subclass_of($resourceClass, XotBaseResource::class)) {
            throw new \Exception("{$resourceClass} must extend XotBaseResource");
        }

        /* @var class-string<XotBaseResource> $resourceClass */
        return $resourceClass;
    }
}
