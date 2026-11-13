<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Illuminate\Database\Eloquent\Builder;
<<<<<<< .merge_file_pCJ4um
use Illuminate\Support\Collection;
=======
use Illuminate\Database\Eloquent\Model;
>>>>>>> .merge_file_GBPfqo
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get activity statistics, cached 5 minutes.
 */
class GetActivityStatisticsAction
{
    use QueueableAction;

    /**
     * @return array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}
     */
    public function execute(?UserContract $user = null): array
    {
        $userKey = $user?->getKey();
        $cacheKeySuffix = is_scalar($userKey) ? (string) $userKey : 'global';
        $cacheKey = 'activity.statistics.'.$cacheKeySuffix;

<<<<<<< .merge_file_pCJ4um
        /** @var array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int} $stats */
        $stats = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user): array {
            return $this->computeStatistics($user);
        });

        return $stats;
=======
        $statistics = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user): array {
            return $this->computeStatistics($user);
        });

        return is_array($statistics) ? $this->normalizeStatistics($statistics) : $this->computeStatistics($user);
>>>>>>> .merge_file_GBPfqo
    }

    /**
     * @return array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}
     */
    private function computeStatistics(?UserContract $user): array
    {
<<<<<<< .merge_file_pCJ4um
        /** @var Builder<Activity> $query */
        $query = Activity::newQuery();
=======
        $query = Activity::typedQuery();
>>>>>>> .merge_file_GBPfqo

        if ($user) {
            if (! $user instanceof Model) {
                throw new InvalidArgumentException('User must be an Eloquent model');
            }
            $query->where('causer_id', $user->getKey())
                ->where('causer_type', $user::class);
        }

        return [
            'total' => $query->count(),
            'by_type' => $this->countByType($query),
            'today' => $query->clone()
                ->whereDate('created_at', now()->toDateString())
                ->count(),
            'this_week' => $query->clone()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => $query->clone()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    /**
     * @param  Builder<Activity>  $query
     * @return array<string, int>
     */
    private function countByType(Builder $query): array
    {
<<<<<<< .merge_file_pCJ4um
        /** @var Builder<Activity> $clonedQuery */
        $clonedQuery = $query->clone();

        /** @var Collection<int, object{event: string, count: int}> $results */
        $results = $clonedQuery
=======
        $results = Activity::typedGet($query->clone()
>>>>>>> .merge_file_GBPfqo
            ->selectRaw('event, COUNT(*) as count')
            ->groupBy('event')
        );

        /** @var array<string, int> $byType */
        $byType = $results->mapWithKeys(function (object $item): array {
            // PHPStan L10: isset() per magic attributes invece di property_exists()
            if (! isset($item->event, $item->count)) {
                return [];
            }

            return [(string) $item->event => (int) $item->count];
        })->toArray();

        return $byType;
    }

    /**
     * @param  array<mixed, mixed>  $statistics
     * @return array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}
     */
    private function normalizeStatistics(array $statistics): array
    {
        $byType = [];
        foreach (is_array($statistics['by_type'] ?? null) ? $statistics['by_type'] : [] as $type => $count) {
            if (is_string($type) && (is_int($count) || is_numeric($count))) {
                $byType[$type] = (int) $count;
            }
        }

        return [
            'total' => $this->normalizeInteger($statistics['total'] ?? null),
            'by_type' => $byType,
            'today' => $this->normalizeInteger($statistics['today'] ?? null),
            'this_week' => $this->normalizeInteger($statistics['this_week'] ?? null),
            'this_month' => $this->normalizeInteger($statistics['this_month'] ?? null),
        ];
    }

    private function normalizeInteger(mixed $value): int
    {
        return is_int($value) ? $value : (is_string($value) && is_numeric($value) ? (int) $value : 0);
    }
}
