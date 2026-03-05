<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Model Created Action.
 * Optimized for Laraxot architecture.
 */
class LogModelCreatedAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(Model $model): Activity
    {
        /** @var array<string, mixed> $properties */
        $properties = $model->toArray();

        return app(LogActivityAction::class)->execute(
            type: 'created',
            subject: $model,
            description: sprintf('%s was created', class_basename($model)),
            properties: $properties
        );
    }
}
