<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Notifications\GenericNotification;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

class DummySendNotificationRecipient extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function routeNotificationForMail(): string
    {
        return (string) ($this->getAttribute('email') ?? 'recipient@example.test');
    }

    public function routeNotificationForSms(): string
    {
        return (string) ($this->getAttribute('phone') ?? '3331234567');
    }
}

beforeEach(function (): void {
    $schema = Schema::connection('notify');

    if (! $schema->hasTable('notification_templates')) {
        $schema->create('notification_templates', function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->text('subject')->nullable();
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();
            $table->json('channels')->nullable();
            $table->json('variables')->nullable();
            $table->json('conditions')->nullable();
            $table->json('preview_data')->nullable();
            $table->json('metadata')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    NotificationTemplate::query()->delete();
});

test('send notification action throws when template is missing', function (): void {
    $recipient = new DummySendNotificationRecipient(['email' => 'user@example.test']);

    app(SendNotificationAction::class)->execute($recipient, 'missing-template');
})->throws(Exception::class);

test('send notification action returns false when template should not send', function (): void {
    NotificationTemplate::query()->create([
        'id' => (string) Str::uuid(),
        'name' => 'Welcome',
        'code' => 'welcome-template',
        'subject' => ['en' => 'Welcome', 'it' => 'Benvenuto'],
        'body_text' => ['en' => 'Hello', 'it' => 'Ciao'],
        'body_html' => ['en' => '<p>Hello</p>', 'it' => '<p>Ciao</p>'],
        'channels' => ['database'],
        'variables' => [],
        'is_active' => true,
        'conditions' => ['send' => true],
        'type' => 'email',
    ]);

    $recipient = new DummySendNotificationRecipient(['email' => 'user@example.test']);

    $result = app(SendNotificationAction::class)->execute($recipient, 'welcome-template', ['send' => false]);

    expect($result)->toBeFalse();
});

test('send notification action dispatches database notification from template channels', function (): void {
    NotificationTemplate::query()->create([
        'id' => (string) Str::uuid(),
        'name' => 'Welcome',
        'code' => 'welcome-template',
        'subject' => ['en' => 'Welcome', 'it' => 'Benvenuto'],
        'body_text' => ['en' => 'Hello', 'it' => 'Ciao'],
        'body_html' => ['en' => '<p>Hello</p>', 'it' => '<p>Ciao</p>'],
        'channels' => ['database'],
        'variables' => [],
        'is_active' => true,
        'conditions' => null,
        'type' => 'email',
    ]);

    $recipient = new DummySendNotificationRecipient(['email' => 'user@example.test']);

    Notification::fake();

    $result = app(SendNotificationAction::class)->execute($recipient, 'welcome-template');

    expect($result)->toBeTrue();
    Notification::assertSentTo($recipient, GenericNotification::class);
});
