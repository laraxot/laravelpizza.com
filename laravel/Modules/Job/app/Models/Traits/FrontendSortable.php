<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FrontendSortable
{
    /**
     * @param  array<string, string>  $defaultSort
     * @param  array<string>  $sortableColumns
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
                    $query->orderBy($key, $direction);
                }
            },
        );
    }
}
