<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Modules\Meetup\Actions\Contact\SendContactMessageAction;
use Modules\Meetup\Http\Livewire\ContactForm;
use Modules\Meetup\Notifications\ContactMessageNotification;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

/*
 * Pagina Contatti: prima il modulo aveva action="#" e i messaggi non arrivavano a nessuno.
 */

beforeEach(function (): void {
    RateLimiter::clear('contact-form|127.0.0.1');
    Notification::fake();
});

function fillContact(): Testable
{
    return Livewire::test(ContactForm::class)
        ->set('name', 'Giulia Rossi')
        ->set('email', 'giulia@example.test')
        ->set('message', 'Vorrei proporre un talk su Pest per il prossimo meetup.')
        ->set('privacy_accepted', true);
}

test('the contact page renders the working form in both languages', function (string $path): void {
    $this->get($path)->assertOk()->assertSee('wire:model="message"', false);
})->with(['/it/contact', '/en/contact']);

test('a valid message reaches the organizers with the sender as reply-to', function (): void {
    fillContact()->call('submit')->assertHasNoErrors()->assertSet('sent', true);

    Notification::assertSentTo(
        new AnonymousNotifiable,
        ContactMessageNotification::class,
        static function (ContactMessageNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool {
            $mail = $notification->toMail($notifiable);

            return $notifiable->routes['mail'] === SendContactMessageAction::recipient()
                && $mail->replyTo === [['giulia@example.test', 'Giulia Rossi']];
        },
    );
});

test('name, a valid email, a real message and the privacy consent are required', function (string $field, mixed $value): void {
    fillContact()->set($field, $value)->call('submit')->assertHasErrors([$field]);

    Notification::assertNothingSent();
})->with([
    'name' => ['name', ''],
    'email' => ['email', 'non-una-email'],
    'message' => ['message', 'corto'],
    'privacy' => ['privacy_accepted', false],
]);

test('bots filling the hidden field get the same answer but nothing is sent', function (): void {
    fillContact()->set('website', 'https://spam.test')->call('submit')->assertSet('sent', true);

    Notification::assertNothingSent();
});

test('more than three messages in ten minutes from the same address are refused', function (): void {
    foreach (range(1, 3) as $attempt) {
        fillContact()->call('submit')->assertHasNoErrors();
    }

    fillContact()->call('submit')->assertHasErrors(['email']);
});
