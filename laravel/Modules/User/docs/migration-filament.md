<<<<<<< HEAD
# User Module - Migrazione a Filament 4

## Panoramica User Module
Il modulo User è **critico** per sicurezza, autenticazione e autorizzazione. La migrazione a Filament 4 deve essere gestita con **massima cautela** per non compromettere l'accesso al sistema.

## 🔄 Modifiche Richieste per la Migrazione

### 1. UserResource - Schema Unificato con Security Focus
**Problemi attuali**: LanguageEnum rimosso, test coverage perduti

**Filament 4 - Enhanced UserResource:**

```php
<?php

namespace Modules\User\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Schema\Schema;
use Filament\Schema\Components\TextInput;
use Filament\Schema\Components\Select;
use Filament\Schema\Components\FileUpload;
use Filament\Schema\Components\Toggle;
use Filament\Schema\Components\Section;
use Filament\Schema\Components\DateTimePicker;
use Filament\Schema\Components\ViewField;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Modules\User\Models\User;
use Modules\User\Enums\LanguageEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';

    public static function schema(): Schema
    {
        return Schema::make([
            Section::make('Personal Information')->schema([
                FileUpload::make('avatar')
                    ->image()
                    ->avatar()
                    ->directory('avatars')
                    ->imageEditor()
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->maxSize(2048),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $old) {
                        if ($state !== $old) {
                            $set('profile_updated', true);
                        }
                    }),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $record) {
                        if ($record && $state !== $record->email) {
                            $set('email_verified_at', null);
                            $set('requires_verification', true);
                        }
                    }),

                Select::make('language')
                    ->options([
                        'en' => '🇺🇸 English',
                        'it' => '🇮🇹 Italiano',
                        'es' => '🇪🇸 Español',
                        'fr' => '🇫🇷 Français',
                        'de' => '🇩🇪 Deutsch',
                    ])
                    ->default('en')
                    ->required(),

                Select::make('timezone')
                    ->options(collect(timezone_identifiers_list())->mapWithKeys(
                        fn($tz) => [$tz => $tz]
                    ))
                    ->default('UTC')
                    ->searchable(),
            ]),

            Section::make('Access Control')->schema([
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Auto-configure permissions based on roles
                        if (in_array('admin', $state ?? [])) {
                            $set('requires_mfa', true);
                        }
                    }),

                Select::make('teams')
                    ->relationship('teams', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                Toggle::make('is_active')
                    ->default(true)
                    ->live()
                    ->afterStateUpdated(function ($state, $record) {
                        if (!$state && $record) {
                            // Log user deactivation
                            activity()->performedOn($record)->log('User deactivated');
                        }
                    }),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->native(false)
                    ->disabled()
                    ->visibleOn(['view', 'edit']),
            ]),

            Section::make('Security Settings')->schema([
                Toggle::make('two_factor_enabled')
                    ->disabled()
                    ->label('Two-Factor Authentication')
                    ->helperText('Managed by user in their profile'),

                Toggle::make('requires_mfa')
                    ->label('Require MFA for Admin Access')
                    ->visible(fn($get) => collect($get('roles') ?? [])->intersect(['admin', 'super-admin'])->isNotEmpty()),

                TextInput::make('failed_login_attempts')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->visibleOn(['view', 'edit']),

                DateTimePicker::make('locked_until')
                    ->label('Account Locked Until')
                    ->native(false)
                    ->visibleOn(['view', 'edit']),
            ])->visibleOn(['view', 'edit']),

            Section::make('Activity Information')->schema([
                ViewField::make('login_activity')
                    ->view('user::login-activity')
                    ->viewData(fn($record) => [
                        'recent_logins' => $record?->authentications()->latest()->limit(10)->get(),
                        'devices' => $record?->devices()->latest()->limit(5)->get(),
                        'online_status' => $record?->isOnline(),
                    ])
                    ->columnSpanFull(),
            ])->visibleOn(['view', 'edit']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(fn($record) =>
                        'https://www.gravatar.com/avatar/' . md5($record->email) . '?d=mp'
                    ),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                BadgeColumn::make('roles')
                    ->formatStateUsing(function($record) {
                        return $record->roles->pluck('name')->join(', ');
                    })
                    ->colors([
                        'danger' => fn($state) => str_contains($state, 'super-admin'),
                        'warning' => fn($state) => str_contains($state, 'admin'),
                        'success' => fn($state) => str_contains($state, 'user'),
                    ])
                    ->limit(30),

                BadgeColumn::make('language')
                    ->formatStateUsing(fn($state) => match($state) {
                        'en' => '🇺🇸 EN',
                        'it' => '🇮🇹 IT',
                        'es' => '🇪🇸 ES',
                        'fr' => '🇫🇷 FR',
                        'de' => '🇩🇪 DE',
                        default => $state,
                    }),

                IconColumn::make('email_verified_at')
                    ->boolean()
                    ->label('Verified')
                    ->getStateUsing(fn($record) => !is_null($record->email_verified_at))
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),

                IconColumn::make('two_factor_enabled')
                    ->boolean()
                    ->label('2FA')
                    ->colors([
                        'success' => true,
                        'gray' => false,
                    ]),

                BadgeColumn::make('online_status')
                    ->label('Status')
                    ->getStateUsing(function($record) {
                        if ($record->isOnline()) {
                            return 'online';
                        } elseif ($record->last_login_at && $record->last_login_at->isAfter(now()->subDay())) {
                            return 'recent';
                        }
                        return 'offline';
                    })
                    ->colors([
                        'success' => 'online',
                        'warning' => 'recent',
                        'gray' => 'offline',
                    ])
                    ->icons([
                        'heroicon-o-bolt' => 'online',
                        'heroicon-o-clock' => 'recent',
                        'heroicon-o-minus' => 'offline',
                    ]),

                TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('Never'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->actions([
                Action::make('impersonate')
                    ->icon('heroicon-o-user-circle')
                    ->color('warning')
                    ->visible(fn() => auth()->user()->hasRole('super-admin'))
                    ->requiresConfirmation()
                    ->modalHeading('Impersonate User')
                    ->modalDescription('You will be logged in as this user. This action is logged.')
                    ->action(function($record) {
                        // Log impersonation
                        activity()
                            ->performedOn($record)
                            ->causedBy(auth()->user())
                            ->log('User impersonation started');

                        session(['impersonate' => $record->id]);
                        return redirect('/');
                    }),

                Action::make('send_verification')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->visible(fn($record) => is_null($record->email_verified_at))
                    ->action(function($record) {
                        $record->sendEmailVerificationNotification();

                        Notification::make()
                            ->title('Verification email sent')
                            ->success()
                            ->send();
                    }),

                Action::make('reset_2fa')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->visible(fn($record) => $record->two_factor_enabled)
                    ->requiresConfirmation()
                    ->modalHeading('Reset Two-Factor Authentication')
                    ->modalDescription('This will disable 2FA for this user. They will need to set it up again.')
                    ->action(function($record) {
                        app(TwoFactorService::class)->disable($record);

                        // Notify user
                        $record->notify(new TwoFactorResetNotification());

                        // Log action
                        activity()
                            ->performedOn($record)
                            ->causedBy(auth()->user())
                            ->log('Two-factor authentication reset');
                    }),

                Action::make('unlock_account')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->visible(fn($record) => $record->locked_until && $record->locked_until->isFuture())
                    ->action(function($record) {
                        $record->update([
                            'locked_until' => null,
                            'failed_login_attempts' => 0,
                        ]);
                    }),
            ])
            ->bulkActions([
                BulkAction::make('bulk_activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn($records) => $records->each->update(['is_active' => true])),

                BulkAction::make('bulk_deactivate')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn($records) => $records->each->update(['is_active' => false])),

                BulkAction::make('send_notification')
                    ->icon('heroicon-o-bell')
                    ->form([
                        TextInput::make('subject')
                            ->required(),
                        Textarea::make('message')
                            ->required(),
                    ])
                    ->action(function($data, $records) {
                        foreach($records as $user) {
                            $user->notify(new AdminNotification($data['subject'], $data['message']));
                        }
                    }),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple(),

                SelectFilter::make('teams')
                    ->relationship('teams', 'name')
                    ->multiple(),

                Filter::make('active_users')
                    ->query(fn($query) => $query->where('is_active', true))
                    ->label('Active Only'),

                Filter::make('verified_users')
                    ->query(fn($query) => $query->whereNotNull('email_verified_at'))
                    ->label('Verified Email'),

                Filter::make('2fa_enabled')
                    ->query(fn($query) => $query->where('two_factor_enabled', true))
                    ->label('2FA Enabled'),

                Filter::make('online_users')
                    ->query(fn($query) => $query->where('last_login_at', '>', now()->subMinutes(5)))
                    ->label('Online Now'),
            ]);
    }
}
```

