<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Activity Action.
 *
 * Logs a single activity using Queueable Actions
 */
class LogActivityAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>|null  $properties
     */
    public function __construct(
        public string $type,
        public ?Model $user = null,
        public ?Model $subject = null,
        public ?array $properties = null,
        public ?string $description = null,
    ) {
        if ($type === '') {
            throw new InvalidArgumentException('Type cannot be empty');
        }
    }

    public function execute(): Activity
    {
        $causerId = null;
        if ($this->user !== null) {
            if (! $this->user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }
            // Type narrowing for user ID - use getAttribute for Eloquent models
            $userId = $this->user->getAttribute('id');
            $causerId = is_int($userId) || is_string($userId) ? $userId : null;
        }
        if ($causerId === null) {
            $causerId = Auth::id();
        }

        return Activity::typedQuery()->create([
            'log_name' => $this->type,
            'description' => $this->description ?? sprintf('Activity: %s', $this->type),
            'subject_type' => $this->subject ? get_class($this->subject) : null,
            'subject_id' => $this->subject?->getKey(),
            'causer_type' => $this->user !== null ? $this->user::class : null,
            'causer_id' => $causerId,
            'properties' => $this->properties,
            'event' => $this->type,
        ]);
    }
}
