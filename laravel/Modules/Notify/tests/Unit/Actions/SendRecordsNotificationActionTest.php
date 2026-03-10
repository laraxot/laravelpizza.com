<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Actions\SendRecordNotificationAction;
use Modules\Notify\Actions\SendRecordsNotificationAction;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

uses(TestCase::class);

function makeDummyBulkNotifyRecord(array $attributes = []): Model
{
    return new class($attributes) extends Model
    {
        protected $guarded = [];
    };
}

test('send records notification action counts successful sends', function (): void {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            $value = $record->getAttribute($attribute);

            return is_string($value) ? $value : $default;
        }
    });

    app()->instance(SendRecordNotificationAction::class, new class
    {
        public function execute(Model $record, string $templateSlug, array $channels): void
        {
            // No-op: simulate successful delivery for each record.
        }
    });

    $records = new EloquentCollection([
        makeDummyBulkNotifyRecord(['id' => 1, 'name' => 'Alpha']),
        makeDummyBulkNotifyRecord(['id' => 2, 'name' => 'Beta']),
    ]);

    $result = app(SendRecordsNotificationAction::class)->execute(
        records: $records,
        templateSlug: 'welcome-template',
        channels: ['mail', 'sms'],
    );

    expect($result->successCount)->toBe(4)
        ->and($result->errorCount)->toBe(0)
        ->and($result->errors->count())->toBe(0)
        ->and($result->totalProcessed)->toBe(4);
});

test('send records notification action accumulates errors per channel', function (): void {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            $value = $record->getAttribute($attribute);

            return is_string($value) ? $value : $default;
        }
    });

    app()->instance(SendRecordNotificationAction::class, new class
    {
        public function execute(Model $record, string $templateSlug, array $channels): void
        {
            if ((bool) $record->getAttribute('should_fail')) {
                throw new \Exception('bulk failure');
            }
        }
    });

    $records = new EloquentCollection([
        makeDummyBulkNotifyRecord(['id' => 1, 'name' => 'Ok Record', 'should_fail' => false]),
        makeDummyBulkNotifyRecord(['id' => 2, 'name' => 'Fail Record', 'should_fail' => true]),
    ]);

    $result = app(SendRecordsNotificationAction::class)->execute(
        records: $records,
        templateSlug: 'welcome-template',
        channels: ['mail', 'sms'],
    );

    expect($result->successCount)->toBe(2)
        ->and($result->errorCount)->toBe(2)
        ->and($result->errors->count())->toBe(2)
        ->and($result->errors->first()['record'])->toBe('Fail Record')
        ->and($result->totalProcessed)->toBe(4);
});

test('send records notification action falls back to record key when name is missing', function (): void {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            return '';
        }
    });

    app()->instance(SendRecordNotificationAction::class, new class
    {
        public function execute(Model $record, string $templateSlug, array $channels): void
        {
            throw new \Exception('forced error');
        }
    });

    $record = makeDummyBulkNotifyRecord(['id' => 99, 'should_fail' => true]);
    $records = new EloquentCollection([$record]);

    $result = app(SendRecordsNotificationAction::class)->execute(
        records: $records,
        templateSlug: 'welcome-template',
        channels: ['mail'],
    );

    expect($result->errorCount)->toBe(1)
        ->and($result->errors->first()['record'])->toBe('99');
});
