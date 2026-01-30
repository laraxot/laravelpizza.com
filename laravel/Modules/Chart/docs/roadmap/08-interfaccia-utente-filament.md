# Implementazione Interfaccia Utente Filament

## Stato Attuale (30%)

### Completato ✅

1. **Tema Base**
   - Installazione Filament
   - Configurazione base
   - Layout base

2. **Componenti Base**
   - Forms base
   - Tables base
   - Cards base

3. **Personalizzazione Base**
   - Colori base
   - Font base
   - Spacing base

### In Corso 🚧

1. **Personalizzazione Avanzata**
   - Tema personalizzato
   - Componenti custom
   - Layout custom

2. **Funzionalità Avanzate**
   - Dashboard personalizzabili
   - Widget custom
   - Actions custom

3. **Integrazione**
   - Integrazione con moduli
   - Integrazione con API
   - Integrazione con servizi

## Prossimi Passi

1. **Personalizzazione**
   - Sviluppare tema personalizzato
   - Creare componenti custom
   - Implementare layout custom

2. **Funzionalità**
   - Implementare dashboard
   - Sviluppare widget
   - Aggiungere actions

3. **Integrazione**
   - Integrare moduli
   - Collegare API
   - Connettere servizi

## Collegamenti

- [Stato Attuale](../01-stato-attuale.md)
- [Roadmap Principale](../roadmap.md)
- [Implementazione Core](../core/implementazione-core.md)

# Implementazione dell'Interfaccia Utente con Filament

Questo documento fornisce una guida dettagliata per l'implementazione dell'interfaccia utente del progetto il progetto utilizzando Filament 4.x, con particolare attenzione alla creazione di pannelli separati per i diversi tipi di utenti (amministratori, odontoiatri e pazienti).

## Prerequisiti

Prima di iniziare l'implementazione dell'interfaccia utente, assicurarsi che:

1. Le dipendenze di Filament siano correttamente installate
2. I problemi di integrazione dei moduli Laraxot siano stati risolti
3. Il sistema di autenticazione multi-tenant sia operativo

## Struttura dell'Interfaccia Utente

Il progetto il progetto richiede tre pannelli Filament distinti:

1. **Pannello Amministrativo** (`/admin`) - Per gli operatori di backoffice
2. **Pannello Odontoiatri** (`/dentist`) - Per gli odontoiatri che forniscono servizi
3. **Portale Pazienti** (`/patient`) - Per le gestanti che accedono ai servizi

## Implementazione Passo-Passo

### Fase 1: Configurazione dei Pannelli Filament

#### 1.1 Creazione dei Provider di Pannello

Creare tre provider di pannello separati:

```bash
php artisan make:filament-panel admin
php artisan make:filament-panel dentist
php artisan make:filament-panel patient
```

#### 1.2 Configurazione dei Pannelli

Modificare i provider per personalizzare ciascun pannello:

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors([
            'primary' => Color::Blue,
        ])
        ->brandName('il progetto Admin')
        ->favicon(asset('images/favicon.png'))
        ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
        ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
        ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
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
            IdentifyTenant::class, // Middleware per identificare il tenant
        ]);
}
```

Ripetere questa configurazione per gli altri pannelli (`dentist` e `patient`), personalizzando colori, nomi e percorsi.

#### 1.3 Configurazione dell'Autenticazione Specifica per Pannello

Modificare i provider per utilizzare guard di autenticazione specifici:

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        // ...altre configurazioni...
        ->authGuard('admin')
        ->authMiddleware([
            Authenticate::class,
        ]);
}
```

### Fase 2: Sviluppo del Pannello Amministrativo

#### 2.1 Creazione della Dashboard Amministrativa

```bash
php artisan make:filament-page Dashboard --panel=admin
```

Personalizzare la dashboard in `app/Filament/Admin/Pages/Dashboard.php`:

```php
public function getWidgets(): array
{
    return [
        Widgets\PatientStatsWidget::class,
        Widgets\DentistStatsWidget::class,
        Widgets\AppointmentsOverviewWidget::class,
        Widgets\RecentRegistrationsWidget::class,
    ];
}
```

#### 2.2 Creazione dei Widget Amministrativi

