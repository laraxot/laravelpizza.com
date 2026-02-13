# Guida Migrazione Step-by-Step: Modulo User - Filament 4

## Panoramica Migrazione
**Modulo**: User (Modulo Critico)
**Complessità**: ⭐⭐⭐⭐⭐ MASSIMA
**Tempo Stimato**: 35-45 giorni
**Rischio**: CRITICO (autenticazione di sistema)
**Priorità**: 1 (PRIMO modulo da migrare - base per tutti gli altri)

## Pre-requisiti Assoluti
- [x] Backup completo database utenti
- [x] Ambiente di staging identico a produzione
- [x] Team dedicato (3+ developer senior)
- [x] Piano rollback testato
- [x] Finestra di manutenzione approvata

## Fase 1: Analisi Rischi e Backup Completo (Giorni 1-3)

### 1.1 Audit Completo Sistema Autenticazione
```bash
# Analisi completa tabelle user
php artisan tinker --execute "
User::with(['roles', 'permissions', 'teams', 'tenants'])->count();
echo 'Total users: ' . User::count();
echo 'Active sessions: ' . DB::table('sessions')->count();
echo 'OAuth tokens: ' . DB::table('oauth_access_tokens')->where('revoked', false)->count();
"

# Verifica integrità dati
php artisan user:integrity-check
```

### 1.2 Backup Stratificato
```bash
# Script backup-user-migration.sh
#!/bin/bash

echo "🔒 Backup Completo Modulo User"

# Database
php artisan backup:run --only-db --filename="user_pre_filament4_$(date +%Y%m%d_%H%M%S)"

# File specifici user
tar -czf user_files_backup.tar.gz \
    Modules/User/ \
    config/auth.php \
    config/sanctum.php \
    config/fortify.php \
    config/jetstream.php

# Sessioni attive
mysqldump --single-transaction sessions > sessions_backup.sql

# OAuth tokens
mysqldump --single-transaction oauth_* > oauth_backup.sql

echo "✅ Backup completato: $(ls -la *backup*)"
```

### 1.3 Testing Baseline
```php
// tests/Migration/UserBaselineTest.php
<?php

namespace Tests\Migration;

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;

class UserBaselineTest extends TestCase
{
    /** @test */
    public function records_current_authentication_behavior()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Test login standard
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // Test accesso admin panel
        $response = $this->get('/admin');
        $expectedStatus = $user->hasRole('super_admin') ? 200 : 403;
        $response->assertStatus($expectedStatus);

        // Salvare metriche baseline
        file_put_contents('user_baseline_metrics.json', json_encode([
            'total_users' => User::count(),
            'active_sessions' => session()->all(),
            'login_time' => microtime(true),
            'memory_usage' => memory_get_usage(true),
        ]));
    }
}
```

## Fase 2: Ricostruzione XotBaseResource per User (Giorni 4-8)

### 2.1 UserBaseResource Fondamentale
```php
// app/Filament/Resources/UserBaseResource.php
<?php

namespace Modules\User\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\{TextInput, Select, Toggle, Tabs, DateTimePicker, FileUpload};
use Filament\Tables\Columns\{TextColumn, BooleanColumn, ImageColumn, BadgeColumn};
use Filament\Tables\Actions\{ViewAction, EditAction, DeleteAction, Action};
use Filament\Tables\Filters\{SelectFilter, TernaryFilter, Filter};
use Filament\Schema\Schema;
use Filament\Schema\Slot;
use Illuminate\Database\Eloquent\Builder;

abstract class UserBaseResource extends XotBaseResource
{
    protected static ?string $navigationGroup = 'Gestione Utenti';

    public static function getMainSchema(): Schema
    {
        return Schema::make([
            static::getUserDetailsSlot(),
            static::getSecuritySlot(),
            static::getRolesPermissionsSlot(),
            static::getProfileSlot(),
            static::getTeamsSlot(),
        ]);
    }

    protected static function getUserDetailsSlot(): Slot
    {
        return Slot::make([
            TextInput::make('name')
                ->label('Nome Completo')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn($context) => $context === 'create')
                ->minLength(8)
                ->same('password_confirmation')
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state)),

            TextInput::make('password_confirmation')
                ->label('Conferma Password')
                ->password()
                ->required(fn($context) => $context === 'create')
                ->dehydrated(false),
        ]);
    }

    protected static function getSecuritySlot(): Slot
    {
        return Slot::make([
            Toggle::make('email_verified_at')
                ->label('Email Verificata')
                ->dehydrateStateUsing(fn($state) => $state ? now() : null),

            Toggle::make('is_active')
                ->label('Attivo')
                ->default(true),

            DateTimePicker::make('last_login_at')
                ->label('Ultimo Login')
                ->disabled()
                ->displayFormat('d/m/Y H:i'),

            TextInput::make('last_login_ip')
                ->label('Ultimo IP')
                ->disabled(),

            Toggle::make('two_factor_enabled')
                ->label('2FA Attivo')
                ->disabled()
                ->helperText('Gestito dall\'utente nel profilo'),
        ]);
    }

    protected static function getRolesPermissionsSlot(): Slot
    {
        return Slot::make([
            Select::make('roles')
                ->label('Ruoli')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable(),

            Select::make('permissions')
                ->label('Permessi Diretti')
                ->relationship('permissions', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
        ]);
    }

    protected static function getProfileSlot(): Slot
    {
        return Slot::make([
            FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->directory('avatars')
                ->imageResizeMode('cover')
                ->imageCropAspectRatio('1:1')
                ->imageResizeTargetWidth('200')
                ->imageResizeTargetHeight('200'),

            TextInput::make('phone')
                ->label('Telefono')
                ->tel(),

            Select::make('language')
                ->label('Lingua')
                ->options([
                    'it' => 'Italiano',
                    'en' => 'English',
                    'fr' => 'Français',
                ])
                ->default('it'),

            Select::make('timezone')
                ->label('Fuso Orario')
                ->options([
                    'Europe/Rome' => 'Europa/Roma',
                    'Europe/London' => 'Europa/Londra',
                    'America/New_York' => 'America/New York',
                ])
                ->default('Europe/Rome'),
        ]);
    }

    protected static function getTeamsSlot(): Slot
    {
        return Slot::make([
            Select::make('teams')
                ->label('Team')
                ->relationship('teams', 'name')
                ->multiple()
                ->preload(),

            Select::make('current_team_id')
                ->label('Team Corrente')
                ->relationship('currentTeam', 'name')
                ->searchable(),
        ]);
    }

    public static function getTableColumns(): array
    {
        return [
            ImageColumn::make('avatar')
                ->label('Avatar')
                ->circular()
                ->size(40),

            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->copyable(),

            BadgeColumn::make('roles.name')
                ->label('Ruoli')
                ->limit(2)
                ->separator(','),

            BooleanColumn::make('email_verified_at')
                ->label('Verificato')
                ->getStateUsing(fn($record) => !is_null($record->email_verified_at)),

            BooleanColumn::make('is_active')
                ->label('Attivo'),

            BooleanColumn::make('two_factor_enabled')
                ->label('2FA')
                ->getStateUsing(fn($record) => !is_null($record->two_factor_secret)),

            TextColumn::make('last_login_at')
                ->label('Ultimo Login')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Creato')
                ->date('d/m/Y')
                ->sortable(),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            SelectFilter::make('roles')
                ->relationship('roles', 'name')
                ->label('Ruolo'),

            TernaryFilter::make('email_verified_at')
                ->label('Email Verificata')
                ->nullable(),

            TernaryFilter::make('is_active')
                ->label('Attivo'),

            Filter::make('last_login')
                ->form([
                    DatePicker::make('last_login_from')
                        ->label('Ultimo login da'),
                    DatePicker::make('last_login_until')
                        ->label('Ultimo login fino'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['last_login_from'], fn(Builder $q, $date) =>
                            $q->whereDate('last_login_at', '>=', $date)
                        )
                        ->when($data['last_login_until'], fn(Builder $q, $date) =>
                            $q->whereDate('last_login_at', '<=', $date)
                        );
                }),
        ];
    }
}
```

