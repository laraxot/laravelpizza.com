<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Model Created Action.
 *
 * Logs when a model is created using Queueable Actions
 */
class LogModelCreatedAction
{
    use QueueableAction;

    public function __construct(
        public ?Model $model = null,
        public ?Model $user = null,
    ) {
        if ($user !== null) {
            // Type already narrowed to Model|null, assertion not needed
        }
    }

    public function execute(?Model $model = null): Activity
    {
        $model = $model ?? $this->model;
        if (! $model instanceof Model) {
            throw new \InvalidArgumentException('A model is required');
        }
        // PHPStan Level 10: Explicit type guard for nullable Model
        $user = $this->user instanceof Model ? $this->user : null;

        $action = new LogActivityAction(
            type: 'created',
            user: $user,
            subject: $model,
            properties: ['attributes' => $model->getAttributes()],
            description: sprintf('%s created', class_basename($model))
        );

        return $action->execute();
    }
}
