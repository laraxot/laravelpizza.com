<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Illuminate\Support\Facades\Notification;
use Modules\Meetup\Actions\Event\BuildEventIcsAction;
use Modules\Meetup\Actions\Event\SendEventRemindersAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\Meetup\Notifications\EventReminderNotification;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

function calendarEvent(array $attributes = []): Event
{
    return Event::query()->create([
        'title' => 'Pizza, Pest; e virgole, '.uniqid(),
        'description' => "Riga uno\nRiga due",
        'location' => 'Milano',
        'start_date' => now()->addHours(20)->startOfMinute(),
        'end_date' => now()->addHours(23)->startOfMinute(),
        'status' => 'published',
        ...$attributes,
    ]);
}

test('the ics file is valid iCalendar with escaped text and UTC times', function (): void {
    $event = calendarEvent();

    $ics = app(BuildEventIcsAction::class)->execute($event);
    $unfolded = str_replace("\r\n ", '', $ics);

    expect($ics)->toStartWith("BEGIN:VCALENDAR\r\n")
        ->toEndWith("END:VCALENDAR\r\n")
        ->and($unfolded)->toContain('DTSTART:'.$event->start_date?->copy()->utc()->format('Ymd\THis\Z'))
        ->and($unfolded)->toContain('SUMMARY:Pizza\, Pest\; e virgole\,')
        ->and($unfolded)->toContain('Riga uno\nRiga due');

    foreach (explode("\r\n", $ics) as $line) {
        expect(strlen($line))->toBeLessThanOrEqual(75);
    }
});

test('the confirmation email carries the ics attachment', function (): void {
    $event = calendarEvent();
    $user = User::factory()->create();

    $mail = (new EventRegistrationConfirmedNotification($event, 'it'))->toMail($user);

    expect($mail->rawAttachments)->toHaveCount(1)
        ->and($mail->rawAttachments[0]['name'])->toEndWith('.ics');
});

test('reminders go once to each attendee of events starting within a day', function (): void {
    Notification::fake();
    $soon = calendarEvent();
    $nextWeek = calendarEvent(['start_date' => now()->addWeek(), 'end_date' => now()->addWeek()->addHours(2)]);
    $draft = calendarEvent(['status' => 'draft']);
    $attendee = User::factory()->create();
    $other = User::factory()->create();

    foreach ([[$soon, $attendee], [$soon, $other], [$nextWeek, $attendee], [$draft, $attendee]] as [$event, $user]) {
        EventUser::query()->create(['event_id' => $event->getKey(), 'user_id' => (string) $user->getKey(), 'status' => 'attending']);
    }

    $first = app(SendEventRemindersAction::class)->execute();
    $second = app(SendEventRemindersAction::class)->execute();

    expect($first)->toBeGreaterThanOrEqual(2)
        ->and($second)->toBe(0);
    Notification::assertSentTo($attendee, EventReminderNotification::class, static fn (EventReminderNotification $n): bool => $n->event->is($soon));
    Notification::assertSentTo($other, EventReminderNotification::class);
    Notification::assertNotSentTo($attendee, EventReminderNotification::class, static fn (EventReminderNotification $n): bool => $n->event->is($nextWeek) || $n->event->is($draft));
    expect(EventUser::query()->where('event_id', $soon->getKey())->whereNull('reminder_sent_at')->exists())->toBeFalse();
});
