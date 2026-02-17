<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * ResolveBlockQueryAction: Resolves dynamic data for CMS blocks based on query configuration.
 */
class ResolveBlockQueryAction
{
    use QueueableAction;

    /**
     * Executes the query path specified in block data and returns the result.
     *
     * @param  array<string, mixed>  $queryConfig  Configuration: [model, scopes, orderBy, limit, wrap_in]
     * @return array<string, mixed> The transformed data to be merged into block data
     */
    public function execute(array $queryConfig): array
    {
        $modelClass = Arr::get($queryConfig, 'model');
        if ($modelClass === null || ! is_string($modelClass) || ! class_exists($modelClass)) {
            return [];
        }

        /** @var Model $modelInstance */
        $modelInstance = new $modelClass;
        $query = $modelInstance->newQuery();

        // Apply scopes
        /** @var array<int, string> $scopes */
        $scopes = (array) Arr::get($queryConfig, 'scopes', []);
        foreach ($scopes as $scope) {
            if (is_string($scope) && method_exists($query, 'scope'.ucfirst($scope))) {
                $query->{$scope}();
            }
        }

        // Apply ordering
        $orderBy = Arr::get($queryConfig, 'orderBy', 'created_at');
        Assert::string($orderBy, '['.__LINE__.']['.__FILE__.']');
        $direction = Arr::get($queryConfig, 'direction', 'desc');
        Assert::string($direction, '['.__LINE__.']['.__FILE__.']');
        $query->orderBy($orderBy, $direction);

        // Apply limit
        $limit = (int) Arr::get($queryConfig, 'limit', 10);
        $query->limit($limit);

        /** @var Collection<int, Model> $results */
        $results = $query->get();

        // Transform results if model has toBlockArray
        $transformedItems = $results->map(function (Model $item): array {
            if (method_exists($item, 'toBlockArray')) {
                /** @var array<string, mixed> $res */
                $res = $item->toBlockArray();

                return $res;
            }

            return $item->toArray();
        })->toArray();

        $wrapIn = Arr::get($queryConfig, 'wrap_in', 'items');
        if (! is_string($wrapIn)) {
            $wrapIn = 'items';
        }

        return [$wrapIn => $transformedItems];
    }
}
