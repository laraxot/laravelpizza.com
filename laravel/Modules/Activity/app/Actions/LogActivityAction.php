<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Activity Action.
 *
 * Logs a single activity using Queueable Actions
 * Optimized for Laraxot architecture.
 */
class LogActivityAction
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @param array<string, mixed>|null $properties
     */
    public function execute(
        string $type,
        ?Model $user = null,
        ?Model $subject = null,
        ?array $properties = null,
        ?string $description = null,
    ): Activity {
        if ($type === '') {
            throw new InvalidArgumentException('Type cannot be empty');
        }

        $causerId = null;
        if ($user !== null) {
            if (! $user instanceof User) {
                throw new InvalidArgumentException('User must be an instance of User');
            }
            $userId = $user->getAttribute('id');
            $causerId = is_int($userId) || is_string($userId) ? $userId : null;
        }

        if ($causerId === null) {
            $causerId = Auth::id();
        }

        return Activity::create([
            'log_name' => $type,
            'description' => $description ?? sprintf('Activity: %s', $type),
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'causer_type' => $user ? User::class : null,
            'causer_id' => $causerId,
            'properties' => $properties,
            'event' => $type,
        ]);
    }
}
