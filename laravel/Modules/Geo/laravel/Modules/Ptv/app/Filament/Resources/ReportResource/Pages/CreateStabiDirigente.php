<?php

declare(strict_types=1);
/**
 * ---.
 */

namespace Modules\Ptv\Filament\Resources\ReportResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource;

class CreateStabiDirigente extends CreateRecord
{
    protected static string $resource = StabiDirigenteResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')->disabled(),
                TextInput::make('valutatore_id'),
                TextInput::make('stabi'),
                TextInput::make('repar'),
                TextInput::make('nome_stabi'),
                // Forms\Components\TextInput::make('ente'),
                // Forms\Components\TextInput::make('matr'),
                TextInput::make('nome_diri'),
                TextInput::make('nome_diri_plus'),
                TextInput::make('anno'),
            ]);
    }
}
