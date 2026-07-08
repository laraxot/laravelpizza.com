<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseManageRelatedRecords;
use Override;

class ManagePhaseSettlements extends XotBaseManageRelatedRecords
{
    protected static string $resource = PhaseResource::class;

    protected static string $relationship = 'settlements';

    #[Override]
    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('denominazione')
                ->required()
                ->maxLength(255),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'denominazione' => TextColumn::make('denominazione'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    // public function getTableActions(): array
    // {
    //     return [
    //         Tables\Actions\Action::make('handleSettlement')
    //             ->label('Gestisci Liquidazione')
    //             ->tooltip('Gestisci Liquidazione')
    //             ->icon('heroicon-m-user-group')
    //             ->url(fn (Model $phase): string => PhaseResource::getUrl('edit', ['record' => $phase]),
    //                 shouldOpenInNewTab: false),
    //     ];
    // }
}