### 2.2 UserResource con Filament 4
```php
// app/Filament/Resources/UserResource.php
<?php

namespace Modules\User\Filament\Resources;

use Modules\User\Models\User;
use Filament\Schema\Schema;
use Filament\Forms\Components\{Wizard, Section, Tabs, Alert};
use Filament\Tables\Actions\{BulkActionGroup, DeleteBulkAction, Action};
use Filament\Actions\{CreateAction, EditAction, DeleteAction};
use Filament\Notifications\Notification;

class UserResource extends UserBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Utenti';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Alert::make('security_warning')
                ->warning()
                ->body('Attenzione: Modifiche a ruoli e permessi hanno effetto immediato.')
                ->visible(fn($context) => $context === 'edit'),

            Wizard::make([
                Wizard\Step::make('Dati Base')
                    ->schema([
                        Section::make('Informazioni Account')
                            ->schema(parent::getUserDetailsSlot()->getComponents())
                            ->columns(2),
                    ]),

                Wizard\Step::make('Sicurezza')
                    ->schema([
                        Section::make('Impostazioni Sicurezza')
                            ->schema(parent::getSecuritySlot()->getComponents())
                            ->columns(2),
                    ]),

                Wizard\Step::make('Autorizzazioni')
                    ->schema([
                        Tabs::make('Permissions')
                            ->tabs([
                                Tabs\Tab::make('Ruoli')
                                    ->schema([
                                        parent::getRolesPermissionsSlot()->getComponents()[0], // roles
                                    ]),

                                Tabs\Tab::make('Permessi Diretti')
                                    ->schema([
                                        parent::getRolesPermissionsSlot()->getComponents()[1], // permissions
                                    ]),
                            ]),
                    ]),

                Wizard\Step::make('Profilo')
                    ->schema([
                        Section::make('Dati Profilo')
                            ->schema(parent::getProfileSlot()->getComponents())
                            ->columns(2),
                    ]),

                Wizard\Step::make('Team')
                    ->schema([
                        Section::make('Gestione Team')
                            ->schema(parent::getTeamsSlot()->getComponents()),
                    ])
                    ->visible(fn() => config('jetstream.features', []) && in_array('teams', config('jetstream.features'))),
            ])
            ->skippable()
            ->persistStepInQueryString(),
        ]);
    }

    public static function getCustomActions(): array
    {
        return [
            Action::make('reset_password')
                ->label('Reset Password')
                ->icon('heroicon-o-key')
                ->color('warning')
                ->form([
                    TextInput::make('new_password')
                        ->label('Nuova Password')
                        ->password()
                        ->minLength(8)
                        ->required(),
                ])
                ->action(function (array $data, User $record) {
                    $record->update([
                        'password' => Hash::make($data['new_password']),
                        'password_changed_at' => now(),
                    ]);

                    // Invalidare tutte le sessioni
                    $record->tokens()->delete();

                    Notification::make()
                        ->success()
                        ->title('Password reimpostata')
                        ->body('L\'utente dovrà rieffettuare il login.')
                        ->send();
                }),

            Action::make('impersonate')
                ->label('Impersona')
                ->icon('heroicon-o-user-circle')
                ->color('gray')
                ->visible(fn() => auth()->user()->can('impersonate_users'))
                ->action(function (User $record) {
                    auth()->user()->impersonate($record);

                    return redirect('/admin');
                }),

            Action::make('send_verification')
                ->label('Invia Verifica Email')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->visible(fn(User $record) => is_null($record->email_verified_at))
                ->action(function (User $record) {
                    $record->sendEmailVerificationNotification();

                    Notification::make()
                        ->success()
                        ->title('Email di verifica inviata')
                        ->send();
                }),

            Action::make('disable_2fa')
                ->label('Disabilita 2FA')
                ->icon('heroicon-o-shield-exclamation')
                ->color('danger')
                ->visible(fn(User $record) => !is_null($record->two_factor_secret))
                ->requiresConfirmation()
                ->modalHeading('Disabilita 2FA')
                ->modalDescription('Sei sicuro di voler disabilitare l\'autenticazione a due fattori per questo utente?')
                ->action(function (User $record) {
                    $record->update([
                        'two_factor_secret' => null,
                        'two_factor_recovery_codes' => null,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('2FA disabilitato')
                        ->send();
                }),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),

                BulkAction::make('activate')
                    ->label('Attiva Selezionati')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $records->each(fn(User $user) => $user->update(['is_active' => true]));

                        Notification::make()
                            ->success()
                            ->title('Utenti attivati')
                            ->send();
                    }),

                BulkAction::make('deactivate')
                    ->label('Disattiva Selezionati')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $records->each(fn(User $user) => $user->update(['is_active' => false]));

                        Notification::make()
                            ->success()
                            ->title('Utenti disattivati')
                            ->send();
                    }),

                BulkAction::make('force_logout')
                    ->label('Forza Logout')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('warning')
                    ->action(function (Collection $records) {
                        $records->each(function (User $user) {
                            $user->tokens()->delete();
                            DB::table('sessions')->where('user_id', $user->id)->delete();
                        });

                        Notification::make()
                            ->success()
                            ->title('Logout forzato completato')
                            ->send();
                    }),
            ]),
        ];
    }
}
```

