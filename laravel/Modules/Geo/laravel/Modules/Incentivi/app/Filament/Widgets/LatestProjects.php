<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Models\Project;

class LatestProjects extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Ultimi Progetti';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(ProjectResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Data di creazione')
                    ->date()
                    ->sortable(),
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipo')
                    ->searchable(),
                TextColumn::make('stato')
                    ->badge(),
            ])
            ->recordActions([
                Action::make('Apri')
                    ->url(fn (Project $record): string => ProjectResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
