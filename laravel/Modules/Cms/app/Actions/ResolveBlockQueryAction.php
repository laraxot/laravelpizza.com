<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

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
        $modelClass = data_get($queryConfig, 'model');
        if ($modelClass === null || ! is_string($modelClass) || ! class_exists($modelClass)) {
            return [];
        }

        /** @var Model $modelInstance */
        $modelInstance = new $modelClass;
        $query = $modelInstance->newQuery();

        // Apply scopes (support both 'scope' singular and 'scopes' plural)
        $singleScope = data_get($queryConfig, 'scope');
        /** @var array<int, string> $scopes */
        $scopes = (array) data_get($queryConfig, 'scopes', []);
        if ($singleScope !== null && is_string($singleScope)) {
            array_unshift($scopes, $singleScope);
        }
        foreach ($scopes as $scope) {
            if (is_string($scope) && $scope !== '') {
                // Scopes are added dynamically by Laravel, so we just try to call them
                // method_exists() won't work because they're added via __call
                try {
                    $query->{$scope}();
                } catch (\BadMethodCallException $e) {
                    // Scope doesn't exist, skip it
                }
            }
        }

        // Apply ordering
        $orderBy = (string) data_get($queryConfig, 'orderBy', 'created_at');
        // Assert::string($orderBy, '['.__LINE__.']['.__FILE__.']');
        $direction = (string) data_get($queryConfig, 'direction', 'desc');
        // Assert::string($direction, '['.__LINE__.']['.__FILE__.']');
        $query->orderBy($orderBy, $direction);

        // Apply limit
        $limit = (int) data_get($queryConfig, 'limit', 10);
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

        $wrapIn = data_get($queryConfig, 'wrap_in', 'items');
        if (! is_string($wrapIn)) {
            $wrapIn = 'items';
        }

        return [$wrapIn => $transformedItems];
    }
}
