<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Actions\SendRecordsNotificationAction;
use Modules\Notify\Filament\Actions\SendRecordsNotificationBulkAction;
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

function makeDummyNotifyBulkModel(array $attributes = []): Model
{
    return new class($attributes) extends Model
    {
        protected $guarded = [];
    };
}

test('send records notification bulk action exposes expected schema components', function (): void {
    $action = SendRecordsNotificationBulkAction::make();
    $reflection = new ReflectionClass($action);
    $prop = $reflection->getProperty('schema');
    $prop->setAccessible(true);
    $schemaResolver = $prop->getValue($action);

    if ($schemaResolver instanceof Closure) {
        $schema = $schemaResolver();
    } elseif (is_array($schemaResolver)) {
        $schema = $schemaResolver;
    } else {
        $schema = [];
    }

    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('mail_template_slug')
        ->and($schema['mail_template_slug'])->toBeInstanceOf(MailTemplateSelect::class)
        ->and($schema['mail_template_slug']->getName())->toBe('mail_template_slug')
        ->and($schema)->toHaveKey('channels')
        ->and($schema['channels'])->toBeInstanceOf(ChannelCheckboxList::class)
        ->and($schema['channels']->getName())->toBe('channels');
});

test('send records notification bulk action delegates to send records action', function (): void {
    $spy = new class
    {
        /** @var array{count: int, slug: string, channels: array<int, string>}|null */
        public ?array $received = null;

        public function execute(EloquentCollection $records, string $templateSlug, array $channels): void
        {
            $this->received = [
                'count' => $records->count(),
                'slug' => $templateSlug,
                'channels' => $channels,
            ];
        }
    };
    app()->instance(SendRecordsNotificationAction::class, $spy);

    $action = SendRecordsNotificationBulkAction::make();
    $reflection = new ReflectionClass($action);
    $prop = $reflection->getProperty('action');
    $prop->setAccessible(true);
    /** @var Closure(EloquentCollection, array<string, mixed>): void $callback */
    $callback = $prop->getValue($action);

    $records = new EloquentCollection([
        makeDummyNotifyBulkModel(['id' => 1]),
        makeDummyNotifyBulkModel(['id' => 2]),
    ]);

    $callback($records, [
        'mail_template_slug' => 'template-a',
        'channels' => ['mail', 'sms'],
    ]);

    expect($spy->received)->not->toBeNull()
        ->and($spy->received['count'])->toBe(2)
        ->and($spy->received['slug'])->toBe('template-a')
        ->and($spy->received['channels'])->toBe(['mail', 'sms']);
});