```bash
php artisan make:filament-widget PatientStatsWidget --panel=admin
php artisan make:filament-widget DentistStatsWidget --panel=admin
php artisan make:filament-widget AppointmentsOverviewWidget --panel=admin --chart
php artisan make:filament-widget RecentRegistrationsWidget --panel=admin --table
```

Implementare `RecentRegistrationsWidget`:

```php
protected function getTableQuery(): Builder
{
    return Patient::query()->latest()->limit(10);
}

protected function getTableColumns(): array
{
    return [
        Tables\Columns\TextColumn::make('name')
            ->label('Nome')
            ->searchable(),
        Tables\Columns\TextColumn::make('created_at')
            ->label('Data Registrazione')
            ->dateTime()
            ->sortable(),
        Tables\Columns\BadgeColumn::make('status')
            ->label('Stato')
            ->colors([
                'primary' => 'pending',
                'success' => 'approved',
                'danger' => 'rejected',
            ]),
    ];
}
```

#### 2.3 Creazione delle Risorse Amministrative

```bash
php artisan make:filament-resource Patient --panel=admin --generate
php artisan make:filament-resource Dentist --panel=admin --generate
php artisan make:filament-resource Appointment --panel=admin --generate
php artisan make:filament-resource Reimbursement --panel=admin --generate
```

Personalizzare `PatientResource`:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required(),
                    Forms\Components\TextInput::make('surname')
                        ->label('Cognome')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Telefono')
                        ->tel(),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Data di Nascita')
                        ->required(),
                    Forms\Components\FileUpload::make('isee_document')
                        ->label('Documento ISEE')
                        ->required()
                        ->disk('private'),
                    Forms\Components\FileUpload::make('pregnancy_document')
                        ->label('Documento Gravidanza')
                        ->required()
                        ->disk('private'),
                    Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options([
                            'pending' => 'In Attesa',
                            'approved' => 'Approvato',
                            'rejected' => 'Rifiutato',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('rejection_reason')
                        ->label('Motivo Rifiuto')
                        ->visible(fn ($get) => $get('status') === 'rejected'),
                ])
                ->columns(2),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable(),
            Tables\Columns\TextColumn::make('surname')
                ->label('Cognome')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable(),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Stato')
                ->colors([
                    'primary' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Data Registrazione')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Stato')
                ->options([
                    'pending' => 'In Attesa',
                    'approved' => 'Approvato',
                    'rejected' => 'Rifiutato',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('approve')
                ->label('Approva')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn ($record) => $record->status === 'pending')
                ->action(fn ($record) => $record->update(['status' => 'approved'])),
            Tables\Actions\Action::make('reject')
                ->label('Rifiuta')
                ->icon('heroicon-o-x')
                ->color('danger')
                ->visible(fn ($record) => $record->status === 'pending')
                ->form([
                    Forms\Components\Textarea::make('rejection_reason')
                        ->label('Motivo del Rifiuto')
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'status' => 'rejected',
                        'rejection_reason' => $data['rejection_reason'],
                    ]);
                }),
        ]);
}
```

### Fase 3: Sviluppo del Pannello Odontoiatri

#### 3.1 Creazione della Dashboard Odontoiatri

```bash
php artisan make:filament-page Dashboard --panel=dentist
```

Personalizzare la dashboard con widget specifici per gli odontoiatri:

```php
public function getWidgets(): array
{
    return [
        Widgets\AppointmentCalendarWidget::class,
        Widgets\TodayAppointmentsWidget::class,
        Widgets\ReimbursementStatusWidget::class,
    ];
}
```

#### 3.2 Creazione dei Widget per Odontoiatri

```bash
php artisan make:filament-widget AppointmentCalendarWidget --panel=dentist
php artisan make:filament-widget TodayAppointmentsWidget --panel=dentist --table
php artisan make:filament-widget ReimbursementStatusWidget --panel=dentist --stats
```

Implementare il calendario appuntamenti utilizzando `spatie/laravel-calendar`:

```php
protected function getViewData(): array
{
    $dentist = auth()->user()->dentist;
    
    return [
        'appointments' => $dentist->appointments()
            ->with('patient')
            ->where('date', '>=', now()->startOfMonth())
            ->where('date', '<=', now()->endOfMonth())
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->patient->name . ' ' . $appointment->patient->surname,
                    'start' => $appointment->date->format('Y-m-d') . 'T' . $appointment->time->format('H:i:s'),
                    'end' => $appointment->date->format('Y-m-d') . 'T' . $appointment->time->addHour()->format('H:i:s'),
                    'url' => DentistAppointmentResource::getUrl('edit', ['record' => $appointment->id]),
                    'backgroundColor' => match($appointment->status) {
                        'confirmed' => '#10B981',
                        'pending' => '#F59E0B',
                        'completed' => '#6366F1',
                        'cancelled' => '#EF4444',
                        default => '#6B7280',
                    },
                ];
            })
            ->toArray(),
    ];
}
```

#### 3.3 Creazione delle Risorse per Odontoiatri

```bash
php artisan make:filament-resource DentistAppointment --panel=dentist --generate
php artisan make:filament-resource DentistPatient --panel=dentist --generate
php artisan make:filament-resource DentistReimbursement --panel=dentist --generate
```

Personalizzare `DentistAppointmentResource`:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('patient_name')
                        ->label('Paziente')
                        ->default(fn ($record) => $record ? $record->patient->name . ' ' . $record->patient->surname : '')
                        ->disabled(),
                    Forms\Components\DatePicker::make('date')
                        ->label('Data')
                        ->disabled(fn ($record) => $record && $record->status !== 'pending'),
                    Forms\Components\TimePicker::make('time')
                        ->label('Ora')
                        ->disabled(fn ($record) => $record && $record->status !== 'pending'),
                    Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options([
                            'pending' => 'In Attesa',
                            'confirmed' => 'Confermato',
                            'completed' => 'Completato',
                            'cancelled' => 'Annullato',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('notes')
                        ->label('Note'),
                    Forms\Components\Textarea::make('medical_report')
                        ->label('Referto Medico')
                        ->visible(fn ($record) => $record && $record->status === 'completed'),
                ])
                ->columns(2),
        ]);
}
```

