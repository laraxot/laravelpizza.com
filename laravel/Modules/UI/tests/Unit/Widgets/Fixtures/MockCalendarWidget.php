<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Widgets\Fixtures;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Modules\UI\Filament\Widgets\BaseCalendarWidget;

class MockCalendarWidget extends BaseCalendarWidget
{
    public string $model = MockEventModel::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Test Event 1',
                'start' => '2025-01-01T10:00:00',
                'end' => '2025-01-01T12:00:00',
                'color' => '#3B82F6',
            ],
            [
                'id' => 2,
                'title' => 'Test Event 2',
                'start' => '2025-01-02T14:00:00',
                'end' => '2025-01-02T16:00:00',
                'color' => '#10B981',
            ],
        ];
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            DateTimePicker::make('start')->required(),
            DateTimePicker::make('end')->required(),
        ];
    }
}