### 2. Team Management con Nested Resources
**Filament 4 - Team/User relationship management:**
```php
// User -> Teams relationship
class UserTeamResource extends Resource
{
    protected static ?string $parentResource = UserResource::class;
    protected static string $relationship = 'teams';

    public static function schema(): Schema
    {
        return Schema::make([
            Select::make('team_id')
                ->relationship('team', 'name')
                ->required(),

            Select::make('role')
                ->options([
                    'owner' => 'Owner',
                    'admin' => 'Admin',
                    'member' => 'Member',
                    'viewer' => 'Viewer',
                ])
                ->required(),

            DateTimePicker::make('joined_at')
                ->default(now())
                ->native(false),
        ]);
    }

    // URL: /admin/users/123/teams
}

// Team -> Users relationship
class TeamUserResource extends Resource
{
    protected static ?string $parentResource = TeamResource::class;
    protected static string $relationship = 'users';

    // URL: /admin/teams/456/users
}
```

### 3. Enhanced Security Dashboard
**Filament 4 - Static Table Data per security monitoring:**
```php
class SecurityDashboardWidget extends Widget
{
    public function table(Table $table): Table
    {
        return $table
            ->records($this->getSecurityMetrics())
            ->columns([
                TextColumn::make('metric')
                    ->weight('semibold'),

                TextColumn::make('value')
                    ->numeric()
                    ->color(fn($record) => match($record['status']) {
                        'critical' => 'danger',
                        'warning' => 'warning',
                        'good' => 'success',
                        default => 'info',
                    }),

                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'critical',
                        'warning' => 'warning',
                        'success' => 'good',
                    ]),

                TextColumn::make('trend')
                    ->formatStateUsing(fn($state) => $state > 0 ? "+{$state}%" : "{$state}%")
                    ->color(fn($state) => $state > 0 ? 'danger' : 'success'),

                TextColumn::make('last_updated')
                    ->since(),
            ])
            ->actions([
                Action::make('investigate')
                    ->icon('heroicon-o-magnifying-glass')
                    ->visible(fn($record) => $record['status'] !== 'good')
                    ->action(function($record) {
                        // Navigate to relevant admin section
                        return redirect($this->getInvestigationUrl($record['metric']));
                    }),
            ])
            ->poll('30s');
    }

    private function getSecurityMetrics(): array
    {
        return [
            [
                'metric' => 'Failed Login Attempts (24h)',
                'value' => Authentication::where('success', false)
                    ->where('created_at', '>', now()->subDay())
                    ->count(),
                'status' => $this->getFailedLoginStatus(),
                'trend' => $this->getTrend('failed_logins'),
                'last_updated' => now(),
            ],
            [
                'metric' => 'Locked Accounts',
                'value' => User::whereNotNull('locked_until')
                    ->where('locked_until', '>', now())
                    ->count(),
                'status' => 'warning',
                'trend' => 0,
                'last_updated' => now(),
            ],
            [
                'metric' => 'Users Without 2FA',
                'value' => User::where('two_factor_enabled', false)
                    ->whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'super-admin']))
                    ->count(),
                'status' => 'critical',
                'trend' => -5,
                'last_updated' => now(),
            ],
            [
                'metric' => 'Suspicious Devices',
                'value' => Device::where('is_suspicious', true)->count(),
                'status' => 'warning',
                'trend' => +2,
                'last_updated' => now(),
            ],
        ];
    }
}
```

