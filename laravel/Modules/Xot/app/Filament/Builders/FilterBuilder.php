<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Builders;

use Filament\Forms\Components\DatePicker;
use Modules\User\Models\User;
use Filament\Forms;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use function Safe\strtotime;

/**
 * Filter Builder for common Filament table filters.
 *
 * Provides standardized filter definitions to reduce code duplication
 * across List pages in all modules.
 *
 * Usage:
 * ```php
 * public function getTableFilters(): array
 * {
 *     return [
 *         FilterBuilder::activeToggle(),
 *         FilterBuilder::selectFromModel('category', Category::class),
 *     ];
 * }
 * ```
 */
class FilterBuilder
{
    /**
     * Active/Inactive ternary filter.
     */
    public static function activeToggle(string $column = 'is_active'): TernaryFilter
    {
        return TernaryFilter::make($column)
            ->label('Status')
            ->placeholder('All')
            ->trueLabel('Active')
            ->falseLabel('Inactive');
    }

    /**
     * Published/Unpublished ternary filter.
     */
    public static function publishedToggle(string $column = 'is_published'): TernaryFilter
    {
        return TernaryFilter::make($column)
            ->label('Published')
            ->placeholder('All')
            ->trueLabel('Published')
            ->falseLabel('Unpublished');
    }

    /**
     * Featured/Not Featured ternary filter.
     */
    public static function featuredToggle(string $column = 'is_featured'): TernaryFilter
    {
        return TernaryFilter::make($column)
            ->label('Featured')
            ->placeholder('All')
            ->trueLabel('Featured')
            ->falseLabel('Not Featured');
    }

    /**
     * Generic boolean ternary filter.
     */
    public static function booleanToggle(
        string $column,
        string $label,
        string $trueLabel = 'Yes',
        string $falseLabel = 'No'
    ): TernaryFilter {
        return TernaryFilter::make($column)
            ->label($label)
            ->placeholder('All')
            ->trueLabel($trueLabel)
            ->falseLabel($falseLabel);
    }

    /**
     * Date range filter.
     */
    public static function dateRange(string $column = 'created_at', string $label = 'Date Range'): Filter
    {
        return Filter::make($column)
            ->schema([
                DatePicker::make('from')
                    ->label('From'),
                DatePicker::make('until')
                    ->label('Until'),
            ])
            ->query(function (Builder $query, array $data) use ($column): Builder {
                return $query
                    ->when(
                        $data['from'] ?? null,
                        fn (Builder $query, mixed $date): Builder => $query->whereDate($column, '>=', is_string($date) ? $date : (string) $date),
                    )
                    ->when(
                        $data['until'] ?? null,
                        fn (Builder $query, mixed $date): Builder => $query->whereDate($column, '<=', is_string($date) ? $date : (string) $date),
                    );
            })
            ->indicateUsing(function (array $data) use ($label): ?string {
                $from = $data['from'] ?? null;
                $until = $data['until'] ?? null;

                if (! $from && ! $until) {
                    return null;
                }

                if ($from && $until) {
                    $fromStr = is_string($from) ? $from : (string) $from;
                    $untilStr = is_string($until) ? $until : (string) $until;

                    return $label.': '.date('d/m/Y', strtotime($fromStr)).' - '.date('d/m/Y', strtotime($untilStr));
                }

                if ($from) {
                    $fromStr = is_string($from) ? $from : (string) $from;

                    return $label.' from: '.date('d/m/Y', strtotime($fromStr));
                }

                if ($until) {
                    $untilStr = is_string($until) ? $until : (string) $until;

                    return $label.' until: '.date('d/m/Y', strtotime($untilStr));
                }

                return null;
            });
    }

    /**
     * Created at date range filter.
     */
    public static function createdAtRange(): Filter
    {
        return self::dateRange('created_at', 'Created Date');
    }

    /**
     * Updated at date range filter.
     */
    public static function updatedAtRange(): Filter
    {
        return self::dateRange('updated_at', 'Updated Date');
    }

    /**
     * Published at date range filter.
     */
    public static function publishedAtRange(): Filter
    {
        return self::dateRange('published_at', 'Published Date');
    }

    /**
     * Select filter from model.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function selectFromModel(
        string $name,
        string $modelClass,
        string $labelColumn = 'name',
        string $valueColumn = 'id',
        ?string $relationshipName = null
    ): SelectFilter {
        /** @var array<int|string, string> $options */
        $options = $modelClass::pluck($labelColumn, $valueColumn)->toArray();

        $filter = SelectFilter::make($name)
            ->options($options);

        if ($relationshipName !== null) {
            $filter->relationship($relationshipName, $labelColumn);
        }

        return $filter;
    }

    /**
     * Status select filter with common statuses.
     *
     * @param  array<string, string>  $customStatuses
     */
    public static function statusSelect(array $customStatuses = []): SelectFilter
    {
        $defaultStatuses = [
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ];

        return SelectFilter::make('status')
            ->options(array_merge($defaultStatuses, $customStatuses));
    }

    /**
     * Priority select filter.
     *
     * @param  array<string, string>  $customPriorities
     */
    public static function prioritySelect(array $customPriorities = []): SelectFilter
    {
        $defaultPriorities = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'critical' => 'Critical',
        ];

        return SelectFilter::make('priority')
            ->options(array_merge($defaultPriorities, $customPriorities));
    }

    /**
     * Type select filter.
     *
     * @param  array<string, string>  $types
     */
    public static function typeSelect(array $types): SelectFilter
    {
        return SelectFilter::make('type')
            ->options($types);
    }

    /**
     * Category select filter.
     *
     * @param  class-string<Model>  $categoryModel
     */
    public static function categorySelect(string $categoryModel, string $labelColumn = 'name'): SelectFilter
    {
        return self::selectFromModel('category', $categoryModel, $labelColumn, 'id', 'category');
    }

    /**
     * User/Author select filter.
     *
     * @param  class-string<Model>  $userModel
     */
    public static function userSelect(
        string $name = 'user',
        string $userModel = User::class,
        string $labelColumn = 'name'
    ): SelectFilter {
        return self::selectFromModel($name, $userModel, $labelColumn, 'id', $name);
    }

    /**
     * Trashed filter (for SoftDeletes).
     *
     * Note: This filter assumes the model uses SoftDeletes trait.
     * PHPStan may not recognize withTrashed/onlyTrashed methods on base Builder.
     *
     * @phpstan-ignore-next-line
     */
    public static function trashedFilter(): TernaryFilter
    {
        return TernaryFilter::make('trashed')
            ->label('Deleted')
            ->placeholder('Without trashed')
            ->trueLabel('Only trashed')
            ->falseLabel('Without trashed')
            ->queries(
                /** @phpstan-ignore-next-line */
                true: fn (Builder $query) => $query->onlyTrashed(),
                /** @phpstan-ignore-next-line */
                false: fn (Builder $query) => $query->withoutTrashed(),
                /** @phpstan-ignore-next-line */
                blank: fn (Builder $query) => $query->withTrashed(),
            );
    }
}
