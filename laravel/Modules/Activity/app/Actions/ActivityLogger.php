<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
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
            if (! $user instanceof User) {
                throw new \InvalidArgumentException('User must be an instance of User');
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

        Log::info('Activity logged', [
            'activity_id' => $activity->id,
            'type' => $type,
        ]);

        return $activity;
    }

    /**
     * Log created event.
     */
    public function created(Model $model, ?User $user = null): Activity
    {
        $action = new LogModelCreatedAction($model, $user);

        return $action->execute();
    }

    /**
     * Log updated event.
     */
    public function updated(Model $model, ?User $user = null): Activity
    {
        $action = new LogModelUpdatedAction($model, $user);

        return $action->execute();
    }

    /**
     * Log deleted event.
     */
    public function deleted(Model $model, ?User $user = null): Activity
    {
        $action = new LogModelDeletedAction($model, $user);

        return $action->execute();
    }

    /**
     * Log login event.
     */
    public function login(User $user): Activity
    {
        $action = new LogUserLoginAction($user);

        return $action->execute();
    }

    /**
     * Log logout event.
     */
    public function logout(User $user): Activity
    {
        $action = new LogUserLogoutAction($user);

        return $action->execute();
    }

    /**
     * Log custom event.
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
     */
    public function getUserActivities(User $user, int $limit = 50): Collection
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Limit must be positive');
        }

        /** @var Collection<int, Activity> $activities */
        $activities = Activity::with('subject')
            ->where('causer_id', $user->getKey())
            ->where('causer_type', $user::class)
            ->latest()
            ->limit($limit)
            ->get();

        return $activities;
    }

    /**
     * Get activities for model.
     */
    public function getModelActivities(Model $model, int $limit = 50): Collection
    {
        /** @var Collection<int, Activity> $activities */
        $activities = Activity::with('causer')
            ->where('subject_type', $model::class)
            ->where('subject_id', $model->getKey())
            ->latest()
            ->limit($limit)
            ->get();

        return $activities;
    }

    /**
     * Get activities by type.
     */
    public function getByType(string $type, int $limit = 50): Collection
    {
        if ($type === '') {
            throw new \InvalidArgumentException('Type cannot be empty');
        }
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Limit must be positive');
        }

        /** @var Collection<int, Activity> $activities */
        $activities = Activity::with(['causer', 'subject'])
            ->where('event', $type)
            ->latest()
            ->limit($limit)
            ->get();

        return $activities;
    }

    /**
     * Get recent activities.
     */
    public function getRecent(int $limit = 50): Collection
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Limit must be positive');
        }

        /** @var Collection<int, Activity> $activities */
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->limit($limit)
            ->get();

        return $activities;
    }

    /**
     * Clean old activities.
     */
    public function cleanOld(int $days = 90): int
    {
        if ($days <= 0) {
            throw new \InvalidArgumentException('Days must be positive');
        }

        $deletedCount = Activity::where('created_at', '<', now()->subDays($days))
            ->delete();

        $deleted = is_int($deletedCount) ? $deletedCount : 0;

        Log::info('Old activities cleaned', [
            'deleted_count' => $deleted,
            'older_than_days' => $days,
        ]);

        return $deleted;
    }

    /**
     * Get activity statistics.
     */
    public function getStatistics(?User $user = null): array
    {
        $query = Activity::query();

        if ($user) {
            $query->where('causer_id', $user->getKey())
                ->where('causer_type', $user::class);
        }

        return [
            'total' => $query->count(),
            'by_type' => $query->clone()
                ->selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->pluck('count', 'event')
                ->toArray(),
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
