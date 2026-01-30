# Configurazione Filament per il progetto

## Stato Attuale

Attualmente, la configurazione di Filament presenta incompatibilità con i moduli Laraxot integrati nel progetto. In particolare:

1. La classe `Filament\PanelProvider` non è presente nel sistema
2. Ci sono incompatibilità di versione tra i moduli e Filament 4.x
3. I pannelli amministrativi non sono ancora configurati per il multi-tenancy

## Piano di Implementazione

### 1. Aggiornamento di Filament alle Dipendenze Corrette

#### Passi Operativi:

1. **Aggiornare composer.json** con le dipendenze di Filament 4.x:

```json
{
    "require": {
        "filament/filament": "^3.1",
        "filament/forms": "^3.1",
        "filament/tables": "^3.1",
        "filament/notifications": "^3.1",
        "filament/panels": "^3.1",
        "filament/widgets": "^3.1",
        "filament/support": "^3.1",
        "filament/actions": "^3.1",
        "filament/infolists": "^3.1"
    }
}
```

2. **Aggiornare dipendenze correlate**:

```json
{
    "require": {
        "livewire/livewire": "^3.0",
        "blade-ui-kit/blade-icons": "^1.5",
        "ryangjchandler/blade-capture-directive": "^0.3"
    }
}
```

3. **Eseguire l'aggiornamento**:

```bash
composer update --with-dependencies
```

### 2. Creazione dei Provider di Pannello

#### Passi Operativi:

1. **Creare provider di pannello per amministrazione**:

```bash
php artisan make:filament-panel admin
```

2. **Creare provider di pannello per odontoiatri**:

```bash
php artisan make:filament-panel dentist
```

3. **Creare provider di pannello per pazienti**:

```bash
php artisan make:filament-panel patient
```

4. **Modificare i provider per supportare il multi-tenancy**:

```php
// App\Providers\Filament\AdminPanelProvider.php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Support\Facades\Blade;
use Modules\Tenant\Models\Tenant;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->tenant(Tenant::class)
            ->tenantRegistration(Pages\Tenants\RegisterTenant::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                'web',
            ])
            ->authMiddleware([
                'auth:web',
            ]);
    }
}
```

### 3. Configurazione delle Risorse Filament

#### Passi Operativi:

1. **Creare directory per le risorse**:

```bash
mkdir -p app/Filament/Admin/Resources
mkdir -p app/Filament/Dentist/Resources
mkdir -p app/Filament/Patient/Resources
```

2. **Creare risorsa per i pazienti**:

```bash
php artisan make:filament-resource Patient --generate --panel=admin
```

3. **Personalizzare la risorsa paziente**:

```php
// App\Filament\Admin\Resources\PatientResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PatientResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Patient\Models\Patient;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Gestione Pazienti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Personali')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Cognome')
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data di Nascita')
                            ->required(),
                        Forms\Components\TextInput::make('fiscal_code')
                            ->label('Codice Fiscale')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefono')
                            ->tel(),
                    ]),

                Forms\Components\Section::make('Dati ISEE')
                    ->schema([
                        Forms\Components\TextInput::make('isee_value')
                            ->label('Valore ISEE')
                            ->numeric()
                            ->required(),
                        Forms\Components\DatePicker::make('isee_expiry')
                            ->label('Scadenza ISEE')
                            ->required(),
                        Forms\Components\FileUpload::make('isee_document')
                            ->label('Documento ISEE')
                            ->directory('isee')
                            ->acceptedFileTypes(['application/pdf']),
                    ]),

                Forms\Components\Section::make('Gravidanza')
                    ->schema([
                        Forms\Components\DatePicker::make('pregnancy_date')
                            ->label('Data presunta parto')
                            ->required(),
                        Forms\Components\FileUpload::make('pregnancy_document')
                            ->label('Certificato di gravidanza')
                            ->directory('pregnancy')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png']),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Cognome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fiscal_code')
                    ->label('Codice Fiscale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('isee_value')
                    ->label('ISEE')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pregnancy_date')
                    ->label('Data presunta parto')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('eligible')
                    ->label('Eleggibili')
                    ->query(fn ($query) => $query->where('isee_value', '<=', 20000)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
```

### 4. Configurazione dell'Autenticazione Multi-Tenant

#### Passi Operativi:

1. **Modificare il modello User per supportare tenant**:

```php
// Modules\User\Models\User.php

namespace Modules\User\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Tenant\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;

    // ... existing code ...

    /**
     * Relationships with tenant
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'tenant_user');
    }

    /**
     * Check if user can access Filament panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Admin can access all panels
        if ($this->hasRole('admin')) {
            return true;
        }

        // Dentist can access dentist panel
        if ($panel->getId() === 'dentist' && $this->hasRole('dentist')) {
            return true;
        }

        // Patient can access patient panel
        if ($panel->getId() === 'patient' && $this->hasRole('patient')) {
            return true;
        }

        return false;
    }
}
```

2. **Creare le migrazioni per la tabella pivot tenant_user**:

```php
// database/migrations/YYYY_MM_DD_create_tenant_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['tenant_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_user');
    }
};
```

### 5. Personalizzazione dei Pannelli

#### Passi Operativi:

1. **Personalizzare il pannello amministrativo**:

```php
// config/filament-panels.php

return [
    'admin' => [
        'theme' => [
            'colors' => [
                'primary' => [
                    500 => '232, 121, 1',
                ],
            ],
        ],
        'brand' => [
            'name' => 'il progetto Admin',
            'logo' => resource_path('images/logo.svg'),
        ],
        'favicon' => resource_path('images/favicon.ico'),
        'max_content_width' => 'full',
    ],
    'dentist' => [
        'theme' => [
            'colors' => [
                'primary' => [
                    500 => '59, 130, 246',
                ],
            ],
        ],
        'brand' => [
            'name' => 'il progetto Dentista',
            'logo' => resource_path('images/logo-dentist.svg'),
        ],
        'favicon' => resource_path('images/favicon.ico'),
        'max_content_width' => 'full',
    ],
    'patient' => [
        'theme' => [
            'colors' => [
                'primary' => [
                    500 => '16, 185, 129',
                ],
            ],
        ],
        'brand' => [
            'name' => 'il progetto Paziente',
            'logo' => resource_path('images/logo-patient.svg'),
        ],
        'favicon' => resource_path('images/favicon.ico'),
        'max_content_width' => '7xl',
    ],
];
```

2. **Creare middleware per gestire il tenant attivo**:

```php
// app/Http/Middleware/SetTenantForFilament.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Tenant\Services\TenantManager;

class SetTenantForFilament
{
    public function __construct(protected TenantManager $tenantManager)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // If user belongs to only one tenant, set it as current
            if ($user->tenants()->count() === 1) {
                $tenant = $user->tenants()->first();
                $this->tenantManager->setCurrentTenant($tenant);
            }
        }

        return $next($request);
    }
}
```

3. **Registrare il middleware**:

```php
// app/Http/Kernel.php

protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\SetTenantForFilament::class,
    ],
];
```

### 6. Integrazione con GDPR

#### Passi Operativi:

1. **Creare pagina per la gestione dei consensi**:

```php
// app/Filament/Patient/Pages/ManageConsents.php

namespace App\Filament\Patient\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Modules\Gdpr\Models\Consent;

class ManageConsents extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'I miei consensi';
    protected static ?string $navigationGroup = 'Privacy';
    protected static ?string $title = 'Gestione Consensi';
    protected static string $view = 'filament.patient.pages.manage-consents';

    public function getViewData(): array
    {
        return [
            'consents' => Consent::where('user_id', auth()->id())->get(),
        ];
    }
}
```

2. **Creare vista per la pagina dei consensi**:

```blade
<!-- resources/views/filament/patient/pages/manage-consents.blade.php -->
<x-filament-panels::page>
    <x-filament::section>
        <h2 class="text-xl font-bold mb-4">I Miei Consensi GDPR</h2>
        
        <div class="space-y-4">
            @foreach($consents as $consent)
                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-medium">{{ $consent->title }}</h3>
                            <p class="text-sm text-gray-500">Data: {{ $consent->created_at->format('d/m/Y') }}</p>
                            <div class="mt-2">{{ $consent->description }}</div>
                        </div>
                        <div class="ml-4">
                            @if($consent->accepted)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Accettato
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Non accettato
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('gdpr.download-consent', $consent) }}" class="text-primary-600 hover:text-primary-800 text-sm">
                            Scarica documento
                        </a>
                    </div>
                </div>
            @endforeach
            
            @if($consents->isEmpty())
                <div class="p-4 bg-white rounded-lg shadow text-center">
                    <p>Non hai ancora fornito alcun consenso.</p>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-panels::page>
```

### 7. Pubblicazione e Testing

#### Passi Operativi:

1. **Pubblicare gli asset di Filament**:

```bash
php artisan filament:assets
```

2. **Aggiornare configurazioni di cache**:

```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

3. **Testare l'accesso ai pannelli**:

```bash
php artisan serve
```

E accedere a:
- http://localhost:8000/admin
- http://localhost:8000/dentist
- http://localhost:8000/patient

## Checklist di Implementazione

- [ ] Aggiornamento di Filament alle dipendenze corrette
- [ ] Creazione dei provider di pannello
- [ ] Configurazione delle risorse Filament
- [ ] Configurazione dell'autenticazione multi-tenant
- [ ] Personalizzazione dei pannelli
- [ ] Integrazione con GDPR
- [ ] Pubblicazione e testing

## Risultato Atteso

Dopo la completa implementazione di queste configurazioni, avremo:

1. Un sistema Filament 4.x funzionante con supporto multi-tenant
2. Tre pannelli distinti per amministrazione, odontoiatri e pazienti
3. Interfacce utente intuitive per la gestione dei dati
4. Conformità GDPR integrata nelle interfacce utente
5. Una base solida per lo sviluppo delle funzionalità specifiche di il progetto 