<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions;

use Modules\Meetup\Models\Feedback;
use Spatie\QueueableAction\QueueableAction;

class CreateFeedbackAction
{
    use QueueableAction;

    public function execute(array $data): Feedback
    {
        return Feedback::create($data);
    }
}