### Fase 4: Sviluppo del Portale Pazienti

#### 4.1 Creazione della Dashboard Pazienti

```bash
php artisan make:filament-page Dashboard --panel=patient
```

Personalizzare la dashboard per i pazienti:

```php
public function getWidgets(): array
{
    return [
        Widgets\PatientProfileWidget::class,
        Widgets\PatientAppointmentsWidget::class,
        Widgets\FindDentistWidget::class,
    ];
}
```

#### 4.2 Creazione dei Widget per Pazienti

```bash
php artisan make:filament-widget PatientProfileWidget --panel=patient
php artisan make:filament-widget PatientAppointmentsWidget --panel=patient --table
php artisan make:filament-widget FindDentistWidget --panel=patient
```

Implementare il widget per trovare un dentista:

```php
protected function getFormSchema(): array
{
    return [
        Forms\Components\Card::make()
            ->schema([
                Forms\Components\TextInput::make('location')
                    ->label('Cerca per località')
                    ->required(),
                Forms\Components\Select::make('distance')
                    ->label('Distanza massima')
                    ->options([
                        5 => '5 km',
                        10 => '10 km',
                        20 => '20 km',
                        50 => '50 km',
                    ])
                    ->default(10),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('search')
                        ->label('Cerca')
                        ->action('searchDentists'),
                ]),
            ]),
    ];
}

public function searchDentists(): void
{
    $data = $this->form->getState();
    
    $this->dentists = Dentist::where('status', 'approved')
        ->where(function ($query) use ($data) {
            // Implementare la logica di geolocalizzazione
        })
        ->get();
}
```

#### 4.3 Creazione delle Risorse per Pazienti

```bash
php artisan make:filament-resource PatientAppointment --panel=patient --generate
php artisan make:filament-resource PatientDentist --panel=patient --generate
```

### Fase 5: Implementazione di Funzionalità Condivise

#### 5.1 Notifiche Filament

Configurare le notifiche Filament per comunicazioni tra utenti:

```php
// Esempio: Notifica di conferma appuntamento
Notification::make()
    ->title('Appuntamento Confermato')
    ->body("Il tuo appuntamento per il {$appointment->date->format('d/m/Y')} alle {$appointment->time->format('H:i')} è stato confermato.")
    ->success()
    ->send();
```

#### 5.2 Azioni Personalizzate

Creare azioni personalizzate per flussi specifici:

```php
// Esempio: Azione per completare un appuntamento e generare richiesta di rimborso
Tables\Actions\Action::make('complete_visit')
    ->label('Completa Visita')
    ->icon('heroicon-o-check-circle')
    ->color('success')
    ->visible(fn ($record) => $record->status === 'confirmed')
    ->form([
        Forms\Components\Textarea::make('medical_report')
            ->label('Referto Medico')
            ->required(),
    ])
    ->action(function ($record, array $data) {
        DB::transaction(function () use ($record, $data) {
            $record->update([
                'status' => 'completed',
                'medical_report' => $data['medical_report'],
            ]);
            
            // Creare automaticamente la richiesta di rimborso
            Reimbursement::create([
                'dentist_id' => auth()->user()->dentist->id,
                'appointment_id' => $record->id,
                'amount' => 100.00, // Importo fisso o calcolato
                'status' => 'pending',
            ]);
        });
        
        Notification::make()
            ->title('Visita Completata')
            ->body('La visita è stata completata e la richiesta di rimborso è stata creata.')
            ->success()
            ->send();
    }),
```

#### 5.3 Multi-Lingua

Configurare la localizzazione per supportare italiano e inglese:

```php
// config/filament.php
'default_locale' => 'it',
'fallback_locale' => 'en',
'locale_switcher' => true,
```

Creare i file di traduzione in `lang/it/filament.php`:

```php
return [
    'pages' => [
        'dashboard' => [
            'title' => 'Pannello di Controllo',
        ],
    ],
    'resources' => [
        'patient' => [
            'label' => 'Paziente',
            'plural_label' => 'Pazienti',
        ],
        // Altre traduzioni...
    ],
];
```

### Fase 6: Sicurezza e Permessi

#### 6.1 Configurazione delle Policy

Creare policy per controllare l'accesso alle risorse:

```bash
php artisan make:policy PatientPolicy --model=Patient
php artisan make:policy DentistPolicy --model=Dentist
php artisan make:policy AppointmentPolicy --model=Appointment
```

Implementare `AppointmentPolicy`:

```php
public function viewAny(User $user): bool
{
    if ($user->hasRole('administrator')) {
        return true;
    }
    
    if ($user->hasRole('dentist')) {
        return true;
    }
    
    if ($user->hasRole('patient')) {
        return true;
    }
    
    return false;
}

public function view(User $user, Appointment $appointment): bool
{
    if ($user->hasRole('administrator')) {
        return true;
    }
    
    if ($user->hasRole('dentist') && $appointment->dentist_id === $user->dentist->id) {
        return true;
    }
    
    if ($user->hasRole('patient') && $appointment->patient_id === $user->patient->id) {
        return true;
    }
    
    return false;
}

// Implementare altri metodi (create, update, delete)...
```

#### 6.2 Integrazione con Spatie Permissions

Integrare Filament con Spatie Laravel Permission:

```php
// Configurare i service provider
class DentistPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...altre configurazioni...
            ->authGuard('web')
            ->authMiddleware([
                Authenticate::class,
                'role:dentist', // Middleware di Spatie Laravel Permission
            ]);
    }
}
```

## Test e Ottimizzazione

### Test dell'Interfaccia Utente

1. **Test Funzionali**:
   - Testare il flusso di registrazione e autenticazione
   - Verificare il funzionamento delle dashboard
   - Testare le operazioni CRUD su tutte le risorse

2. **Test Responsivi**:
   - Verificare la visualizzazione su dispositivi mobile
   - Testare la navigazione e le interazioni su schermi di diverse dimensioni

3. **Test di Accessibilità**:
   - Verificare contrasto colori
   - Testare navigazione da tastiera
   - Verificare compatibilità con tecnologie assistive

### Ottimizzazione per la Produzione

1. **Minificazione Assets**:
   ```bash
   npm run build
   ```

2. **Caching**:
   ```bash
   php artisan filament:cache-resources
   php artisan view:cache
   ```

3. **Performance**:
   - Ottimizzare le query del database
   - Implementare il lazy loading per relazioni complesse
   - Utilizzare il caching per operazioni ripetitive

## Conclusione

L'implementazione dell'interfaccia utente con Filament permetterà di creare un'esperienza utente ricca e intuitiva per tutti i tipi di utenti della piattaforma il progetto. Seguendo questa guida, sarà possibile sviluppare pannelli specifici per amministratori, odontoiatri e pazienti, garantendo la sicurezza e l'usabilità dell'applicazione. 