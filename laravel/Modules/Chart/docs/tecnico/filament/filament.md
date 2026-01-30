# Risorse Filament

## PatientResource

### Struttura Base
```php
class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestione Pazienti';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dati Anagrafici')
                    ->schema([
                        Forms\Components\TextInput::make('fiscal_code')
                            ->label('Codice Fiscale')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->rules(['regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/']),
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('surname')
                            ->label('Cognome')
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data di Nascita')
                            ->required(),
                        Forms\Components\TextInput::make('birth_place')
                            ->label('Luogo di Nascita')
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->label('Genere')
                            ->options([
                                'M' => 'Maschio',
                                'F' => 'Femmina',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Contatti')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Indirizzo')
                            ->required(),
                        Forms\Components\TextInput::make('city')
                            ->label('Città')
                            ->required(),
                        Forms\Components\TextInput::make('province')
                            ->label('Provincia')
                            ->required(),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('CAP')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefono')
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                    ])->columns(2),

                Forms\Components\Section::make('Dati ISEE e Gravidanza')
                    ->schema([
                        Forms\Components\TextInput::make('isee')
                            ->label('ISEE')
                            ->numeric()
                            ->required()
                            ->rules(['max:20000']),
                        Forms\Components\DatePicker::make('isee_expiry')
                            ->label('Scadenza ISEE')
                            ->required(),
                        Forms\Components\Toggle::make('is_pregnant')
                            ->label('In Gravidanza')
                            ->required(),
                        Forms\Components\DatePicker::make('pregnancy_start_date')
                            ->label('Data Inizio Gravidanza')
                            ->visible(fn (Get $get) => $get('is_pregnant')),
                        Forms\Components\DatePicker::make('expected_delivery_date')
                            ->label('Data Presunta Parto')
                            ->visible(fn (Get $get) => $get('is_pregnant')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fiscal_code')
                    ->label('Codice Fiscale')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surname')
                    ->label('Cognome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isee')
                    ->label('ISEE')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.') . ' €'),
                Tables\Columns\IconColumn::make('is_pregnant')
                    ->label('In Gravidanza')
                    ->boolean(),
                Tables\Columns\TextColumn::make('expected_delivery_date')
                    ->label('Data Parto')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_pregnant')
                    ->label('In Gravidanza'),
                Tables\Filters\Filter::make('isee')
                    ->form([
                        Forms\Components\TextInput::make('max')
                            ->label('ISEE Massimo')
                            ->numeric()
                            ->default(20000),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['max'],
                            fn (Builder $query, $max): Builder => $query->where('isee', '<=', $max),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

## VisitResource

### Struttura Base
```php
class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Gestione Visite';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Visita')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->label('Paziente')
                            ->relationship('patient', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('doctor_id')
                            ->label('Medico')
                            ->relationship('doctor', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\DateTimePicker::make('visit_date')
                            ->label('Data e Ora Visita')
                            ->required(),
                        Forms\Components\Select::make('visit_type')
                            ->label('Tipo Visita')
                            ->options([
                                'first' => 'Prima Visita',
                                'followup' => 'Controllo',
                                'emergency' => 'Emergenza',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Anamnesi')
                    ->schema([
                        Forms\Components\RichEditor::make('anamnesis')
                            ->label('Anamnesi')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Esame Clinico')
                    ->schema([
                        Forms\Components\RichEditor::make('clinical_examination')
                            ->label('Esame Clinico')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Diagnosi e Piano di Trattamento')
                    ->schema([
                        Forms\Components\RichEditor::make('diagnosis')
                            ->label('Diagnosi')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('treatment_plan')
                            ->label('Piano di Trattamento')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Stato Dentale')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Repeater::make('dental_status')
                                    ->label('Stato dei Denti')
                                    ->schema([
                                        Forms\Components\Select::make('tooth')
                                            ->label('Dente')
                                            ->options([
                                                '11' => '11',
                                                '12' => '12',
                                                // ... altri denti
                                            ])
                                            ->required(),
                                        Forms\Components\Select::make('status')
                                            ->label('Stato')
                                            ->options([
                                                'healthy' => 'Sano',
                                                'carious' => 'Cariato',
                                                'missing' => 'Mancante',
                                                'restored' => 'Ricostruito',
                                            ])
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),

                Forms\Components\Section::make('Note e Allegati')
                    ->schema([
                        Forms\Components\RichEditor::make('notes')
                            ->label('Note')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('attachments')
                            ->label('Allegati')
                            ->multiple()
                            ->directory('visits')
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Paziente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Medico')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visit_date')
                    ->label('Data Visita')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visit_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'first' => 'primary',
                        'followup' => 'success',
                        'emergency' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Completata')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('visit_type')
                    ->options([
                        'first' => 'Prima Visita',
                        'followup' => 'Controllo',
                        'emergency' => 'Emergenza',
                    ]),
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Completata'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

## Dashboard

### Struttura Base
```php
class Dashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardStats::class,
            RecentVisits::class,
            PatientTrends::class,
        ];
    }
}
```

### Widgets

#### DashboardStats
```php
class DashboardStats extends Widget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'total_patients' => Patient::count(),
            'pregnant_patients' => Patient::where('is_pregnant', true)->count(),
            'total_visits' => Visit::count(),
            'pending_visits' => Visit::where('is_completed', false)->count(),
        ];
    }
}
```

#### RecentVisits
```php
class RecentVisits extends Widget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'visits' => Visit::with(['patient', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}
```

#### PatientTrends
```php
class PatientTrends extends Widget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'trends' => Patient::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
    }
}
```

## Policies

### PatientPolicy
```php
class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view patients');
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->can('view patients') && 
               $user->tenant_id === $patient->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create patients');
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->can('update patients') && 
               $user->tenant_id === $patient->tenant_id;
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->can('delete patients') && 
               $user->tenant_id === $patient->tenant_id;
    }
}
```

### VisitPolicy
```php
class VisitPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view visits');
    }

    public function view(User $user, Visit $visit): bool
    {
        return $user->can('view visits') && 
               $user->tenant_id === $visit->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create visits');
    }

    public function update(User $user, Visit $visit): bool
    {
        return $user->can('update visits') && 
               $user->tenant_id === $visit->tenant_id;
    }

    public function delete(User $user, Visit $visit): bool
    {
        return $user->can('delete visits') && 
               $user->tenant_id === $visit->tenant_id;
    }
} 
## Collegamenti tra versioni di filament.md
* [filament.md](docs/tecnico/filament/filament.md)
* [filament.md](laravel/Modules/Chart/docs/filament.md)
* [filament.md](laravel/Modules/Gdpr/docs/filament.md)
* [filament.md](laravel/Modules/Xot/docs/technical/filament.md)
* [filament.md](laravel/Modules/Xot/docs/roadmap/integration/filament.md)
* [filament.md](laravel/Modules/Lang/docs/filament.md)
* [filament.md](laravel/Modules/Job/docs/filament.md)
* [filament.md](laravel/Modules/Activity/docs/filament.md)
* [filament.md](laravel/Modules/Cms/docs/filament.md)

