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
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class JobBatchResource extends XotBaseResource
{
    // //

    // protected static ?string $model = JobBatch::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListJobBatches::route('/'),
        ];
    }
}