### 4. Advanced Permission Management
```php
class PermissionManagementWidget extends Widget
{
    protected static string $view = 'user::widgets.permission-matrix';

    public function getViewData(): array
    {
        return [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all()->groupBy('group'),
            'matrix' => $this->buildPermissionMatrix(),
        ];
    }

    private function buildPermissionMatrix(): array
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        $matrix = [];

        foreach ($permissions as $permission) {
            $matrix[$permission->name] = [];

            foreach ($roles as $role) {
                $matrix[$permission->name][$role->name] = $role->hasPermissionTo($permission);
            }
        }

        return $matrix;
    }
}
```

## 🚀 Vantaggi della Migrazione User Module

### 1. Enhanced Security Features
- **MFA built-in** per admin panels
- **Real-time security monitoring**
- **Advanced device tracking**
- **Suspicious activity detection**

### 2. Improved User Experience
```php
// Self-service account management
public function accountSettings(): Schema
{
    return Schema::make([
        Section::make('Profile Settings')->schema([
            // User can edit own profile
        ])->authorizeUsing('update', auth()->user()),

        Section::make('Security Settings')->schema([
            // 2FA setup, device management
        ])->authorizeUsing('manage-security', auth()->user()),
    ]);
}
```

### 3. Team Collaboration Features
- **Nested team management**
- **Role-based permissions**
- **Team invitation system**
- **Activity tracking per team**

