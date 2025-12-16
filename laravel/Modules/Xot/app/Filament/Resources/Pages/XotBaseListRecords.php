<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords as FilamentListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Actions\ModelClass\UpdateCountAction;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;

/**
 * Base class for list records pages.
 *
 * @property ?string $model
 * @property ?string $resource
 * @property ?string $slug
 * @property TableLayoutEnum $layoutView
 */
abstract class XotBaseListRecords extends FilamentListRecords
{
    use HasXotTable;
    use TransTrait;

    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    /**
     * Get the resource class name.
     *
     * @return class-string
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);

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
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            // \Filament\Actions\CreateAction::make(),
            // ExportXlsAction::make('export_xls'),
        ];
    }

    /**
     * Paginate the table query.
     */
    protected function paginateTableQuery(Builder $query): Paginator
    {
        $paginator = $query->fastPaginate(
            $this->getTableRecordsPerPage() === 'all' ? $query->count() : $this->getTableRecordsPerPage(),
        );

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
