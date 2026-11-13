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
 */
class LogModelUpdatedAction
{
    use QueueableAction;

    public function __construct(
<<<<<<< .merge_file_Z5AVm0
        public Model $model,
=======
        public ?Model $model = null,
>>>>>>> .merge_file_gdn0g7
        public ?Model $user = null,
    ) {
        if ($user !== null) {
            // Type already narrowed to Model|null, assertion not needed
        }
    }

<<<<<<< .merge_file_Z5AVm0
    public function execute(): Activity
    {
=======
    public function execute(?Model $model = null): Activity
    {
        $model = $model ?? $this->model;
        if (! $model instanceof Model) {
            throw new \InvalidArgumentException('A model is required');
        }
>>>>>>> .merge_file_gdn0g7
        // PHPStan Level 10: Explicit type guard for nullable Model
        $user = $this->user instanceof Model ? $this->user : null;

        $action = new LogActivityAction(
            type: 'updated',
            user: $user,
<<<<<<< .merge_file_Z5AVm0
            subject: $this->model,
            properties: [
                'old' => $this->model->getOriginal(),
                'new' => $this->model->getAttributes(),
                'changes' => $this->model->getChanges(),
            ],
            description: sprintf('%s updated', class_basename($this->model))
=======
            subject: $model,
            properties: [
                'old' => $model->getOriginal(),
                'new' => $model->getAttributes(),
                'changes' => $model->getChanges(),
            ],
            description: sprintf('%s updated', class_basename($model))
>>>>>>> .merge_file_gdn0g7
        );

        return $action->execute();
    }
}
