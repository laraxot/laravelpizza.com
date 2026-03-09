<?php

declare(strict_types=1);

use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;

uses(\Modules\Activity\Tests\TestCase::class);

test('action can be instantiated', function (): void {
    $action = ListLogActivitiesAction::make();

    expect($action)->toBeInstanceOf(ListLogActivitiesAction::class);
    expect($action::getDefaultName())->toBe('list_log_activities');
});

test('action has correct configuration', function (): void {
    $action = ListLogActivitiesAction::make();

    expect($action->getIcon())->toBe('heroicon-o-clock');
    expect($action->getColor())->toBe('gray');
});

test('action generates a log-activity URL containing record key', function (): void {
    $action = ListLogActivitiesAction::make();

    $resource = new class
    {
        public static function getUrl(string $name, array $parameters = []): string
        {
            $record = $parameters['record'] ?? null;
            $key = $record instanceof Model ? (string) $record->getKey() : '';

            return '/log-activity/'.$key;
        }
    };

    $livewire = Mockery::mock(ListRecords::class);
    $livewire->shouldReceive('getResource')->andReturn($resource::class);

    $record = Mockery::mock(Model::class);
    $record->shouldReceive('getKey')->andReturn('test-record-key');

    $action->livewire($livewire);
    $action->record($record);

    $url = $action->getUrl();

    expect($url)->toContain('log-activity');
    expect($url)->toContain('test-record-key');
});
