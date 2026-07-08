<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Filament\Resources\EmployeeResource\Pages;
use Modules\Incentivi\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use Modules\Incentivi\Models\Employee;
use Modules\Xot\Enums\GenderEnum;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class EmployeeResource extends XotBaseResource
{
    // public static function getParent(): string
    // {
    //     return ActivityResource::class;
    // }

    protected static ?string $model = Employee::class;

    protected static ?int $navigationSort = 2;

    #[Override]
    public static function getFormSchema(): array
    {
        // Form schema types are inferred by Filament v4
        return [
            'matricola' => TextInput::make('matricola')
                ->required()->numeric()->maxLength(5)->unique(),
            'cognome' => TextInput::make('cognome')
                ->required()->string(),
            'nome' => TextInput::make('nome')
                ->required()->string(),
            'sesso' => Select::make('sesso')
                ->options(GenderEnum::class)
                ->required(),
            'codice_fiscale' => TextInput::make('codice_fiscale')
                ->required()->alphaNum()->length(16)
                ->regex('/^(?:[A-Z][AEIOU][AEIOUX]|[AEIOU]X{2}|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}(?:[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[15MR][\dLMNP-V]|[26NS][0-8LMNP-U])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM]|[AC-EHLMPR-T][26NS][9V])|(?:[02468LNQSU][048LQU]|[13579MPRTV][26NS])B[26NS][9V])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[1-9MNP-V][\dLMNP-V]|[0L][1-9MNP-V]))[A-Z]$/i'),
            'posizione_inail' => TextInput::make('posizione_inail')
                ->required(),
            'tipologia' => TextInput::make('tipologia'),
        ];
    }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->striped()
    //         ->defaultPaginationPageOption(10)
    //         ->columns([
    //             Tables\Columns\TextColumn::make('matricola')
    //                 ->searchable()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('cognome')
    //                 ->searchable()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('nome')
    //                 ->searchable()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('tipologia'),
    //             Tables\Columns\TextColumn::make('sesso'),
    //             Tables\Columns\TextColumn::make('codice_fiscale'),
    //             Tables\Columns\TextColumn::make('posizione_inail'),
    //         ])
    //         ->filters([
    //             Tables\Filters\SelectFilter::make('sesso')
    //                 ->options([
    //                     'F' => 'Femmina',
    //                     'M' => 'Maschio',
    //                 ]),
    //         ])
    //         ->actions([
    //             // Tables\Actions\EditAction::make()
    //             //     ->iconButton(),
    //             // Tables\Actions\DeleteAction::make()
    //             //     ->iconButton(),
    //         ])
    //         ->headerActions([

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

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            // 'create' => Pages\CreateEmployee::route('/create'),
            // 'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['cognome', 'nome'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        if (! $record instanceof Employee) {
            return '';
        }

        $nome = isset($record->nome) ? (string) $record->nome : '';
        $cognome = isset($record->cognome) ? (string) $record->cognome : '';

        return trim($nome.' '.$cognome);
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole('super-admin');
    }
}
