# Analisi Dettagliata del Modulo Notify - Parte 4: Integrazione con Filament

## 4. Integrazione con Filament

### 4.1 TemplateResource

#### 4.1.1 Struttura Base
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Modules\Notify\Models\Template;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $navigationGroup = 'Notify';

    protected static ?int $navigationSort = 1;
}
```

#### 4.1.2 Form
```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subject')
                        ->label('Oggetto')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('layout')
                        ->label('Layout')
                        ->options([
                            'default' => 'Default',
                            'clean' => 'Clean',
                            'modern' => 'Modern'
                        ])
                        ->default('default')
                        ->required(),

                    Forms\Components\TextInput::make('from_name')
                        ->label('Nome Mittente')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('from_email')
                        ->label('Email Mittente')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('reply_to')
                        ->label('Email Risposta')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\KeyValue::make('cc')
                        ->label('CC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\KeyValue::make('bcc')
                        ->label('BCC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\FileUpload::make('attachments')
                        ->label('Allegati')
                        ->multiple()
                        ->directory('attachments'),

                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                        ->keyLabel('Nome')
                        ->valueLabel('Descrizione'),

                    Forms\Components\KeyValue::make('settings')
                        ->label('Impostazioni')
                        ->keyLabel('Chiave')
                        ->valueLabel('Valore'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true)
                ])
                ->columns(2),

            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Contenuto')
                        ->required()
                        ->columnSpanFull()
                ])
        ]);
}
```

#### 4.1.3 Table
```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('subject')
                ->label('Oggetto')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('layout')
                ->label('Layout')
                ->sortable(),

            Tables\Columns\TextColumn::make('version')
                ->label('Versione')
                ->sortable(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('Attivo')
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creato il')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Aggiornato il')
                ->dateTime()
                ->sortable()
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('layout')
                ->options([
                    'default' => 'Default',
                    'clean' => 'Clean',
                    'modern' => 'Modern'
                ]),

            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Attivo')
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('preview')
                ->label('Anteprima')
                ->icon('heroicon-o-eye')
                ->action(function (Template $record) {
                    return redirect()->route('notify.templates.preview', $record);
                }),
            Tables\Actions\Action::make('test')
                ->label('Test')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                ])
                ->action(function (Template $record, array $data) {
                    $record->test($data['email'], $data['variables']);
                    Notification::make()
                        ->title('Email inviata')
                        ->success()
                        ->send();
                })
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\BulkAction::make('activate')
                ->label('Attiva')
                ->icon('heroicon-o-check')
                ->action(function (Collection $records) {
                    $records->each->activate();
                }),
            Tables\Actions\BulkAction::make('deactivate')
                ->label('Disattiva')
                ->icon('heroicon-o-x-mark')
                ->action(function (Collection $records) {
                    $records->each->deactivate();
                })
        ]);
}
```

### 4.2 RelationManagers

#### 4.2.1 TemplateVersionsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateVersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';

    protected static ?string $recordTitleAttribute = 'version';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('version')
                    ->label('Versione')
                    ->required()
                    ->numeric(),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Stato')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Note')
                    ->maxLength(65535)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('version')
                    ->label('Versione')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creato da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('rollback')
                    ->label('Ripristina')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function ($record) {
                        $record->template->rollback($record->version);
                        Notification::make()
                            ->title('Versione ripristinata')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.2 TemplateTranslationsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

    protected static ?string $recordTitleAttribute = 'locale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('locale')
                    ->label('Lingua')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
                    ->required(),

                Forms\Components\TextInput::make('subject')
                    ->label('Oggetto')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('from_name')
                    ->label('Nome Mittente')
                    ->maxLength(255),

                Forms\Components\KeyValue::make('variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Descrizione'),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Oggetto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('translator.name')
                    ->label('Tradotto da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Anteprima')
                    ->icon('heroicon-o-eye')
                    ->action(function ($record) {
                        return redirect()->route('notify.translations.preview', $record);
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.3 TemplateAnalyticsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateAnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    protected static ?string $recordTitleAttribute = 'event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event')
                    ->label('Evento')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ])
                    ->required(),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Metadati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),

                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->maxLength(255),

                Forms\Components\TextInput::make('ip_address')
                    ->label('IP')
                    ->maxLength(45),

                Forms\Components\TextInput::make('session_id')
                    ->label('Sessione')
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('session_id')
                    ->label('Sessione')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Da'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('A')
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([]);
    }
}
```

### 4.3 Widgets

#### 4.3.1 TemplateStatsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Models\Template;

class TemplateStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Template Totali', Template::count())
                ->description('Numero totale di template')
                ->descriptionIcon('heroicon-m-mail')
                ->color('primary'),

            Stat::make('Template Attivi', Template::where('is_active', true)->count())
                ->description('Template attualmente attivi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Template Inattivi', Template::where('is_active', false)->count())
                ->description('Template attualmente inattivi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
        ];
    }
}
```

#### 4.3.2 TemplateAnalyticsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalyticsWidget extends ChartWidget
{
    protected static ?string $heading = 'Analytics Template';

    protected function getData(): array
    {
        $data = TemplateAnalytics::selectRaw('
                event,
                COUNT(*) as count,
                DATE(created_at) as date
            ')
            ->groupBy('event', 'date')
            ->orderBy('date')
            ->get();

        $events = $data->pluck('event')->unique();
        $dates = $data->pluck('date')->unique();

        $datasets = [];
        foreach ($events as $event) {
            $datasets[] = [
                'label' => $this->getEventLabel($event),
                'data' => $dates->map(function ($date) use ($data, $event) {
                    return $data->where('date', $date)
                        ->where('event', $event)
                        ->sum('count');
                })->toArray()
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $dates->toArray()
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getEventLabel(string $event): string
    {
        return [
            'delivered' => 'Consegnati',
            'opened' => 'Aperti',
            'clicked' => 'Cliccati',
            'bounced' => 'Rimbalzati',
            'complained' => 'Segnalati',
            'unsubscribed' => 'Disiscritti'
        ][$event] ?? $event;
    }
}
```

### 4.4 Pages

#### 4.4.1 TemplatePreviewPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Modules\Notify\Models\Template;

class TemplatePreviewPage extends Page
{
    protected static string $view = 'notify::pages.template-preview';

    public Template $template;

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    protected function getViewData(): array
    {
        return [
            'content' => $this->template->preview()
        ];
    }
}
```

#### 4.4.2 TemplateTestPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Modules\Notify\Models\Template;

class TemplateTestPage extends Page
{
    protected static string $view = 'notify::pages.template-test';

    public Template $template;

    public ?array $data = [];

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('data.email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Forms\Components\KeyValue::make('data.variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Valore')
            ]);
    }

    public function test(): void
    {
        $this->validate();

        $this->template->test(
            $this->data['email'],
            $this->data['variables'] ?? []
        );

        $this->notify('success', 'Email inviata con successo');
    }
} 
