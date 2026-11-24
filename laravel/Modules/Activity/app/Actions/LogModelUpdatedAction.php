<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log Model Updated Action.
 *
 * Logs when a model is updated using Queueable Actions
 *
 * @see docs/contracts/log-model-updated-action.md
 *
 * @contract docs/contracts/log-model-updated-action.md
 */
class LogModelUpdatedAction
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
            type: 'updated',
            user: $user,
            subject: $model,
            // password, remember_token e segreti 2FA non entrano mai nel log (RedactModelAttributesAction)
            properties: [
                'old' => app(RedactModelAttributesAction::class)->execute($model->getOriginal()),
                'new' => app(RedactModelAttributesAction::class)->execute($model->getAttributes()),
                'changes' => app(RedactModelAttributesAction::class)->execute($model->getChanges()),
            ],
            description: sprintf('%s updated', class_basename($model))
        );

        return $action->execute();
    }
}
