# User Module - Ottimizzazioni e Correzioni

## Panoramica
Il modulo User è fondamentale per autenticazione, autorizzazione e gestione utenti. Dall'analisi del git status emergono modifiche significative che richiedono attenzione immediata.

## 🚨 Problemi Critici dal Git Status

### 1. Enum LanguageEnum Rimosso
**Modifica rilevata:**
```
D Modules/User/app/Enums/Enums/LanguageEnum.php
```

**Impatto critico:** Se utilizzato per localizzazione utente, può causare errori runtime.

**Correzione immediata:**
```php
// Ricreare LanguageEnum se necessario
enum LanguageEnum: string
{
    case ENGLISH = 'en';
    case ITALIAN = 'it';
    case SPANISH = 'es';
    case FRENCH = 'fr';
    case GERMAN = 'de';

    public function getLabel(): string
    {
        return match($this) {
            self::ENGLISH => 'English',
            self::ITALIAN => 'Italiano',
            self::SPANISH => 'Español',
            self::FRENCH => 'Français',
            self::GERMAN => 'Deutsch',
        };
    }

    public function getFlag(): string
    {
        return match($this) {
            self::ENGLISH => '🇺🇸',
            self::ITALIAN => '🇮🇹',
            self::SPANISH => '🇪🇸',
            self::FRENCH => '🇫🇷',
            self::GERMAN => '🇩🇪',
        };
    }
}
```

### 2. Test Files Rimossi
**File test rimossi:**
- `TeamManagementBusinessLogicTest.php`
- `UserManagementBusinessLogicTest.php`
- Multipli unit test per models (Device, Permission, Profile, Role, Team, Tenant, User)

**Impatto:** Loss critica di test coverage per autenticazione e autorizzazione.

**Priorità massima:** Ripristinare test coverage.

## 🔧 Ottimizzazioni Tecniche

### 1. Enhanced User Model
```php
class User extends Authenticatable implements FilamentUser, ProfileContract
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles, HasPermissions; // Spatie permissions
    use HasTeams, HasProfile; // Custom traits

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'language',
        'timezone',
        'avatar',
        'is_active',
        'last_login_at',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'preferences' => 'array',
            'language' => LanguageEnum::class,
        ];
    }

    // Filament Admin Access
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['admin', 'super-admin']);
    }

    // Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function authentications(): HasMany
    {
        return $this->hasMany(Authentication::class);
    }

    public function socialiteUsers(): HasMany
    {
        return $this->hasMany(SocialiteUser::class);
    }

    // Methods
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }

        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mp';
    }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function isOnline(): bool
    {
        return $this->last_login_at && $this->last_login_at->isAfter(now()->subMinutes(5));
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeWithLanguage($query, LanguageEnum $language)
    {
        return $query->where('language', $language->value);
    }
}
```

### 2. Team Management System
```php
class Team extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'owner_id',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    // Relations
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_users')
                    ->withPivot(['role', 'joined_at', 'invited_by'])
                    ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    // Methods
    public function addUser(User $user, string $role = 'member', ?User $invitedBy = null): void
    {
        $this->users()->attach($user->id, [
            'role' => $role,
            'joined_at' => now(),
            'invited_by' => $invitedBy?->id,
        ]);

        event(new UserJoinedTeam($user, $this, $role));
    }

    public function removeUser(User $user): void
    {
        $this->users()->detach($user->id);

        event(new UserLeftTeam($user, $this));
    }

    public function updateUserRole(User $user, string $role): void
    {
        $this->users()->updateExistingPivot($user->id, ['role' => $role]);
    }

    public function hasUser(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }
}
```

### 3. Advanced Authentication System
```php
class AuthenticationService
{
    public function __construct(
        private UserRepository $userRepository,
        private DeviceRepository $deviceRepository,
        private SecurityService $securityService
    ) {}

    public function authenticate(LoginRequest $request): AuthenticationResult
    {
        $user = $this->userRepository->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->logFailedAttempt($request);
            throw new InvalidCredentialsException();
        }

        if (!$user->is_active) {
            throw new AccountDeactivatedException();
        }

        // Two-factor authentication check
        if ($user->hasTwoFactorEnabled() && !$this->verifyTwoFactor($user, $request)) {
            return new AuthenticationResult(
                success: false,
                requires_2fa: true,
                user: $user
            );
        }

        // Device management
        $device = $this->handleDeviceLogin($user, $request);

        // Create session/token
        $token = $user->createToken($device->name)->plainTextToken;

        // Update login timestamp
        $user->updateLastLogin();

        // Log successful login
        $this->logSuccessfulLogin($user, $device, $request);

        return new AuthenticationResult(
            success: true,
            token: $token,
            user: $user,
            device: $device
        );
    }

    private function handleDeviceLogin(User $user, LoginRequest $request): Device
    {
        $deviceInfo = $this->securityService->getDeviceInfo($request);

        $device = $user->devices()->firstOrCreate([
            'fingerprint' => $deviceInfo['fingerprint'],
        ], [
            'name' => $deviceInfo['name'],
            'type' => $deviceInfo['type'],
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'is_trusted' => false,
        ]);

        $device->update([
            'last_used_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        return $device;
    }

    public function logout(User $user, ?Device $device = null): void
    {
        if ($device) {
            $user->tokens()->where('name', $device->name)->delete();
        } else {
            $user->tokens()->delete();
        }

        event(new UserLoggedOut($user, $device));
    }
}
```