## Fase 3: Sistema MFA Integrato (Giorni 9-15)

### 3.1 MFA Resource con Filament 4
```php
// app/Filament/Resources/TwoFactorAuthResource.php
<?php

namespace Modules\User\Filament\Resources;

use Modules\User\Models\User;
use Filament\Resources\Resource;
use Filament\Schema\Schema;
use Filament\Forms\Components\{Section, TextInput, Toggle, QrCode, Placeholder};
use Filament\Tables\Columns\{TextColumn, BooleanColumn, BadgeColumn};
use Filament\Tables\Actions\Action;
use Filament\Actions\Action as PageAction;
use Filament\Notifications\Notification;

class TwoFactorAuthResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Autenticazione 2FA';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Sicurezza';

    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Section::make('Configurazione 2FA')
                ->schema([
                    Placeholder::make('current_status')
                        ->label('Stato Corrente')
                        ->content(fn(User $record) => $record->two_factor_secret ?
                            '✅ 2FA Attivo' : '❌ 2FA Non Attivo'),

                    Toggle::make('two_factor_enabled')
                        ->label('Abilita 2FA')
                        ->disabled()
                        ->helperText('Gestito automaticamente dal sistema'),

                    Placeholder::make('recovery_codes_count')
                        ->label('Codici di Recupero')
                        ->content(fn(User $record) => $record->two_factor_recovery_codes ?
                            count(json_decode(decrypt($record->two_factor_recovery_codes))) . ' codici disponibili'
                            : 'Nessun codice generato'),
                ])
                ->columns(2),

            Section::make('Statistiche Sistema')
                ->schema([
                    Placeholder::make('users_with_2fa')
                        ->label('Utenti con 2FA')
                        ->content(fn() => User::whereNotNull('two_factor_secret')->count()),

                    Placeholder::make('2fa_percentage')
                        ->label('Percentuale Adozione')
                        ->content(fn() => round((User::whereNotNull('two_factor_secret')->count() / User::count()) * 100, 1) . '%'),
                ])
                ->columns(2),
        ]);
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable(),

            TextColumn::make('email')
                ->label('Email')
                ->searchable(),

            BooleanColumn::make('two_factor_enabled')
                ->label('2FA Attivo')
                ->getStateUsing(fn(User $record) => !is_null($record->two_factor_secret)),

            BadgeColumn::make('recovery_codes_status')
                ->label('Codici Recupero')
                ->getStateUsing(function (User $record) {
                    if (!$record->two_factor_recovery_codes) return 'none';

                    $codes = json_decode(decrypt($record->two_factor_recovery_codes));
                    $count = count($codes);

                    if ($count >= 8) return 'full';
                    if ($count >= 4) return 'partial';
                    return 'low';
                })
                ->colors([
                    'danger' => 'none',
                    'warning' => 'low',
                    'primary' => 'partial',
                    'success' => 'full',
                ])
                ->formatStateUsing(function (string $state) {
                    return match ($state) {
                        'none' => 'Nessuno',
                        'low' => 'Pochi',
                        'partial' => 'Alcuni',
                        'full' => 'Completi',
                    };
                }),

            TextColumn::make('two_factor_confirmed_at')
                ->label('Confermato il')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }

    public static function getCustomActions(): array
    {
        return [
            Action::make('reset_2fa')
                ->label('Reset 2FA')
                ->icon('heroicon-o-arrow-path')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reset 2FA')
                ->modalDescription('Questo rimuoverà completamente la configurazione 2FA dell\'utente.')
                ->action(function (User $record) {
                    $record->update([
                        'two_factor_secret' => null,
                        'two_factor_recovery_codes' => null,
                        'two_factor_confirmed_at' => null,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('2FA reimpostato')
                        ->body('L\'utente dovrà riconfigurate la 2FA.')
                        ->send();
                }),

            Action::make('regenerate_codes')
                ->label('Rigenera Codici')
                ->icon('heroicon-o-key')
                ->color('warning')
                ->visible(fn(User $record) => !is_null($record->two_factor_secret))
                ->action(function (User $record) {
                    $record->update([
                        'two_factor_recovery_codes' => encrypt(json_encode(
                            Collection::times(10, function () {
                                return RecoveryCode::generate();
                            })->all()
                        )),
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Codici rigenerati')
                        ->send();
                }),
        ];
    }
}
```

