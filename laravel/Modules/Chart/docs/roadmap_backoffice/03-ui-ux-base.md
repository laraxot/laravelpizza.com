# Task 3: UI/UX Base Backoffice

## Descrizione
Implementazione dell'interfaccia utente base del backoffice di il progetto utilizzando Filament, includendo il design system, i componenti, il layout responsive e il tema personalizzato.

## Sottotask

### 3.1 Design System Filament
- [ ] Definizione colori
- [ ] Definizione tipografia
- [ ] Definizione spaziature
- [ ] Definizione componenti
- [ ] Documentazione

### 3.2 Componenti Base
- [ ] Setup Filament
- [ ] Componenti base
- [ ] Form fields
- [ ] Tables
- [ ] Widgets

### 3.3 Layout Responsive
- [ ] Breakpoints
- [ ] Grid system
- [ ] Flexbox utilities
- [ ] Media queries
- [ ] Test responsive

### 3.4 Theme Personalizzato
- [ ] Tema base
- [ ] Tema scuro
- [ ] Customizzazione
- [ ] Documentazione
- [ ] Test temi

## Dettagli Tecnici

### Setup Filament
```bash
composer require filament/filament:"^3.0"
php artisan filament:install --panels
```

### Configurazione Theme
```php
// config/filament/theme.php
return [
    'colors' => [
        'primary' => [
            50 => '#f0f9ff',
            100 => '#e0f2fe',
            200 => '#bae6fd',
            300 => '#7dd3fc',
            400 => '#38bdf8',
            500 => '#0ea5e9',
            600 => '#0284c7',
            700 => '#0369a1',
            800 => '#075985',
            900 => '#0c4a6e',
        ],
    ],
    'fontFamily' => [
        'sans' => ['Inter', 'sans-serif'],
    ],
];
```

### Resource Base
```php
// app/Filament/Resources/UserResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
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
            ]);
    }

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
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

### Widget Base
```php
// app/Filament/Widgets/StatsOverview.php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
```

## Checklist di Verifica
- [ ] Design system completo
- [ ] Componenti Filament funzionanti
- [ ] Layout responsive testato
- [ ] Tema personalizzato applicato
- [ ] Documentazione aggiornata

## Note
- Seguire le linee guida Filament
- Implementare test per i componenti
- Verificare l'accessibilità
- Ottimizzare le performance

## Collegamenti
- [Task 2: Architettura Base](../roadmap_backoffice/02-architettura-base.md)
- [Task 4: Gestione Utenti](../roadmap_backoffice/04-gestione-utenti.md) 
## Collegamenti tra versioni di 03-ui-ux-base.md
* [03-ui-ux-base.md](docs/roadmap_frontoffice/03-ui-ux-base.md)
* [03-ui-ux-base.md](docs/roadmap_backoffice/03-ui-ux-base.md)