### 4. Role & Permission System Enhancement
```php
class RoleService
{
    public function createRole(string $name, array $permissions = []): Role
    {
        $role = Role::create(['name' => $name]);

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function assignRole(User $user, string|Role $role): void
    {
        $user->assignRole($role);

        // Clear user permissions cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        event(new RoleAssigned($user, $role));
    }

    public function getUserPermissions(User $user): Collection
    {
        return $user->getAllPermissions()->map(function ($permission) {
            return [
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'via_role' => $permission->pivot?->role_id ? true : false,
            ];
        });
    }

    public function canUser(User $user, string $permission): bool
    {
        return $user->can($permission);
    }
}
```

## 🔐 Security Enhancements

### 1. Two-Factor Authentication
```php
class TwoFactorService
{
    public function enable(User $user): array
    {
        $secret = $this->generateSecret();
        $qrCodeUrl = $this->generateQrCode($user, $secret);

        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_enabled' => false, // Enable after verification
        ]);

        return [
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
            'backup_codes' => $this->generateBackupCodes($user),
        ];
    }

    public function verify(User $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);

        if ($this->verifyCode($secret, $code)) {
            $user->update(['two_factor_enabled' => true]);
            return true;
        }

        return false;
    }

    public function disable(User $user): void
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_backup_codes' => null,
        ]);
    }
}
```

### 2. Device Security
```php
class DeviceSecurity
{
    public function trustDevice(Device $device): void
    {
        $device->update(['is_trusted' => true]);

        event(new DeviceTrusted($device));
    }

    public function flagSuspiciousDevice(Device $device, string $reason): void
    {
        $device->update([
            'is_suspicious' => true,
            'suspicious_reason' => $reason,
        ]);

        // Notify user
        $device->user->notify(new SuspiciousDeviceNotification($device));

        // Log security event
        event(new SuspiciousDeviceDetected($device, $reason));
    }

    public function getDeviceRiskScore(Device $device): int
    {
        $score = 0;

        // New device
        if ($device->created_at->isAfter(now()->subDays(7))) {
            $score += 30;
        }

        // Multiple IP addresses
        $ipCount = Authentication::where('device_id', $device->id)
            ->distinct('ip_address')
            ->count();
        if ($ipCount > 5) {
            $score += 20;
        }

        // Failed login attempts
        $failedAttempts = Authentication::where('device_id', $device->id)
            ->where('success', false)
            ->where('created_at', '>', now()->subHours(24))
            ->count();
        $score += min($failedAttempts * 10, 50);

        return min($score, 100);
    }
}
```

## 📊 User Management Dashboard

### 1. Enhanced Filament Resources
```php
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('User Information')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('language')
                    ->options(LanguageEnum::class)
                    ->default(LanguageEnum::ENGLISH),

                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->avatar()
                    ->directory('avatars'),
            ]),

            Section::make('Access Control')->schema([
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                Forms\Components\Select::make('teams')
                    ->relationship('teams', 'name')
                    ->multiple()
                    ->preload(),

                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]),

            Section::make('Security')->schema([
                Forms\Components\Toggle::make('two_factor_enabled')
                    ->disabled()
                    ->label('2FA Enabled'),

                Forms\Components\TextInput::make('last_login_at')
                    ->disabled()
                    ->label('Last Login'),
            ])->hiddenOn('create'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('roles.name')
                    ->label('Roles'),

                Tables\Columns\BadgeColumn::make('language')
                    ->getStateUsing(fn($record) => $record->language?->getFlag() . ' ' . $record->language?->getLabel()),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_online')
                    ->getStateUsing(fn($record) => $record->isOnline())
                    ->boolean()
                    ->colors([
                        'success' => true,
                        'gray' => false,
                    ]),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('impersonate')
                    ->icon('heroicon-o-user-circle')
                    ->color('warning')
                    ->visible(fn() => auth()->user()->hasRole('super-admin'))
                    ->action(function ($record) {
                        session(['impersonate' => $record->id]);
                        return redirect('/');
                    }),

                Tables\Actions\Action::make('reset_2fa')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->visible(fn($record) => $record->two_factor_enabled)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        app(TwoFactorService::class)->disable($record);
                    }),

                Tables\Actions\EditAction::make(),
            ]);
    }
}
```

## 🧪 Test Recovery Strategy

### 1. Essential User Tests
```php
class UserManagementTest extends TestCase
{
    test('can create user with proper validation')
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'language' => LanguageEnum::ENGLISH->value,
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    test('can assign roles to user')
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role']);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole('test-role'));
    }

    test('two factor authentication works')
    {
        $user = User::factory()->create();
        $service = app(TwoFactorService::class);

        $setup = $service->enable($user);

        $this->assertArrayHasKey('secret', $setup);
        $this->assertArrayHasKey('qr_code_url', $setup);
        $this->assertFalse($user->fresh()->two_factor_enabled);
    }
}
```

## 🎯 Priorità di Implementazione

### 🔴 Critica (Immediata)
1. ✅ Verificare se LanguageEnum è necessario - ricreare se rimosso per errore
2. ✅ Ripristinare test coverage per User/Team management
3. ✅ Audit sicurezza autenticazione

### 🟡 Alta (Entro 1 settimana)
1. Enhanced authentication system
2. Two-factor authentication
3. Device security management
4. Team management improvements

### 🟢 Media (Entro 2 settimane)
1. Advanced role management
2. User analytics dashboard
3. Security monitoring
4. Social authentication

### 🔵 Bassa (Future)
1. Advanced user preferences
2. User activity analytics
3. Advanced team permissions
4. OAuth provider management

## 💡 Conclusioni

Il modulo User è il fondamento di sicurezza dell'applicazione. I file test rimossi rappresentano un rischio significativo che deve essere affrontato immediatamente. La rimozione di LanguageEnum potrebbe indicare refactoring in corso che richiede verifica e possibile ripristino.

**Priorità assoluta:** Ripristinare test coverage e verificare integrità delle funzionalità di autenticazione/autorizzazione.
