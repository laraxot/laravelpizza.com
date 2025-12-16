<?php

/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/JobBatchesResource.php?ref_type=heads
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Job\Filament\Resources\JobBatchResource\Pages\ListJobBatches;
use Modules\Job\Models\JobBatch;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class JobBatchResource extends XotBaseResource
{
    // //

    // protected static ?string $model = JobBatch::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->required()->maxLength(255),
            'name' => TextInput::make('name')->required()->maxLength(255),
            'total_jobs' => TextInput::make('total_jobs')->numeric()->required(),
            'pending_jobs' => TextInput::make('pending_jobs')->numeric()->required(),
            'failed_jobs' => TextInput::make('failed_jobs')->numeric()->required(),
            'failed' => Toggle::make('failed')->required(),
            'options' => Textarea::make('options')->maxLength(65535),
            'created_at' => DateTimePicker::make('created_at')->required(),
            'cancelled_at' => DateTimePicker::make('cancelled_at'),
            'finished_at' => DateTimePicker::make('finished_at'),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListJobBatches::route('/'),
        ];
    }
}
