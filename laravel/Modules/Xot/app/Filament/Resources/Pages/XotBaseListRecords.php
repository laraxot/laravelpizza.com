<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as FilamentListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Actions\ModelClass\UpdateCountAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Traits\HasXotTable;
use Webmozart\Assert\Assert;

/**
 * Base class for list records pages.
 *
 * @property ?string         $model
 * @property ?string         $resource
 * @property ?string         $slug
 * @property TableLayoutEnum $layoutView
 */
abstract class XotBaseListRecords extends FilamentListRecords
{
    use HasXotTable;

    /**
     * @param array<string, bool|float|int|string|null> $params
     */
    public static function trans(string $key, array $params = []): string
    {
        $resourceClass = static::getResource();

        return $resourceClass::trans($key, false, $params);
    }

    /**
     * Get the resource class name.
     *
     * @return class-string<XotBaseResource>
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);
        Assert::subclassOf($resource, XotBaseResource::class);

        return $resource;
    }

    /*
     * Get the table columns.
     *
     * @return array<string, Tables\Columns\Column>
     *
     * abstract public function getTableColumns(): array;
     */

    /**
     * Get the default sort column and direction.
     *
     * @return array{id: 'desc'|'asc'}
     */
    protected function getDefaultSort(): array
    {
        return ['id' => 'desc'];
    }

    /**
     * Get the header actions.
     *
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }

    /**
     * Paginate the table query.
     *
     * @param Builder<Model> $query
     *
     * @return Paginator<int, Model>
     */
    protected function paginateTableQueryOLD(Builder $query): Paginator
    {
        $perPage = $this->getTableRecordsPerPage();
        $perPageValue = 'all' === $perPage ? $query->count() : (is_numeric($perPage) ? (int) $perPage : null);

        $paginator = $query->paginate($perPageValue);

        Assert::isInstanceOf($paginator, Paginator::class);

        if (! method_exists($paginator, 'total')) {
            return $paginator;
        }

        $totalResult = $paginator->total();
        $count = is_int($totalResult) ? $totalResult : (is_numeric($totalResult) ? (int) $totalResult : 0);
        $modelClass = $this->getModel();
        // dddx($modelClass);
        app(UpdateCountAction::class)->execute($modelClass, $count);

        return $paginator;
    }
}
