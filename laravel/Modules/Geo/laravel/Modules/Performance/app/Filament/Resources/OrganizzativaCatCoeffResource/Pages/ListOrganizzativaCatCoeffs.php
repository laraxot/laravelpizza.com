<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListOrganizzativaCatCoeffs extends PtvBaseYearListRecords
{
    protected static string $resource = OrganizzativaCatCoeffResource::class;

  

    /**
     * Le colonne della tabella devono corrispondere esattamente a quelle del modello/migrazione.
     * Le label sono gestite automaticamente dal LangServiceProvider tramite i file di traduzione.
     * Vedi docs/automatic-translations.md e docs/filament-resources.md per regole, motivazione e checklist.
     */
    #[Override]
    /**
     * @return array<string, mixed>
     */
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

   
}
