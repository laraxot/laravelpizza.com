<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Modules\Job\Filament\Resources\JobResource\Pages\BoardJobs;
use Modules\Job\Filament\Resources\JobResource\Pages\CreateJob;
use Modules\Job\Filament\Resources\JobResource\Pages\EditJob;
use Modules\Job\Filament\Resources\JobResource\Pages\ListJobs;
use Modules\Job\Filament\Resources\JobResource\Widgets\JobStatsOverview;
use Modules\Job\Models\Job;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class JobResource extends XotBaseResource
{
    protected static ?string $model = Job::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'queue' => TextInput::make('queue')->required()->maxLength(255),
            'payload' => TextInput::make('payload')->required(),
            'attempts' => TextInput::make('attempts')->numeric()->required(),
            'available_at' => DateTimePicker::make('available_at')->required(),
            'created_at' => DateTimePicker::make('created_at')->required(),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'board' => BoardJobs::route('/board'),
            'edit' => EditJob::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            JobStatsOverview::class,
        ];
    }
}