### 4. Comprehensive Analytics
```php
// User behavior analytics
class UserAnalyticsService
{
    public function getEngagementMetrics(User $user): array
    {
        return [
            'login_frequency' => $this->getLoginFrequency($user),
            'feature_usage' => $this->getFeatureUsage($user),
            'team_participation' => $this->getTeamParticipation($user),
            'security_score' => $this->getSecurityScore($user),
        ];
    }
}
```

## ⚠️ Svantaggi e Rischi CRITICI

### 1. Authentication System Disruption
```bash
# RISCHIO MASSIMO: Breaking user authentication
⚠️  Session management changes
⚠️  Token validation modifications
⚠️  Permission system restructuring
⚠️  Potential lockout scenarios
```

### 2. Data Migration Complexity
```php
// Complex user data migration
⚠️  Role/permission mappings
⚠️  Team relationship restructuring
⚠️  Device fingerprint updates
⚠️  2FA secret migrations
```

### 3. Multi-tenancy Considerations
```php
// If application is multi-tenant:
⚠️  User isolation per tenant
⚠️  Cross-tenant role permissions
⚠️  Data segregation integrity
```

### 4. Performance Impact
```php
// Security monitoring overhead:
⚠️  Real-time permission checks
⚠️  Device tracking queries
⚠️  Activity logging volume
⚠️  Dashboard polling frequency
```

## 🎯 Piano di Migrazione User Module (CRITICAL PATH)

### Fase 0: Pre-Migration Security (3-4 giorni)
1. 🆘 **CRITICAL**: Complete backup di user/permission data
2. 🆘 **CRITICAL**: Test rollback procedures
3. 🆘 **CRITICAL**: Document current authentication flows
4. 🆘 **CRITICAL**: Prepare emergency access procedures

### Fase 1: Foundation Migration (4-5 giorni)
1. 🔧 Recreate LanguageEnum if needed
2. 🔧 Migrate UserResource to unified Schema
3. 🔧 Implement MFA requirements
4. 🔧 Setup device tracking system

