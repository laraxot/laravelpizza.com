<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FrontendSortable
{
    /**
     * @param  Builder<static>  $query
     * @param  array<string>  $sortableColumns
     * @param  array<string, 'asc'|'desc'>  $defaultSort
     * @return Builder<static>
     */
    public function scopeSortableBy(
        Builder $query,
        array $sortableColumns,
        array $defaultSort = ['name' => 'asc'],
    ): Builder {
        $request = request();
        $sorted = $request->has('sort_by') && in_array($request->input('sort_by'), $sortableColumns, false);

        /**
         * @var string $sortByRequest
         */
        $sortByRequest = $request->input('sort_by');
        /**
         * @var string $sortDirectionRequest
         */
        $sortDirectionRequest = $request->input('sort_direction', 'asc');

        return $query->when(
            $sorted,
            static function (Builder $query) use ($sortByRequest, $sortDirectionRequest): void {
                $query->orderBy((string) $sortByRequest, ((string) $sortDirectionRequest) === 'desc' ? 'desc' : 'asc');
            },
            static function (Builder $query) use ($defaultSort): void {
                foreach ($defaultSort as $key => $direction) {
                    /** @var 'asc'|'desc' $direction */
                    $direction = in_array($direction, ['asc', 'desc'], true) ? $direction : 'asc';
                    $query->orderBy($key, $direction);
                }
            },
        );
    }
}
