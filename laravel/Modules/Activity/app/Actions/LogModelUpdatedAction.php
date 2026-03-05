<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Model Updated Action.
 * Optimized for Laraxot architecture.
 */
class LogModelUpdatedAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(Model $model): Activity
    {
        return app(LogActivityAction::class)->execute(
            type: 'updated',
            subject: $model,
            description: sprintf('%s was updated', class_basename($model)),
            properties: [
                'old' => $model->getOriginal(),
                'attributes' => $model->getChanges(),
            ]
        );
    }
}