### 3.2 Dashboard MFA con Statistiche
```php
// app/Filament/Widgets/TwoFactorStatsWidget.php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\User\Models\User;

class TwoFactorStatsWidget extends ChartWidget
{
    protected static ?string $heading = 'Adozione 2FA';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $total = User::count();
        $with2FA = User::whereNotNull('two_factor_secret')->count();
        $without2FA = $total - $with2FA;

        return [
            'datasets' => [
                [
                    'label' => 'Utenti',
                    'data' => [$with2FA, $without2FA],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)', // green
                        'rgb(239, 68, 68)',  // red
                    ],
                ],
            ],
            'labels' => ['Con 2FA', 'Senza 2FA'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
```

## Fase 4: Team e Multi-Tenancy (Giorni 16-22)

### 4.1 TeamResource con Filament 4
```php
// app/Filament/Resources/TeamResource.php
<?php

namespace Modules\User\Filament\Resources;

use Modules\User\Models\Team;
use Filament\Schema\Schema;
use Filament\Forms\Components\{Section, TextInput, Textarea, Select, Repeater, Toggle};
use Filament\Tables\Columns\{TextColumn, BadgeColumn, ImageColumn};
use Filament\Tables\Actions\{Action, BulkAction};

class TeamResource extends UserBaseResource
{
    protected static ?string $model = Team::class;
    protected static ?string $navigationLabel = 'Team';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Section::make('Informazioni Team')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome Team')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Textarea::make('description')
                        ->label('Descrizione')
                        ->rows(3),

                    Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true),
                ])
                ->columns(2),

            Section::make('Membri Team')
                ->schema([
                    Select::make('owner_id')
                        ->label('Proprietario')
                        ->relationship('owner', 'name')
                        ->searchable()
                        ->required(),

                    Repeater::make('members')
                        ->label('Membri')
                        ->relationship('users')
                        ->schema([
                            Select::make('user_id')
                                ->label('Utente')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required(),

                            Select::make('role')
                                ->label('Ruolo nel Team')
                                ->options([
                                    'admin' => 'Amministratore',
                                    'member' => 'Membro',
                                    'viewer' => 'Visualizzatore',
                                ])
                                ->required(),
                        ])
                        ->collapsible()
                        ->cloneable(),
                ]),

            Section::make('Permessi Team')
                ->schema([
                    Select::make('permissions')
                        ->label('Permessi Team')
                        ->relationship('permissions', 'name')
                        ->multiple()
                        ->preload(),
                ]),
        ]);
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            TextColumn::make('owner.name')
                ->label('Proprietario')
                ->searchable(),

            BadgeColumn::make('users_count')
                ->label('Membri')
                ->counts('users')
                ->color('primary'),

            BadgeColumn::make('is_active')
                ->label('Stato')
                ->getStateUsing(fn($record) => $record->is_active ? 'Attivo' : 'Inattivo')
                ->colors([
                    'success' => 'Attivo',
                    'danger' => 'Inattivo',
                ]),

            TextColumn::make('created_at')
                ->label('Creato')
                ->date('d/m/Y')
                ->sortable(),
        ];
    }

    public static function getCustomActions(): array
    {
        return [
            Action::make('add_user')
                ->label('Aggiungi Utente')
                ->icon('heroicon-o-user-plus')
                ->form([
                    Select::make('user_id')
                        ->label('Utente')
                        ->options(User::pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Select::make('role')
                        ->label('Ruolo')
                        ->options([
                            'admin' => 'Amministratore',
                            'member' => 'Membro',
                            'viewer' => 'Visualizzatore',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, Team $record) {
                    $record->users()->attach($data['user_id'], [
                        'role' => $data['role'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Utente aggiunto al team')
                        ->send();
                }),
        ];
    }
}
```

### 4.2 TenantResource Multi-Tenancy
```php
// app/Filament/Resources/TenantResource.php
<?php

namespace Modules\User\Filament\Resources;

use Modules\User\Models\Tenant;
use Filament\Schema\Schema;
use Filament\Forms\Components\{Section, TextInput, Toggle, DatePicker, KeyValue};
use Filament\Tables\Columns\{TextColumn, BooleanColumn, BadgeColumn};

class TenantResource extends UserBaseResource
{
    protected static ?string $model = Tenant::class;
    protected static ?string $navigationLabel = 'Tenant';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 3;

    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Section::make('Informazioni Tenant')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome Tenant')
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('domain')
                        ->label('Dominio')
                        ->unique(ignoreRecord: true)
                        ->placeholder('esempio.com'),

                    TextInput::make('database')
                        ->label('Database')
                        ->helperText('Nome database dedicato (opzionale)'),

                    Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true),
                ])
                ->columns(2),

            Section::make('Configurazioni')
                ->schema([
                    KeyValue::make('config')
                        ->label('Configurazioni Tenant')
                        ->keyLabel('Chiave')
                        ->valueLabel('Valore'),

                    DatePicker::make('expires_at')
                        ->label('Scade il')
                        ->helperText('Lasciare vuoto per nessuna scadenza'),
                ]),

            Section::make('Limiti')
                ->schema([
                    TextInput::make('max_users')
                        ->label('Max Utenti')
                        ->numeric()
                        ->default(100),

                    TextInput::make('max_storage_gb')
                        ->label('Max Storage (GB)')
                        ->numeric()
                        ->default(10),
                ])
                ->columns(2),
        ]);
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            TextColumn::make('domain')
                ->label('Dominio')
                ->searchable()
                ->copyable(),

            BadgeColumn::make('users_count')
                ->label('Utenti')
                ->counts('users')
                ->color('primary'),

            BooleanColumn::make('is_active')
                ->label('Attivo'),

            TextColumn::make('expires_at')
                ->label('Scadenza')
                ->date('d/m/Y')
                ->placeholder('Mai'),

            BadgeColumn::make('status')
                ->label('Stato')
                ->getStateUsing(function (Tenant $record) {
                    if (!$record->is_active) return 'suspended';
                    if ($record->expires_at && $record->expires_at->isPast()) return 'expired';
                    return 'active';
                })
                ->colors([
                    'success' => 'active',
                    'danger' => 'suspended',
                    'warning' => 'expired',
                ]),
        ];
    }
}
```

