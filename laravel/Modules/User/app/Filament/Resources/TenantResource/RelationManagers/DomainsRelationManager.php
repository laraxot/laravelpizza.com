<?php

/**
 * --.
 */
declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DomainsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'domains';

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'domain' => TextInput::make('domain')
                ->required()
                ->prefix('http(s)://')
                ->suffix('.'.request()->getHost())
                ->maxLength(255),
        ];
    }

    #[\Override]
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('domain')
            ->columns([
                TextColumn::make('domain'),
                TextColumn::make('full-domain')->getStateUsing(
                    static fn ($record) => is_object($record) && isset($record->domain) && is_string($record->domain) ?
                        Str::of($record->domain)->append('.')->append(request()->getHost()) : '',
                ),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
