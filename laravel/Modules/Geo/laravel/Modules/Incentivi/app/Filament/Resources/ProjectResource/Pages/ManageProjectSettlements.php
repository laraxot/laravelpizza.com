<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\GeneratePDFProjectReportAction;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Override;

class ManageProjectSettlements extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'settlements';

    protected static ?string $title = 'Liquidazioni';

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'generate_pdf_report' => GeneratePDFProjectReportAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('denominazione')
                // ->label('Denominazione')
                ->required()
                ->maxLength(255),
            // Forms\Components\Select::make('tipologia')
            //     // ->label('Tipo di liquidazione')
            //     ->options([
            //         '1-fase' => '1° fase',
            //         '2-fase' => '2° fase',
            //         'unica' => 'Unica',
            //     ])
            //     ->required()
            //     ->default('unica'),
            TextInput::make('importo')
                ->numeric()
                ->suffix('€'),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'denominazione' => TextColumn::make('denominazione')
                ->limit(70)
                ->searchable(),
            'importo' => TextColumn::make('importo')
                ->money('EUR'),
            'created_at' => TextColumn::make('created_at'),
            'updated_at' => TextColumn::make('updated_at'),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'download' => Action::make('download')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->openUrlInNewTab(),
        ];
    }

    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'nuova_liquidazione_unica' => CreateAction::make('nuova-liquidazione-unica')
                ->label('Nuova Liquidazione Unica')
                ->disableCreateAnother(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->heading('Liquidazioni del Progetto')
    //         ->paginated(false)
    //         ->recordTitleAttribute('denominazione')
    //         ->columns([
    //             Tables\Columns\TextColumn::make('denominazione')
    //                 // ->label('Denominazione')
    //                 ->limit(70)
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('tipologia')
    //                 // ->label('Tipo di liquidazione')
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('created_at')
    //                 // ->label('Creata')
    //                 ,
    //             Tables\Columns\TextColumn::make('updated_at')
    //                 // ->label('Aggiornata')
    //                 ,
    //             Tables\Columns\TextColumn::make('project.nome')
    //                 // ->label('Progetto')
    //         ])
    //         ->filters([
    //         ])
    //         ->headerActions([
    //             // Tables\Actions\AttachAction::make(),
    //             Tables\Actions\CreateAction::make('nuova-liquidazione-unica')
    //                 ->label('Nuova Liquidazione Unica')
    //                 ->disableCreateAnother(),
    //             Tables\Actions\CreateAction::make('nuova-liquidazione-a-fasi')
    //                 ->label('Nuova Liquidazione a Fasi')
    //                 ->disableCreateAnother(),
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make()
    //                 ->iconButton(),
    //             Tables\Actions\DeleteAction::make()
    //                 ->iconButton(),
    //             Action::make('download')
    //                 // ->label('Scarica PDF')
    //                 ->icon('heroicon-o-arrow-down-tray')
    //                 ->color('success')
    //                 ->openUrlInNewTab()
    //                 ,
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ])
    //         ->emptyStateActions([
    //             // Tables\Actions\CreateAction::make(),
    //         ]);
    // }

    protected function getRelatedCount(): int
    {
        return Project::has('settlements')->count();
    }
}