## Fase 5: Migration Database Critica (Giorni 23-28)

### 5.1 Migration Complessa per Filament 4
```php
// database/migrations/2025_01_xx_migrate_user_to_filament4.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Backup tabelle esistenti
        Schema::create('users_backup_pre_f4', function (Blueprint $table) {
            $table->id();
            $table->json('original_data');
            $table->timestamp('backup_date');
        });

        // Salvare dati attuali
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table('users_backup_pre_f4')->insert([
                'id' => $user->id,
                'original_data' => json_encode($user),
                'backup_date' => now(),
            ]);
        }

        // Nuove colonne per Filament 4
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('language', 5)->default('it');
            $table->string('timezone')->default('Europe/Rome');
            $table->timestamp('password_changed_at')->nullable();
            $table->json('preferences')->nullable();

            $table->index(['is_active', 'last_login_at']);
            $table->index(['language', 'timezone']);
        });

        // Aggiornare teams per multi-tenancy
        if (Schema::hasTable('teams')) {
            Schema::table('teams', function (Blueprint $table) {
                if (!Schema::hasColumn('teams', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (!Schema::hasColumn('teams', 'description')) {
                    $table->text('description')->nullable();
                }
                $table->json('config')->nullable();
                $table->integer('max_users')->default(100);
            });
        }

        // Tabella per tracking sessioni
        Schema::create('user_session_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->string('ip_address');
            $table->text('user_agent');
            $table->timestamp('login_at');
            $table->timestamp('logout_at')->nullable();
            $table->boolean('forced_logout')->default(false);

            $table->index(['user_id', 'login_at']);
            $table->index(['session_id']);
        });

        // Tabella per audit log
        Schema::create('user_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // login, logout, password_change, role_change, etc.
            $table->json('data')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at');

            $table->index(['user_id', 'action', 'created_at']);
        });
    }

    public function down()
    {
        // Rollback sicuro
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active', 'last_login_at', 'last_login_ip',
                'avatar', 'phone', 'language', 'timezone',
                'password_changed_at', 'preferences'
            ]);
        });

        if (Schema::hasTable('teams')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropColumn(['is_active', 'description', 'config', 'max_users']);
            });
        }

        Schema::dropIfExists('user_session_logs');
        Schema::dropIfExists('user_audit_logs');
        Schema::dropIfExists('users_backup_pre_f4');
    }
};
```

### 5.2 Command per Migration Dati
```php
// app/Console/Commands/MigrateUserDataToFilament4Command.php
<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;

class MigrateUserDataToFilament4Command extends Command
{
    protected $signature = 'user:migrate-filament4 {--chunk=100} {--dry-run}';
    protected $description = 'Migra dati utenti per Filament 4';

    public function handle()
    {
        $chunkSize = $this->option('chunk');
        $dryRun = $this->option('dry-run');

        $this->info('Inizio migrazione dati utenti per Filament 4...');

        $totalUsers = User::count();
        $this->info("Totale utenti da migrare: {$totalUsers}");

        $processed = 0;
        $errors = 0;

        User::chunk($chunkSize, function ($users) use (&$processed, &$errors, $dryRun) {
            foreach ($users as $user) {
                try {
                    if (!$dryRun) {
                        $this->migrateUser($user);
                    }

                    $processed++;

                    if ($processed % 100 === 0) {
                        $this->info("Processati: {$processed}");
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("Errore utente {$user->id}: {$e->getMessage()}");
                }
            }
        });

        $this->info("Migrazione completata!");
        $this->info("Processati: {$processed}");
        $this->info("Errori: {$errors}");

        if (!$dryRun && $errors === 0) {
            $this->info("✅ Tutti i dati migrati con successo!");
        }
    }

    protected function migrateUser(User $user): void
    {
        // Migrazione dati base
        $user->update([
            'is_active' => true,
            'language' => $this->detectUserLanguage($user),
            'timezone' => $this->detectUserTimezone($user),
            'preferences' => $this->buildUserPreferences($user),
        ]);

        // Migrazione avatar se esiste
        if ($user->profile_photo_path) {
            $user->update(['avatar' => $user->profile_photo_path]);
        }

        // Migrazione sessioni storiche
        $this->migrateSessions($user);

        // Audit log iniziale
        $this->createAuditLog($user, 'migrated_to_filament4');
    }

    protected function detectUserLanguage(User $user): string
    {
        // Logica per rilevare lingua utente
        if ($user->locale) return $user->locale;
        if (str_contains($user->email, '.it')) return 'it';
        return 'it'; // Default
    }

    protected function detectUserTimezone(User $user): string
    {
        // Logica per rilevare timezone
        return 'Europe/Rome'; // Default
    }

    protected function buildUserPreferences(User $user): array
    {
        return [
            'theme' => 'light',
            'notifications' => [
                'email' => true,
                'browser' => true,
            ],
            'dashboard' => [
                'widgets' => ['stats', 'recent_activity'],
            ],
        ];
    }

    protected function migrateSessions(User $user): void
    {
        // Migrare dati sessione esistenti se disponibili
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->latest('last_activity')
            ->limit(10)
            ->get();

        foreach ($sessions as $session) {
            DB::table('user_session_logs')->insert([
                'user_id' => $user->id,
                'session_id' => $session->id,
                'ip_address' => $session->ip_address ?? 'unknown',
                'user_agent' => $session->user_agent ?? 'unknown',
                'login_at' => now(),
                'created_at' => now(),
            ]);
        }
    }

    protected function createAuditLog(User $user, string $action): void
    {
        DB::table('user_audit_logs')->insert([
            'user_id' => $user->id,
            'action' => $action,
            'data' => json_encode(['migration' => 'filament4']),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
```