### Fase 2: Advanced Features (3-4 giorni)
1. 🔄 Implement nested Team/User resources
2. 🔄 Create security monitoring dashboard
3. 🔄 Setup real-time permission checking
4. 🔄 Enhanced authentication flows

### Fase 3: Security Testing (4-5 giorni)
1. ✅ Comprehensive authentication testing
2. ✅ Permission system validation
3. ✅ Multi-device scenario testing
4. ✅ Security vulnerability assessment

### Fase 4: Recovery & Validation (2-3 giorni)
1. 🧪 Restore critical test coverage
2. 🧪 End-to-end user flow testing
3. 🧪 Performance testing under load
4. 🧪 Security audit validation

## 📋 Checklist User Module Migration (MANDATORY)

### Pre-Migration (CRITICAL)
- [ ] **✅ Complete user database backup**
- [ ] **✅ Document all authentication methods**
- [ ] **✅ Test emergency admin access**
- [ ] **✅ Identify all user-facing endpoints**
- [ ] **✅ Prepare rollback strategy**
- [ ] **✅ Stakeholder notification**

### During Migration
- [ ] **🔒 Monitor authentication failures**
- [ ] **📊 Track permission errors**
- [ ] **🚨 Real-time error monitoring**
- [ ] **⏰ Rollback timeline adherence**

### Post-Migration (MANDATORY)
- [ ] **✅ All authentication methods tested**
- [ ] **✅ Permission system validated**
- [ ] **✅ MFA functionality verified**
- [ ] **✅ Team management tested**
- [ ] **✅ Security monitoring active**
- [ ] **✅ Test coverage restored**

## 💡 Raccomandazioni per User Module

### ⚠️ EXTREME CAUTION REQUIRED

**Motivi per extreme caution:**
1. **Authentication disruption** risk troppo alto
2. **Permission system** changes can break everything
3. **User lockout** scenarios catastrophic
4. **Data loss** in user management irreversible

### ✅ Procedere SOLO CON:

1. **Dedicated maintenance window** di almeno 8h
2. **Full team on standby** durante migration
3. **Rollback plan** testato e verificato
4. **Emergency access** procedures ready
5. **Stakeholder approval** esplicito
6. **Test environment** identical replication

### 🔄 Alternative Approach:

**Progressive migration strategy:**
1. **Phase 1**: Migrate non-critical user features
2. **Phase 2**: Enhance security features gradually
3. **Phase 3**: Core authentication last
4. **Phase 4**: Advanced features only after validation

## 🕐 Timeline Stimato User Module

**EXTENDED TIMELINE per security:**
- **Pre-migration preparation**: 4-5 giorni
- **Core migration**: 6-8 giorni
- **Security testing**: 5-6 giorni
- **Recovery & validation**: 3-4 giorni
- **Monitoring & adjustment**: 2-3 giorni

**TOTALE: 20-26 giorni lavorativi**

## 🔮 Conclusioni User Module

**⚠️ MIGRATION AD ALTISSIMO RISCHIO ⚠️**

**Raccomandazione**: **POSTICIPARE** finché:
1. ✅ Altri moduli migrati con successo
2. ✅ Team ha esperienza completa con Filament 4
3. ✅ Rollback procedures tested multiple times
4. ✅ Extended maintenance window available
5. ✅ Emergency response team ready

**Strategic approach**:
- Mantenere User module su Filament 3 stabile
- Migrare TUTTI gli altri moduli prima
- Pianificare User migration come progetto dedicato
- **PRIORITÀ**: **System stability > New features**

**Final recommendation**: **ULTIMO MODULO DA MIGRARE** dopo aver perfezionato il processo su moduli meno critici.
=======
---
module: theme
topic: migration-filament
canonical: ../../../Themes/docs/shared-components/migrazione-filament-4.md
---

See canonical documentation: ../../../Themes/docs/shared-components/migrazione-filament-4.md
>>>>>>> 40b96bcd6 (.)
