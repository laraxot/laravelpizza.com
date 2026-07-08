<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class OrganizzativaCatCoeffsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'lista_propro' => TextColumn::make('lista_propro'),
            'coeff' => TextColumn::make('coeff'),
            'descr' => TextColumn::make('descr'),
            'tot_giorni' => TextColumn::make('tot_giorni'),
            'tot_giorni_pt' => TextColumn::make('tot_giorni_pt'),
            'tot_giorni_pt_coeff' => TextColumn::make('tot_giorni_pt_coeff'),
            'quota_teorica' => TextColumn::make('quota_teorica'),
            'tot' => TextColumn::make('tot'),
            'anno' => TextColumn::make('anno'),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }
}
