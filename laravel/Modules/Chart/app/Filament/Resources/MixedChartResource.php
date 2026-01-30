<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Filament\Forms\Components\Select;
// use Modules\Chart\Filament\Resources\MixedChartResource\RelationManagers;
use Modules\Chart\Actions\Chart\GetTypeOptions;
// use Filament\Forms;
use Modules\Chart\Models\MixedChart;
use Modules\Xot\Filament\Resources\XotBaseResource;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class MixedChartResource extends XotBaseResource
{
    protected static ?string $model = MixedChart::class;

    /**
     * @return array<string, Select>
     */
    public static function getFormSchema(): array
    {
        return [
            'type' => Select::make('type')->options(app(GetTypeOptions::class)->execute()),
        ];
    }
}
