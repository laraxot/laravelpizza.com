<?php

/**
 * Activity Resource Class.
 *
 * This class manages the Activity model in the Filament admin panel.
 * It provides functionality for listing, creating, and editing activity records.
 */

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * Activity Resource Class.
 *
 * This resource class is responsible for configuring the Activity model in the Filament admin panel.
 * It defines the form schema, relations, and pages for managing activity records.
 */
class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;

    /**
     * Define the form schema for the Activity resource.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'log_name' => TextInput::make('log_name')->required()->maxLength(255),
            'description' => TextInput::make('description')->required()->maxLength(255),
            'subject_type' => TextInput::make('subject_type')->required()->maxLength(255),
            'subject_id' => TextInput::make('subject_id')->numeric()->required(),
            'causer_type' => TextInput::make('causer_type')->maxLength(255),
            'causer_id' => TextInput::make('causer_id')->numeric(),
            'properties' => KeyValue::make('properties')->columnSpanFull(),
            'batch_uuid' => TextInput::make('batch_uuid')->maxLength(36),
        ];
    }
}
