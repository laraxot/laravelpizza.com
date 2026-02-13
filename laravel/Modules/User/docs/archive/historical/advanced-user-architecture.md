# Architettura Utente Avanzata basata sui Principi Filament

## Introduzione

Basandoci sui principi architetturali osservati nel pacchetto `filament-spatie-laravel-database-mail-templates`, questo documento illustra come applicare questi concetti al modulo User per creare un sistema di gestione utenti più avanzato e user-friendly.

## Sistema di Template per Comunicazioni Utente

### Template di Email Predefiniti

Come nel pacchetto studiato, possiamo implementare un sistema avanzato per i template di email degli utenti:

```php
<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class UserMailTemplate extends SpatieMailTemplate
{
    use HasSlug, HasTranslations;

    protected $fillable = [
        'mailable',
        'name',
        'slug',
        'subject',
        'html_template',
        'text_template',
        'type', // welcome, password_reset, verification, etc.
        'is_active',
        'variables',
    ];

    public array $translatable = [
        'subject',
        'html_template',
        'text_template',
        'name',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['type', 'name'])
            ->saveSlugsTo('slug');
    }

    public function scopeForType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Template predefiniti
    public const TEMPLATE_TYPES = [
        'welcome' => 'Benvenuto',
        'password_reset' => 'Reset Password',
        'email_verification' => 'Verifica Email',
        'account_activation' => 'Attivazione Account',
        'account_deactivation' => 'Disattivazione Account',
        'subscription_renewal' => 'Rinnovo Abbonamento',
        'subscription_expiration' => 'Scadenza Abbonamento',
    ];
}
```

### Risorse Filament per Template Utente

```php
<?php

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\User\Models\UserMailTemplate;

class UserMailTemplateResource extends Resource
{
    protected static ?string $model = UserMailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->options(UserMailTemplate::TEMPLATE_TYPES)
                    ->required(),

                TextInput::make('subject')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('html_template')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('text_template')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->required(),
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
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'welcome' => 'success',
                        'password_reset' => 'warning',
                        'email_verification' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(UserMailTemplate::TEMPLATE_TYPES),

                Tables\Filters\TernaryFilter::make('is_active'),
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
}
```

## Sistema di Profilo Utente Avanzato

### Modello Profilo Estendibile

```php
<?php

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Xot\Models\XotBaseModel;
use Spatie\Permission\Traits\HasRoles;

class Profile extends Authenticatable
{
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'bio',
        'avatar',
        'timezone',
        'locale',
        'email_verified_at',
        'last_login_at',
        'status',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'settings' => 'array',
            'password' => 'hashed',
        ];
    }

    public function profileData(): HasOne
    {
        return $this->hasOne(ProfileData::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }
}
```

### Componenti UI Specializzati per Utenti

Come nel pacchetto studiato, possiamo creare componenti specializzati:

```php
<?php

namespace Modules\User\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class UserProfileEditor extends Field
{
    protected string $view = 'user::filament.components.user-profile-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public static function make(string $name = 'user-profile-editor'): static
    {
        return parent::make($name)
            ->view('user::filament.components.user-profile-editor');
    }
}
```

## Sistema di Impostazioni Utente

### Modello per Impostazioni

```php
<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'key',
        'value',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
            'is_public' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }

    public function scopeForCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForKey($query, string $key)
    {
        return $query->where('key', $key);
    }
}
```

## Plugin Filament per il Modulo Utente

### Architettura del Plugin

```php
<?php

namespace Modules\User\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\RoleResource;
use Modules\User\Filament\Resources\PermissionResource;
use Modules\User\Filament\Resources\UserMailTemplateResource;

class UserPlugin implements Plugin
{
    public function getId(): string
    {
        return 'user';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
            RoleResource::class,
            PermissionResource::class,
            UserMailTemplateResource::class,
        ]);

        // Altri componenti del modulo User
        $panel->pages([
            // Pagine personalizzate per il modulo User
        ]);

        $panel->widgets([
            // Widget per il modulo User
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Logica di inizializzazione specifica per il modulo User
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
```

## Servizi Avanzati per la Gestione Utenti

### Servizio di Gestione Profili

```php
<?php

namespace Modules\User\Services;

use Modules\User\Models\Profile;
use Modules\User\Models\UserSetting;
use Illuminate\Support\Arr;

class UserProfileService
{
    public function updateProfile(Profile $user, array $data): Profile
    {
        $user->update(Arr::except($data, ['settings']));

        if (isset($data['settings']) && is_array($data['settings'])) {
            $this->updateUserSettings($user, $data['settings']);
        }

        return $user;
    }

    public function updateUserSettings(Profile $user, array $settings): void
    {
        foreach ($settings as $category => $categorySettings) {
            foreach ($categorySettings as $key => $value) {
                UserSetting::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'category' => $category,
                        'key' => $key,
                    ],
                    [
                        'value' => $value,
                        'is_public' => false,
                    ]
                );
            }
        }
    }

    public function getUserSettings(Profile $user, string $category = null): array
    {
        $query = UserSetting::where('user_id', $user->id);

        if ($category) {
            $query->where('category', $category);
        }

        $settings = [];
        foreach ($query->get() as $setting) {
            Arr::set($settings, $setting->category . '.' . $setting->key, $setting->value);
        }

        return $settings;
    }
}
```

## Conclusione

Applicando i principi architetturali osservati nel pacchetto `filament-spatie-laravel-database-mail-templates` al modulo User, possiamo ottenere:

1. **Sistema di template email avanzato** con gestione centralizzata
2. **UI specializzata** per la gestione degli utenti
3. **Architettura modulare** basata sul pattern plugin
4. **Componenti riutilizzabili** per diverse funzionalità
5. **Gestione avanzata dei profili** con impostazioni personalizzate
6. **Esperienza utente coerente** grazie all'uso di componenti standardizzati
