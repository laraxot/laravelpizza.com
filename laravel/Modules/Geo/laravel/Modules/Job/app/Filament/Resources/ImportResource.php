<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Job\Models\Import;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class ImportResource extends XotBaseResource
{
    protected static ?string $model = Import::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'file' => FileUpload::make('file')
                ->required()
                ->acceptedFileTypes([
                    'text/csv',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->maxSize(10240),
            'status' => Select::make('status')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'completed' => 'Completed',
                    'failed' => 'Failed',
                ])
                ->default('pending'),
            'error_message' => Textarea::make('error_message')->maxLength(65535),
            'total_rows' => TextInput::make('total_rows')->numeric(),
            'processed_rows' => TextInput::make('processed_rows')->numeric(),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }
}
