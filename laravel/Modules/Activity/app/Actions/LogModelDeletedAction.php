<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Model Deleted Action.
 * Optimized for Laraxot architecture.
 */
class LogModelDeletedAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(Model $model): Activity
    {
        return app(LogActivityAction::class)->execute(
            type: 'deleted',
            subject: $model,
            description: sprintf('%s was deleted', class_basename($model)),
            properties: $model->toArray()
        );
    }
}