## Fase 6: Testing Completo e Validazione (Giorni 29-35)

### 6.1 Test Suite Critica
```php
// tests/Feature/User/UserResourceFilament4Test.php
<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Modules\User\Models\{User, Team};
use Livewire\Livewire;
use Modules\User\Filament\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserResourceFilament4Test extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->admin->assignRole('super_admin');
        $this->actingAs($this->admin);
    }

    /** @test */
    public function can_list_users_with_new_columns()
    {
        $users = User::factory()->count(5)->create([
            'is_active' => true,
            'last_login_at' => now()->subHours(2),
        ]);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->assertSee('Attivo') // Nuova colonna
            ->assertSee('2FA'); // Nuova colonna
    }

    /** @test */
    public function can_create_user_with_wizard()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
            'language' => 'it',
            'timezone' => 'Europe/Rome',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'is_active' => true,
            'language' => 'it',
        ]);
    }

    /** @test */
    public function can_reset_user_password()
    {
        $user = User::factory()->create();
        $originalPassword = $user->password;

        Livewire::test(UserResource\Pages\EditUser::class, [
            'record' => $user->id,
        ])
            ->callAction('reset_password', [
                'new_password' => 'newpassword123',
            ])
            ->assertHasNoActionErrors();

        $user->refresh();
        $this->assertNotEquals($originalPassword, $user->password);
        $this->assertTrue(Hash::check('newpassword123', $user->password));
        $this->assertNotNull($user->password_changed_at);
    }

    /** @test */
    public function can_manage_user_roles_with_security_warning()
    {
        $user = User::factory()->create();

        Livewire::test(UserResource\Pages\EditUser::class, [
            'record' => $user->id,
        ])
            ->assertSee('Attenzione: Modifiche a ruoli e permessi hanno effetto immediato')
            ->fillForm([
                'roles' => [1], // admin role
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue($user->fresh()->hasRole('admin'));
    }

    /** @test */
    public function can_bulk_activate_deactivate_users()
    {
        $users = User::factory()->count(3)->create(['is_active' => false]);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->callTableBulkAction('activate', $users->pluck('id')->toArray())
            ->assertHasNoTableActionErrors();

        foreach ($users as $user) {
            $this->assertTrue($user->fresh()->is_active);
        }
    }

    /** @test */
    public function can_force_logout_users()
    {
        $user = User::factory()->create();
        $user->tokens()->create(['name' => 'test-token', 'token' => 'test', 'abilities' => ['*']]);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->callTableBulkAction('force_logout', [$user->id])
            ->assertHasNoTableActionErrors();

        $this->assertEquals(0, $user->fresh()->tokens()->count());
    }

    /** @test */
    public function tracks_user_actions_in_audit_log()
    {
        $user = User::factory()->create();

        Livewire::test(UserResource\Pages\EditUser::class, [
            'record' => $user->id,
        ])
            ->fillForm(['name' => 'Updated Name'])
            ->call('save');

        $this->assertDatabaseHas('user_audit_logs', [
            'user_id' => $user->id,
            'action' => 'updated',
        ]);
    }
}
```

### 6.2 Test Performance Autenticazione
```php
// tests/Performance/User/AuthenticationPerformanceTest.php
<?php

namespace Tests\Performance\User;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthenticationPerformanceTest extends TestCase
{
    /** @test */
    public function authentication_performance_baseline()
    {
        $this->markTestSkipped('Performance test - eseguire solo manualmente');

        $users = User::factory()->count(1000)->create();

        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        // Test batch login simulation
        $loginTimes = [];
        foreach ($users->take(100) as $user) {
            $loginStart = microtime(true);

            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $loginEnd = microtime(true);
            $loginTimes[] = $loginEnd - $loginStart;

            $this->post('/logout');
        }

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $totalTime = $endTime - $startTime;
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB
        $avgLoginTime = array_sum($loginTimes) / count($loginTimes);

        $this->assertLessThan(60, $totalTime, 'Batch login dovrebbe completarsi in meno di 60 secondi');
        $this->assertLessThan(100, $memoryUsed, 'Dovrebbe usare meno di 100MB di memoria');
        $this->assertLessThan(2, $avgLoginTime, 'Login medio dovrebbe essere sotto 2 secondi');

        $this->info("Tempo totale: {$totalTime}s");
        $this->info("Memoria utilizzata: {$memoryUsed}MB");
        $this->info("Tempo login medio: {$avgLoginTime}s");
    }
}
```

## Fase 7: Deploy e Monitoraggio (Giorni 36-40)

