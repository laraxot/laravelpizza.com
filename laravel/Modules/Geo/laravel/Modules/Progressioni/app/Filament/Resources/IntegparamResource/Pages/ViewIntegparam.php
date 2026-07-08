<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\IntegparamResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Progressioni\Filament\Resources\IntegparamResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewIntegparam extends XotBaseViewRecord
{
    protected static string $resource = IntegparamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * Schema dell'infolist per la visualizzazione dei dettagli del record.
     *
     * @return array<int|string, Component>
     */
    #[Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Dati Anagrafici')
                ->schema([
                    TextEntry::make('ente'),
                    TextEntry::make('matr'),
                    TextEntry::make('conome'),
                    TextEntry::make('nome'),
                ])
                ->columns(2),

            Section::make('Validità Temporale')
                ->schema([
                    TextEntry::make('anv2kd')
                        ->date(),
                    TextEntry::make('anv2ka')
                        ->date(),
                    TextEntry::make('anvist'),
                ])
                ->columns(3),

            Section::make('Parametri')
                ->schema([
                    TextEntry::make('anvpar'),
                    TextEntry::make('anvimp')
                        ->numeric(),
                    TextEntry::make('anvqta')
                        ->numeric(),
                    TextEntry::make('anvvoc'),
                    TextEntry::make('anvdes'),
                ])
                ->columns(2),
        ];
    }
}
