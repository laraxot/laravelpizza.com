# Filament Admin Panel

## Prerequisiti
- Laravel 12.x
- PHP 8.2+
- Livewire 3.x
- Filament 4.x

## Struttura Base

```
app/Filament/
├── Resources/           # Resource classes
│   └── UserResource/
│       ├── Pages/
│       │   ├── CreateUser.php
│       │   ├── EditUser.php
│       │   └── ListUsers.php
│       └── UserResource.php
├── Pages/              # Custom pages
│   └── Dashboard.php
└── Widgets/            # Dashboard widgets
    └── StatsOverview.php
```

## Convenzioni

### 1. Resources
```php
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('role')
                ->required()
                ->options(Role::class),
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
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'primary' => 'admin',
                        'success' => 'user',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(Role::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\PostsRelationManager::class,
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

### 2. Pages
```php
class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.pages.dashboard';
    
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
            Widgets\ChartWidget::class,
        ];
    }
    
    protected function getFooterWidgets(): array
    {
        return [
            Widgets\LatestUsers::class,
        ];
    }
}
```

### 3. Widgets
```php
class StatsOverview extends XotBaseWidget
{
    protected static string $view = 'filament.widgets.stats-overview';
    
    protected function getStats(): array
    {
        return [
            Card::make('Total Users', User::count())
                ->description('8% increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Total Posts', Post::count())
                ->description('3% decrease')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
        ];
    }
}
```

## Best Practices

### 1. Form Fields
```php
Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->placeholder('Enter name')
    ->helperText('Full name of the user')
    ->rules(['required', 'string', 'max:255'])
    ->columnSpan(2);
```

### 2. Table Columns
```php
Tables\Columns\TextColumn::make('name')
    ->searchable()
    ->sortable()
    ->toggleable()
    ->copyable()
    ->tooltip('User full name');
```

### 3. Actions
```php
Tables\Actions\Action::make('approve')
    ->icon('heroicon-o-check')
    ->color('success')
    ->requiresConfirmation()
    ->action(fn (User $record) => $record->approve());
```

### 4. Filters
```php
Tables\Filters\Filter::make('active')
    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
    ->toggle();
```

### 5. Validation
```php
Forms\Components\TextInput::make('email')
    ->email()
    ->required()
    ->unique(ignoreRecord: true)
    ->rules(['required', 'email', Rule::unique('users')->ignore($this->record)])
    ->validationAttribute('email address');
```

## Performance

### 1. Query Optimization
```php
protected static function getNavigationBadge(): ?string
{
    return static::$model::cache()->count();
}
```

### 2. Lazy Loading
```php
protected function getTableRecordsPerPageSelectOptions(): array
{
    return [10, 25, 50];
}
```

### 3. Caching
```php
protected function getHeaderWidgets(): array
{
    return [
        Widgets\StatsOverview::make()->cache(ttl: 3600),
    ];
}
```

## Troubleshooting

### Common Issues
1. **Resource Not Found**
   - Verificare il namespace
   - Controllare l'autoloading
   - Verificare la registrazione nel service provider

2. **Form Not Saving**
   - Verificare i fillable nel model
   - Controllare le regole di validazione
   - Verificare i permessi

3. **Widgets Not Loading**
   - Verificare la registrazione
   - Controllare le dipendenze
   - Verificare il cache

## Collegamenti
- [Struttura Base](../laravel/Modules/Xot/docs/STRUCTURE.md)
- [Convenzioni di Namespace](../laravel/Modules/Xot/docs/namespace-conventions.md)
- [Documentazione Laravel](LARAVEL.md)
- [Documentazione Livewire](LIVEWIRE.md) 