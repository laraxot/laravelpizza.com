# Filament Resources e XotBase nel Framework PTVX

## Panoramica

Nel framework PTVX, le Filament Resources seguono un pattern specifico basato sull'ereditarietà delle classi `XotBase` per garantire coerenza, manutenibilità e conformità alle regole del framework Laraxot.

## Classi XotBase per Filament Resources

### XotBaseResource (Classe Astratta)
Classe base per tutte le Filament Resources nel framework PTVX:

```php
// Struttura generale della classe astratta
abstract class XotBaseResource
{
    // Nessuna implementazione di getTableColumns() - VIETATO
    // Le colonne della tabella vengono gestite nei singoli resource
    
    // Metodi comuni per la gestione delle relazioni
    public static function getRelatedPages(): array
    {
        // Implementazione standard per pagine correlate
    }
}
```

### Estensione Obbligatoria
**Mai estendere direttamente `Filament\Resources\Resource`**, ma sempre `Modules\Xot\Filament\Resources\XotBaseResource`:

```php
// CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    
    // Implementazione specifica del resource
}

// ERRATO - VIETATO
use Filament\Resources\Resource;

class UserResource extends Resource
{
    // Questo viola le regole Laraxot
}
```

## Pagine XotBase per Filament Resources

### XotBaseCreateRecord
Classe base per le pagine di creazione:

```php
// CORRETTO
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateUser extends XotBaseCreateRecord
{
    protected static string $resource = UserResource::class;
}

// ERRATO - VIETATO
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    // Questo viola le regole Laraxot
}
```

### XotBaseEditRecord
Classe base per le pagine di modifica:

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditUser extends XotBaseEditRecord
{
    protected static string $resource = UserResource::class;
}
```

### XotBaseViewRecord
Classe base per le pagine di visualizzazione:

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewUser extends XotBaseViewRecord
{
    protected static string $resource = UserResource::class;
}
```

### XotBaseListRecords
Classe base per le pagine di elenco:

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListUsers extends XotBaseListRecords
{
    protected static string $resource = UserResource::class;
    
    // Configurazione delle tabelle
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

## Regole Critiche Laraxot per Filament

### 1. Estensione delle Classi
**MAI estendere classi Filament direttamente:**
- ❌ `extends Filament\Resources\Pages\CreateRecord`
- ❌ `extends Filament\Resources\Pages\EditRecord`
- ❌ `extends Filament\Resources\Pages\ListRecords`
- ❌ `extends Filament\Resources\Pages\Page`

**SEMPRE estendere le classi XotBase corrispondenti:**
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord`

### 2. Proprietà Vietate in XotBasePage
**Chi estende `XotBasePage` NON DEVE avere:**
```php
// ❌ VIETATO
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static ?string $title = 'Titolo';
protected static ?string $navigationLabel = 'Etichetta';
```

### 3. Traduzioni Hardcoded
**MAI usare metodi hardcoded:**
```php
// ❌ VIETATO
TextInput::make('name')->label('Nome')
TextColumn::make('status')->placeholder('Stato')
Action::make('edit')->tooltip('Modifica')
```

**Traduzioni gestite automaticamente:**
```php
// ✅ CORRETTO
TextInput::make('name')
TextColumn::make('status')
Action::make('edit')
```

### 4. Componenti Deprecati
**NON usare più BadgeColumn:**
```php
// ❌ DEPRECATO
BadgeColumn::make('status')

// ✅ CORRETTO
TextColumn::make('status')->badge()
```

## Struttura delle Resources

### Modello Standard
```php
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users'; // Solo se necessario
    
    // Form per creazione/modifica
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }
    
    // Tabella per elenco
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    // Relazioni gestite
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    // Pagine correlate
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

## Best Practices

### 1. Gestione delle Traduzioni
Le traduzioni vengono automaticamente caricate dal sistema basandosi sul nome del campo:
- `name` -> `Nome` (se presente nel file di traduzione)
- `email` -> `Email` (se presente nel file di traduzione)

### 2. Configurazione delle Tabelle
- Usare `TextColumn::make('status')->badge()` invece di `BadgeColumn`
- Implementare filtri solo quando necessari
- Ottimizzare le query con `->searchable()` e `->sortable()`

### 3. Form Schema
- Validare sempre i dati in ingresso
- Usare tipi appropriati per i componenti (email, password, ecc.)
- Implementare limiti di lunghezza per i campi

### 4. Relazioni
- Implementare solo le relazioni effettivamente necessarie
- Usare pagine dedicate per la gestione delle relazioni complesse

## Esempio Completo: Resource Utente

```php
<?php

namespace Modules\User\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\UserResource\Pages;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('create'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

## Conclusione

L'approccio XotBase per Filament Resources nel framework PTVX garantisce:
1. **Coerenza**: Tutte le resources seguono lo stesso pattern
2. **Manutenibilità**: Cambiamenti centralizzati nelle classi base
3. **Sicurezza**: Conformità alle best practices di Filament
4. **Estensibilità**: Possibilità di override selettivo
5. **Traduzioni automatiche**: Gestione intelligente delle etichette

Seguendo queste regole e pattern, gli sviluppatori possono creare interfacce amministrative potenti e coerenti che si integrano perfettamente con l'ecosistema PTVX.