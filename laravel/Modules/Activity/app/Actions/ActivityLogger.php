<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Activity Logger Action.
 *
 * Logs user activities and system events using Queueable Actions
 */
class ActivityLogger
{
    use QueueableAction;

    /**
     * Log activity.
     *
     * @param  array<string, mixed>|null  $properties
     */
    public function log(
        string $type,
        mixed $user = null,
        ?Model $subject = null,
        ?array $properties = null,
        ?string $description = null,
    ): Activity {
        $userId = null;
        if ($user !== null) {
            // Type checking for User model
            if (! $user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }

            // Type narrowing for user ID - use getAttribute for Eloquent models
            $userId = $user->getAttribute('id');
        }
        if ($userId === null) {
            $userId = Auth::id();
        }

        /** @var Activity $activity */
        $activity = Activity::create([
            'log_name' => 'default',
            'description' => $description ?? $type,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'causer_type' => $user ? $user::class : null,
            'causer_id' => $userId,
            'properties' => $properties,
            'event' => $type,
        ]);

        Log::debug('Activity logged', [
            'activity_id' => $activity->id,
            'type' => $type,
        ]);

        return $activity;
    }

    /**
     * Log created event.
     */
    public function created(Model $model, ?UserContract $user = null): Activity
    {
        return (new LogModelCreatedAction($model, $user instanceof Model ? $user : null))->execute();
    }

    /**
     * Log updated event.
     */
    public function updated(Model $model, ?UserContract $user = null): Activity
    {
        return (new LogModelUpdatedAction($model, $user instanceof Model ? $user : null))->execute();
    }

    /**
     * Log deleted event.
     */
    public function deleted(Model $model, ?UserContract $user = null): Activity
    {
        return (new LogModelDeletedAction($model, $user instanceof Model ? $user : null))->execute();
    }

    /**
     * Log login event.
     */
    public function login(UserContract $user): Activity
    {
        return (new LogUserLoginAction($user))->execute();
    }

    /**
     * Log logout event.
     */
    public function logout(UserContract $user): Activity
    {
        return (new LogUserLogoutAction($user))->execute();
    }

    /**
     * Log custom event.
     *
     * @param  array<string, mixed>|null  $properties
     */
    public function custom(
        string $type,
        string $description,
        ?Model $subject = null,
        ?array $properties = null,
    ): Activity {
        return $this->log($type, null, $subject, $properties, $description);
    }

    /**
     * Get activities for user.
     *
     * @return Collection<int, Activity>
     */
    public function getUserActivities(UserContract $user, int $limit = 50): Collection
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $userKey = $user->getKey();
        $userKeyValues = [$userKey];
        if (is_string($userKey)) {
            $userKeyValues[] = $userKey;
        }

        $query = Activity::typedQuery()
            ->with('subject')
            ->whereIn('causer_id', $userKeyValues)
            ->where('causer_type', $user::class)
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }

    /**
     * Get activities for model.
     *
     * @return Collection<int, Activity>
     */
    public function getModelActivities(Model $model, int $limit = 50): Collection
    {
        $query = Activity::typedQuery()
            ->with('causer')
            ->where('subject_type', $model::class)
            ->where('subject_id', $model->getKey())
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }

    /**
     * Get activities by type.
     *
     * @return Collection<int, Activity>
     */
    public function getByType(string $type, int $limit = 50): Collection
    {
        if ($type === '') {
            throw new InvalidArgumentException('Type cannot be empty');
        }
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $query = Activity::typedQuery()
            ->with(['causer', 'subject'])
            ->where('event', $type)
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }

    /**
     * Get recent activities.
     *
     * @return Collection<int, Activity>
     */
    public function getRecent(int $limit = 50): Collection
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $query = Activity::typedQuery()
            ->with(['causer', 'subject'])
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }

    /**
     * Clean old activities.
     */
    public function cleanOld(int $days = 90): int
    {
        if ($days <= 0) {
            throw new InvalidArgumentException('Days must be positive');
        }

        $deletedCount = Activity::typedQuery()->where('created_at', '<', now()->subDays($days))
            ->delete();

        $deleted = is_int($deletedCount) ? $deletedCount : 0;

        Log::debug('Old activities cleaned', [
            'deleted_count' => $deleted,
            'older_than_days' => $days,
        ]);

        return $deleted;
    }

    /**
     * Get activity statistics.
     *
     * @return array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}
     */
    public function getStatistics(?UserContract $user = null): array
    {
        $query = Activity::typedQuery();

        if ($user) {
            $query->where('causer_id', $user->getKey())
                ->where('causer_type', $user::class);
        }

        return [
            'total' => $query->count(),
            'by_type' => (function () use ($query): array {
                /** @var Builder<Activity> $clonedQuery */
                $clonedQuery = $query->clone();

                /** @var \Illuminate\Support\Collection<int, object{event: string, count: int}> $results */
                $results = $clonedQuery
                    ->selectRaw('event, COUNT(*) as count')
                    ->groupBy('event')
                    ->get();

                // Explicitly map and cast to ensure types
                /** @var array<string, int> $byType */
                $byType = $results->mapWithKeys(function (object $item, int $_key): array {
                    // PHPStan L10: isset() per magic attributes invece di property_exists()
                    if (! isset($item->event, $item->count)) {
                        return [];
                    }

                    return [(string) $item->event => (int) $item->count];
                })->toArray();

                return $byType;
            })(),
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
}