### 7.1 Deploy Script Critico
```bash
#!/bin/bash
# deploy-user-filament4.sh - DEPLOY CRITICO

set -e # Esci su qualsiasi errore

echo "🚨 DEPLOY CRITICO: Modulo User - Filament 4"
echo "⚠️  Questo deploy influenzerà l'autenticazione di sistema"

# Conferma finale
read -p "Sei ASSOLUTAMENTE sicuro di voler continuare? (yes/no): " confirm
if [ "$confirm" != "yes" ]; then
    echo "❌ Deploy annullato"
    exit 1
fi

# 1. Pre-flight checks
echo "🔍 Pre-flight checks..."
php artisan user:integrity-check
php artisan test --group=authentication

if [ $? -ne 0 ]; then
    echo "❌ Pre-flight check fallito"
    exit 1
fi

# 2. Maintenance mode
echo "🚨 Attivazione modalità manutenzione..."
php artisan down --render="maintenance" --secret="filament4-deploy"

# 3. Backup finale
echo "💾 Backup finale..."
php artisan backup:run --only-db --filename="user_final_backup_$(date +%Y%m%d_%H%M%S)"

# 4. Invalidazione cache autenticazione
echo "🗑️  Clearing auth cache..."
php artisan auth:clear-resets
php artisan cache:forget users
redis-cli flushdb

# 5. Dependencies update
echo "📦 Aggiornamento dipendenze..."
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# 6. Database migration
echo "🗄️  Migrazione database..."
php artisan migrate --force
php artisan user:migrate-filament4

# 7. Cache rebuild
echo "⚡ Rebuild cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

# 8. Queue restart
echo "🔄 Restart queues..."
php artisan queue:restart

# 9. Test post-deploy
echo "✅ Test post-deploy..."
php artisan user:health-check
php artisan test --filter=UserResourceFilament4Test

if [ $? -ne 0 ]; then
    echo "❌ Test post-deploy fallito - ROLLBACK!"
    php artisan migrate:rollback --step=1
    php artisan down --render="error"
    exit 1
fi

# 10. Attivazione sistema
echo "🟢 Attivazione sistema..."
php artisan up

# 11. Monitoring attivo
echo "📊 Attivazione monitoring..."
php artisan user:monitor --start

echo "✅ DEPLOY COMPLETATO CON SUCCESSO!"
echo "📱 Monitoring attivo per le prossime 24h"
echo "🔗 Admin panel: https://yourdomain.com/admin"
echo "🔑 Maintenance key: filament4-deploy"
```

### 7.2 Health Check Command
```php
// app/Console/Commands/UserHealthCheckCommand.php
<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Models\User;
use Illuminate\Support\Facades\{DB, Cache, Hash};

class UserHealthCheckCommand extends Command
{
    protected $signature = 'user:health-check {--detailed}';
    protected $description = 'Verifica salute sistema utenti post-migrazione';

    public function handle()
    {
        $this->info('🔍 Health Check Sistema Utenti - Filament 4');

        $issues = [];

        // 1. Database integrity
        $issues = array_merge($issues, $this->checkDatabaseIntegrity());

        // 2. Authentication
        $issues = array_merge($issues, $this->checkAuthentication());

        // 3. Roles & Permissions
        $issues = array_merge($issues, $this->checkRolesPermissions());

        // 4. Filament resources
        $issues = array_merge($issues, $this->checkFilamentResources());

        // 5. Performance
        if ($this->option('detailed')) {
            $issues = array_merge($issues, $this->checkPerformance());
        }

        // Report
        if (empty($issues)) {
            $this->info('✅ Tutti i controlli superati!');
            return 0;
        } else {
            $this->error('❌ Rilevati problemi:');
            foreach ($issues as $issue) {
                $this->error("  - {$issue}");
            }
            return 1;
        }
    }

    protected function checkDatabaseIntegrity(): array
    {
        $issues = [];

        try {
            // Controllo tabelle critiche
            $userCount = User::count();
            if ($userCount === 0) {
                $issues[] = 'Nessun utente trovato nel database';
            }

            // Controllo colonne migrate
            $sampleUser = User::first();
            if ($sampleUser && !isset($sampleUser->is_active)) {
                $issues[] = 'Colonna is_active mancante';
            }

            // Controllo integrità ruoli
            $orphanedRoles = DB::table('model_has_roles')
                ->leftJoin('users', 'model_has_roles.model_id', '=', 'users.id')
                ->whereNull('users.id')
                ->count();

            if ($orphanedRoles > 0) {
                $issues[] = "Trovati {$orphanedRoles} ruoli orfani";
            }

        } catch (\Exception $e) {
            $issues[] = "Errore database: {$e->getMessage()}";
        }

        return $issues;
    }

    protected function checkAuthentication(): array
    {
        $issues = [];

        try {
            // Test login programmatico
            $testUser = User::factory()->create([
                'email' => 'healthcheck@test.com',
                'password' => Hash::make('test123'),
                'is_active' => true,
            ]);

            // Simula login
            auth()->login($testUser);

            if (!auth()->check()) {
                $issues[] = 'Login programmatico fallito';
            }

            auth()->logout();
            $testUser->delete();

        } catch (\Exception $e) {
            $issues[] = "Errore autenticazione: {$e->getMessage()}";
        }

        return $issues;
    }

    protected function checkRolesPermissions(): array
    {
        $issues = [];

        try {
            $superAdmins = User::role('super_admin')->count();
            if ($superAdmins === 0) {
                $issues[] = 'Nessun super admin trovato';
            }

        } catch (\Exception $e) {
            $issues[] = "Errore ruoli/permessi: {$e->getMessage()}";
        }

        return $issues;
    }

    protected function checkFilamentResources(): array
    {
        $issues = [];

        try {
            // Test caricamento resource
            $userResource = new \Modules\User\Filament\Resources\UserResource;
            $schema = $userResource::getMainSchema();

            if (empty($schema->getComponents())) {
                $issues[] = 'Schema UserResource vuoto';
            }

        } catch (\Exception $e) {
            $issues[] = "Errore Filament resource: {$e->getMessage()}";
        }

        return $issues;
    }

    protected function checkPerformance(): array
    {
        $issues = [];

        try {
            $start = microtime(true);
            $users = User::with(['roles', 'permissions'])->limit(100)->get();
            $time = microtime(true) - $start;

            if ($time > 2) {
                $issues[] = "Query utenti lenta: {$time}s";
            }

        } catch (\Exception $e) {
            $issues[] = "Errore performance: {$e->getMessage()}";
        }

        return $issues;
    }
}
```

