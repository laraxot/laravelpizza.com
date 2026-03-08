<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions;

use Modules\Meetup\Actions\CreateFeedbackAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Feedback;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('it can create a feedback', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $data = [
        'user_id' => $user->id,
        'event_id' => $event->id,
        'rating' => 5,
        'comment' => 'Great meetup!',
    ];

    $feedback = app(CreateFeedbackAction::class)->execute($data);

    expect($feedback)
        ->toBeInstanceOf(Feedback::class)
        ->rating->toBe(5)
        ->comment->toBe('Great meetup!')
        ->user_id->toBe($user->id)
        ->event_id->toBe($event->id);
});
