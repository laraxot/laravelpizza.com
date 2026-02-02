# Creazione Risorse Filament 5.x - Laravel Pizza Meetup

**Data**: 2026-02-02  
**Stato**: Documentazione per la creazione di risorse Filament

---

## 📋 **Introduzione**

La creazione di risorse Filament 5.x è il processo attraverso cui definisci le tabelle di database, le form di modifica e le interfacce di amministrazione per i tuoi modelli Laravel. Questa guida copre la creazione completa di risorse.

---

## 🎯 **Creazione di una Risorsa Base**

### **Comando di Creazione**

```bash
# Crea una nuova risorsa
php artisan make:filament-resource [NomeRisorsa]
```

Esempio:
```bash
php artisan make:filament-resource Event
```

Questo crea:
```
laravel/Themes/Meetup/app/Filament/Resources/
├── EventResource.php
├── Pages/
│   ├── CreateEvent.php
│   ├── EditEvent.php
│   └── ListEvents.php
```

---

## 📁 **Struttura di una Risorsa**

### **File EventResource.php**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Events';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),

                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_date')
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getInfolistSchema(): array
    {
        return [
            'main_section' => Tables\Infolists\Components\Section::make('Event Details')
                ->schema([
                    Tables\Infolists\Components\TextEntry::make('title'),
                    Tables\Infolists\Components\TextEntry::make('status')
                        ->badge(),
                ]),
        ];
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
```

---

## 🎨 **Personalizzazione del Form**

### **Componenti Avanzati**

```php
Forms\Components\TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->helperText('Il titolo dell\'evento')
    ->columnSpan(2),

Forms\Components\Textarea::make('description')
    ->required()
    ->columnSpanFull(),

Forms\Components\DateTimePicker::make('start_date')
    ->required()
    ->timezone(config('app.timezone')),

Forms\Components\Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'cancelled' => 'Cancelled',
    ])
    ->required()
    ->searchable(),

Forms\Components\CheckboxList::make('tags')
    ->relationship('tags', 'name')
    ->columns(2),

Forms\Components\Repeater::make('speakers')
    ->schema([
        Forms\Components\TextInput::make('name')->required(),
        Forms\Components\TextInput::make('title')->required(),
    ])
    ->columnSpanFull(),
```

---

## 📊 **Personalizzazione della Tabella**

### **Colonne Avanzate**

```php
Tables\Columns\TextColumn::make('title')
    ->searchable()
    ->sortable()
    ->limit(50),

Tables\Columns\IconColumn::make('is_featured')
    ->boolean(),

Tables\Columns\ImageColumn::make('cover_image')
    ->disk('public')
    ->visibility('public'),

Tables\Columns\TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'published' => 'success',
        'draft' => 'warning',
        'cancelled' => 'danger',
    }),

Tables\Columns\TimestampColumn::make('created_at')
    ->dateTime()
    ->sortable(),
```

---

## 🔗 **Relazioni**

### **Relazioni con Altri Modelli**

```php
// In EventResource.php
public static function getRelations(): array
{
    return [
        Tables\RelationManagers\AttendeesRelationManager::class,
        Tables\RelationManagers\OffersRelationManager::class,
    ];
}

// Crea il Relation Manager
php artisan make:filament-relation-manager Event attendee
```

---

## 🎯 **Azioni Personalizzate**

### **Azioni Custom**

```php
Tables\Actions\Action::make('publish')
    ->action(function (Event $record) {
        $record->update(['status' => 'published']);
    })
    ->requiresConfirmation()
    ->visible(fn (Event $record) => $record->status === 'draft'),

Tables\Actions\Action::make('export')
    ->action(function (Event $record) {
        return Excel::download(new EventExport($record), 'event.xlsx');
    }),
```

---

## 📱 **Layout Responsive**

### **Column Span**

```php
Forms\Components\TextInput::make('title')
    ->columnSpanFull(), // Occupa tutta la riga

Forms\Components\TextInput::make('slug')
    ->columnSpan(1), // Occupa 1/3 della riga

Forms\Components\TextInput::make('status')
    ->columnSpan(2), // Occupa 2/3 della riga
```

---

## 🔍 **Filtro e Ricerca**

### **Filtro Avanzato**

```php
public static function table(Table $table): Table
{
    return $table
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                ]),

            Tables\Filters\Filter::make('has_speakers')
                ->query(fn (Builder $query) => $query->has('speakers')),

            Tables\Filters\TrashedFilter::make(),
        ]);
}
```

---

## 🎨 **Personalizzazione Globale**

### **Configurazione Panel**

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->sidebarCollapsibleOnDesktop()
        ->sidebarFullyCollapsibleOnDesktop()
        ->navigation([
            NavigationGroup::make('Events')
                ->items([
                    NavigationItem::make('Events')
                        ->url(EventResource::getUrl())
                        ->icon('heroicon-o-calendar'),
                ]),
        ])
        ->topbar([
            TopbarItem::make('dark-mode')
                ->action(fn () => $this->toggleDarkMode())
                ->icon('heroicon-o-moon'),
        ]);
}
```

---

## 🚨 **Errori Comuni**

### **Errore: Modello non trovato**

**Soluzione**:
```bash
# Verifica che il modello esista
ls laravel/Themes/Meetup/app/Models/Event.php
```

### **Errore: Form non compilabile**

**Soluzione**:
```bash
# Pulisci cache
php artisan filament:cache-cleanup
php artisan config:clear
```

---

## 📚 **Documentazione Correlata**

- [filament-5-installation-guide.md](./01-filament-5-installation-guide.md)
- [filament-5-actions-configuration.md](./03-filament-5-actions-configuration.md)
- [filament-5-customization-guide.md](./04-filament-5-customization-guide.md)

---

## 🎉 **Conclusione**

Hai ora imparato a creare risorse Filament 5.x complete con form, tabelle, relazioni e azioni personalizzate. Questo è il fondamento per costruire un pannello di amministrazione potente e user-friendly.

---

**Documentazione**: `laravel/Themes/Meetup/docs/03-development/02-filament-5-resource-creation.md`  
**Ultimo Aggiornamento**: 2026-02-02