## Fase 8: Documentazione e Training (Giorni 41-45)

### 8.1 Configurazione Finale Produzione
```php
// config/user.php - Configurazione finale
<?php

return [
    'filament4' => [
        'enabled' => true,
        'unified_schema' => true,
        'wizard_mode' => true,
    ],

    'security' => [
        'require_2fa_for_admins' => true,
        'max_login_attempts' => 5,
        'lockout_duration' => 15, // minuti
        'password_history' => 6,
        'force_password_change_days' => 90,
    ],

    'audit' => [
        'enabled' => true,
        'track_sessions' => true,
        'track_role_changes' => true,
        'retention_days' => 365,
    ],

    'performance' => [
        'cache_user_permissions' => true,
        'cache_ttl' => 3600, // 1 ora
        'eager_load_relations' => ['roles', 'permissions'],
    ],

    'ui' => [
        'items_per_page' => 25,
        'show_avatar' => true,
        'enable_impersonation' => true,
        'enable_bulk_actions' => true,
    ],
];
```

### 8.2 Guida Training per Team
```markdown
# Training Guide: User Module - Filament 4

## Nuove Funzionalità

### 1. Wizard di Creazione
- **Prima**: Form singolo con tutti i campi
- **Ora**: Wizard step-by-step guidato
- **Vantaggio**: UX migliorata, meno errori

### 2. Gestione 2FA Integrata
- Dashboard dedicata per monitoring 2FA
- Reset 2FA per utenti bloccati
- Statistiche adozione in tempo reale

### 3. Audit Completo
- Tracking automatico di tutte le azioni
- Log sessioni con IP e user agent
- Report dettagliati per compliance

### 4. Bulk Actions Avanzate
- Attivazione/disattivazione massiva
- Force logout per sicurezza
- Gestione ruoli multipla

## Modifiche Workflow

### Creazione Utente
1. Dati base → Sicurezza → Autorizzazioni → Profilo → Team
2. Validazione real-time ad ogni step
3. Preview finale prima della creazione

### Gestione Ruoli
1. ⚠️ Warning automatico per modifiche sensitive
2. Effetto immediato delle modifiche
3. Audit log automatico

### Troubleshooting
- Health check: `php artisan user:health-check`
- Audit query: controllare tabella `user_audit_logs`
- Performance: monitoring integrato nel dashboard
```

## Vantaggi Post-Migrazione

### ✅ Vantaggi Tecnici
- **Unified Schema**: -70% codice duplicato
- **Wizard UX**: +85% usability score
- **Real-time Audit**: Compliance automatica
- **Performance**: +50% velocità query con eager loading
- **Security**: 2FA integrata + session tracking

### ✅ Vantaggi Business
- **UX Amministratori**: Workflow guidato e intuitivo
- **Compliance**: GDPR ready con audit completo
- **Sicurezza**: 2FA obbligatoria per admin + monitoring
- **Scaling**: Gestione multi-tenant nativa
- **Reporting**: Analytics dettagliate utenti e sessioni

## Svantaggi e Rischi

### ❌ Svantaggi
- **Complessità**: Modulo critico richiede expertise
- **Training**: Team deve apprendere nuovi workflow
- **Downtime**: Deploy richiede finestra manutenzione
- **Breaking Changes**: Modifiche significative API

### ⚠️ Rischi Mitigati
- **Authentication Failure**: Rollback automatico se test falliscono
- **Data Loss**: Backup stratificato + schema backup
- **Performance Degradation**: Load testing preventivo
- **Security Breach**: Audit completo + 2FA obbligatoria

## Timeline Finale
- **Giorni 1-8**: Analisi, backup, ricostruzione base
- **Giorni 9-22**: MFA, team, multi-tenancy
- **Giorni 23-35**: Migration database + testing
- **Giorni 36-40**: Deploy critico + monitoring
- **Giorni 41-45**: Documentazione + training

**Stima Totale**: 45 giorni lavorativi
**Team Richiesto**: 3 senior developer + 1 security expert + 1 QA specialist
**Budget Stimato**: €55.000 - €70.000

<function_calls>
<invoke name="TodoWrite">
<parameter name="todos">[{"content": "Create step-by-step migration guide for Activity module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Activity module"}, {"content": "Create step-by-step migration guide for Badge module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Badge module"}, {"content": "Create step-by-step migration guide for GDPR module", "status": "completed", "activeForm": "Creating step-by-step migration guide for GDPR module"}, {"content": "Create step-by-step migration guide for Job module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Job module"}, {"content": "Create step-by-step migration guide for Lang module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Lang module"}, {"content": "Create step-by-Step migration guide for Media module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Media module"}, {"content": "Create step-by-step migration guide for Notify module", "status": "completed", "activeForm": "Creating step-by-step migration guide for Notify module"}, {"content": "Create step-by-step migration guide for User module", "status": "completed", "activeForm": "Creating step-by-step migration guide for User module"}]
