# Integrazione Filament del Modulo Notify

## Blade Components

### NotificationCard
```php
<x-filament::card>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">{{ $title }}</h3>
            <x-filament::badge :color="$status->color">
                {{ $status->label }}
            </x-filament::badge>
        </div>
        
        <div class="prose max-w-none">
            {{ $content }}
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>{{ $created_at->diffForHumans() }}</span>
            <div class="flex items-center space-x-2">
                <x-filament::icon-button
                    icon="heroicon-o-eye"
                    :label="__('Visualizza')"
                    wire:click="view"
                />
                <x-filament::icon-button
                    icon="heroicon-o-trash"
                    :label="__('Elimina')"
                    wire:click="delete"
                />
            </div>
        </div>
    </div>
</x-filament::card>
```

### NotificationList
```php
<x-filament::section>
    <div class="space-y-4">
        @foreach($notifications as $notification)
            <x-notify::notification-card
                :notification="$notification"
            />
        @endforeach
        
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-filament::section>
```

### TemplateEditor
```php
<x-filament::form wire:submit="save">
    <div class="space-y-4">
        <x-filament::input.wrapper>
            <x-filament::input.label for="name">
                {{ __('Nome Template') }}
            </x-filament::input.label>
            <x-filament::input.text
                wire:model="name"
                id="name"
                required
            />
        </x-filament::input.wrapper>
        
        <x-filament::input.wrapper>
            <x-filament::input.label for="content">
                {{ __('Contenuto') }}
            </x-filament::input.label>
            <x-filament::input.textarea
                wire:model="content"
                id="content"
                rows="10"
                required
            />
        </x-filament::input.wrapper>
        
        <div class="flex justify-end">
            <x-filament::button type="submit">
                {{ __('Salva') }}
            </x-filament::button>
        </div>
    </div>
</x-filament::form>
```

## Resources

### TemplateResource

```php
final class TemplateResource extends XotBaseResource
{
    protected static ?string $model = Template::class;
    protected static ?string $navigationGroup = 'Notifiche';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('description')
                            ->maxLength(255),
                        Select::make('type')
                            ->options(TemplateType::class)
                            ->required(),
                        Select::make('status')
                            ->options(TemplateStatus::class)
                            ->required(),
                        MarkdownEditor::make('content')
                            ->required()
                            ->columnSpan('full'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(TemplateType::class),
                SelectFilter::make('status')
                    ->options(TemplateStatus::class),
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
            VersionsRelationManager::class,
            AnalyticsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}
```

### Relation Managers

#### VersionsRelationManager

```php
final class VersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';
    protected static ?string $recordTitleAttribute = 'version';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpan('full'),
                KeyValue::make('metadata')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('version')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
```

#### AnalyticsRelationManager

```php
final class AnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_type')
                    ->badge(),
                TextColumn::make('occurred_at')
                    ->dateTime(),
                TextColumn::make('event_data')
                    ->json(),
            ])
            ->filters([
                SelectFilter::make('event_type')
                    ->options([
                        'sent' => 'Inviato',
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Respinto',
                    ]),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
```

## Widgets

### NotificationStatsWidget
```php
<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-3 gap-4">
            <x-filament::stats-card
                :label="__('Inviati')"
                :value="$sent"
                icon="heroicon-o-paper-airplane"
            />
            
            <x-filament::stats-card
                :label="__('Aperture')"
                :value="$open_rate . '%'"
                icon="heroicon-o-eye"
            />
            
            <x-filament::stats-card
                :label="__('Click')"
                :value="$click_rate . '%'"
                icon="heroicon-o-cursor-click"
            />
        </div>
    </x-filament::card>
</x-filament::widget>
```

### EmailActivityWidget

```php
final class EmailActivityWidget extends Widget
{
    protected static string $view = 'notify::widgets.email-activity';
    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $analytics = app(AnalyticsService::class);
        
        return [
            'chart' => [
                'type' => 'line',
                'data' => $analytics->getActivityChartData(
                    now()->subDays(30),
                    now()
                ),
            ],
        ];
    }
}
```

## Views

### Template Stats Widget View

```blade
<x-filament::widget>
    <x-filament::card>
        <div class="space-y-4">
            <div class="grid grid-cols-3 gap-4">
                <x-filament::stats-card
                    :label="__('Inviati')"
                    :value="$sent"
                    icon="heroicon-o-paper-airplane"
                />
                
                <x-filament::stats-card
                    :label="__('Aperture')"
                    :value="$open_rate . '%'"
                    icon="heroicon-o-eye"
                />
                
                <x-filament::stats-card
                    :label="__('Click')"
                    :value="$click_rate . '%'"
                    icon="heroicon-o-cursor-click"
                />
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
```

### Email Activity Widget View

```blade
<x-filament::widget>
    <x-filament::card>
        <div class="h-80">
            <div
                x-data="{
                    chart: null,
                    init() {
                        this.chart = new ApexCharts($refs.chart, @js($chart))
                        this.chart.render()
                    }
                }"
            >
                <div x-ref="chart"></div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
```

## Actions

### SendTestNotificationAction

```php
final class SendTestNotificationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'send_test';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('Invia Test'))
            ->icon('heroicon-o-paper-airplane')
            ->action(function (Template $record, array $data): void {
                app(SendNotificationAction::class)->execute(
                    $data['recipient'],
                    $record->code,
                    $data['test_data'] ?? [],
                    ['mail']
                );

                Notification::make()
                    ->title(__('Notifica di test inviata'))
                    ->success()
                    ->send();
            })
            ->form([
                TextInput::make('recipient')
                    ->email()
                    ->required(),
                KeyValue::make('test_data')
                    ->label(__('Dati di Test')),
            ]);
    }
}
```

## Navigation

### Menu Configuration

```php
final class NotifyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('notify')
            ->path('notify')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: module_path('Notify', 'Filament/Resources'), for: 'Modules\\Notify\\Filament\\Resources')
            ->discoverPages(in: module_path('Notify', 'Filament/Pages'), for: 'Modules\\Notify\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
