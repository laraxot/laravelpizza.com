# Best Practices - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTE le best practices del progetto
> 
> **🔗 Riferimenti**: [coding-standards.md](coding-standards.md) | [phpstan-consolidated.md](phpstan-consolidated.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file di best practices, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **40+ file di best practices duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `best-practices.md` in qualsiasi modulo
- `guidelines.md` duplicati
- `standards.md` sparsi
- Qualsiasi documentazione best practices specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/best-practices-consolidated.md`
- **Implementazione**: Codice nei singoli moduli (solo implementazione, non docs)

## Principi Fondamentali

### DRY (Don't Repeat Yourself)
- Evitare duplicazione di codice
- Centralizzare logica comune
- Utilizzare trait e classi base
- Creare componenti riutilizzabili

### KISS (Keep It Simple, Stupid)
- Codice semplice e leggibile
- Evitare over-engineering
- Preferire soluzioni dirette
- Documentare decisioni complesse

### SOLID Principles
- **S**: Single Responsibility Principle
- **O**: Open/Closed Principle
- **L**: Liskov Substitution Principle
- **I**: Interface Segregation Principle
- **D**: Dependency Inversion Principle

## Struttura dei File

### Dichiarazione Strict Types
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Path;

// Resto del codice...
```

### Namespace Corretto
```php
// ✅ CORRETTO
namespace Modules\ModuleName\Models;
namespace Modules\ModuleName\Actions;
namespace Modules\ModuleName\Filament\Resources;

// ❌ ERRATO
namespace Modules\ModuleName\App\Models;
namespace App\Modules\ModuleName;
```

### Ereditarietà
```php
// ✅ CORRETTO - Estendere sempre le classi base
class ExampleResource extends XotBaseResource
class ExampleServiceProvider extends XotBaseServiceProvider
class ExampleModel extends BaseModel

// ❌ ERRATO - Mai estendere direttamente
class ExampleResource extends Resource
class ExampleServiceProvider extends ServiceProvider
class ExampleModel extends Model
```

## Tipizzazione

### Type Hints Obbligatori
```php
// ✅ CORRETTO
public function process(User $user, array $data): Result
{
    // Implementazione
}

// ❌ ERRATO
public function process($user, $data)
{
    // Implementazione
}
```

### Return Types Espliciti
```php
// ✅ CORRETTO
public function getData(): array
public function findUser(int $id): ?User
public function process(): void

// ❌ ERRATO
public function getData() { return $data; }
public function findUser($id) { return User::find($id); }
```

### Generics per Collection
```php
// ✅ CORRETTO
/**
 * @return \Illuminate\Database\Eloquent\Collection<int, User>
 */
public function getUsers(): Collection

// ❌ ERRATO
public function getUsers(): Collection
```

### Union Types
```php
// ✅ CORRETTO
public function process(string|int $value): void
public function find(string|int $id): ?Model

// ❌ ERRATO
public function process($value): void
```

## Modelli Eloquent

### Proprietà Fillable
```php
/**
 * @var list<string>
 */
protected $fillable = [
    'name',
    'email',
    'status',
];
```

### Metodo Casts (Non Proprietà)
```php
/**
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
        'settings' => 'array',
    ];
}
```

### PHPDoc Completo
```php
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 */
class User extends BaseModel
{
    // Implementazione
}
```

## Actions e Data Objects

### Spatie QueueableActions
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Spatie\QueueableAction\QueueableAction;

class ProcessDataAction
{
    use QueueableAction;

    public function execute(array $data): Result
    {
        // Implementazione
    }
}
```

### Spatie Laravel Data
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

class UserData extends Data
{
    public function __construct(
        #[Required]
        public readonly string $name,

        #[Required]
        public readonly string $email,

        public readonly ?int $id = null,
    ) {
    }
}
```

## Filament Resources

### Estensione Corretta
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;

class ExampleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            // Altri campi...
        ];
    }
}
```

### Metodi Obbligatori
```php
/**
 * @return array<string, \Filament\Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        // Schema del form
    ];
}

/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        // Colonne della tabella
    ];
}
```

## Service Providers

### Struttura Standard
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName'; // SEMPRE dichiarare subito

    public function boot(): void
    {
        parent::boot();
        // Solo personalizzazioni specifiche
    }

    public function register(): void
    {
        parent::register();
        // Solo registrazioni specifiche
    }
}
```

## Migrazioni

### Classi Anonime
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        // Implementazione migrazione
    }
    // NIENTE metodo down()
};
```

### Controlli di Esistenza
```php
public function up(): void
{
    if (Schema::hasTable($this->table_name)) {
        return;
    }

    Schema::create($this->table_name, function (Blueprint $table) {
        // Creazione tabella
    });
}
```

## Traduzioni

### Struttura Espansa
```php
// ✅ CORRETTO
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome completo dell\'utente',
        ],
    ],
];

// ❌ ERRATO
return [
    'fields' => [
        'name' => 'Nome',
    ],
];
```

### Regola Helper Text
```php
// ✅ CORRETTO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Indirizzo completo di residenza', // Diverso da placeholder
],

// ❌ ERRATO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Inserisci indirizzo', // Uguale a placeholder
],
```

## Testing

### Struttura Test
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature;

use Tests\TestCase;
use Modules\ModuleName\Models\ExampleModel;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_can_create_example(): void
    {
        // Arrange
        $data = ['name' => 'Test'];

        // Act
        $response = $this->postJson('/api/examples', $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('examples', $data);
    }
}
```

### Naming Test
```php
// ✅ CORRETTO
public function it_can_create_user(): void
public function it_validates_required_fields(): void
public function it_returns_404_for_invalid_id(): void

// ❌ ERRATO
public function testCreateUser(): void
public function createUser(): void
```

## Componenti UI

### Posizionamento Corretto
```
Modules/UI/resources/views/components/ui/
├── button.blade.php
├── card.blade.php
└── logo.blade.php
```

### Utilizzo Corretto
```blade
{{-- ✅ CORRETTO --}}
<x-ui::ui.button>Salva</x-ui::ui.button>
<x-ui::ui.card>Contenuto</x-ui::ui.card>

{{-- ❌ ERRATO --}}
<x-button>Salva</x-button>
<x-ui.button>Salva</x-ui.button>
```

## PHPStan Compliance

### Livello 9+ Obbligatorio
```bash
cd /var/www/html/_bases/base_<nome progetto>/laravel
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G
```

### Correzioni Comuni
```php
// ❌ ERRATO
public function getData() { return $data; }

// ✅ CORRETTO
public function getData(): array { return $data; }

// ❌ ERRATO
public function process($user) { /* ... */ }

// ✅ CORRETTO
public function process(User $user): void { /* ... */ }
```

## Best Practices

### 1. Naming Conventions
- **Classi**: PascalCase (`UserController`)
- **Metodi**: camelCase (`getUserData()`)
- **Variabili**: camelCase (`$userData`)
- **Costanti**: UPPER_SNAKE_CASE (`MAX_RETRY_COUNT`)

### 2. Commenti e Documentazione
```php
/**
 * Processa i dati dell'utente.
 *
 * @param User $user L'utente da processare
 * @param array<string, mixed> $data I dati da processare
 * @return Result Il risultato del processing
 * @throws \InvalidArgumentException Se i dati sono invalidi
 */
public function processUser(User $user, array $data): Result
{
    // Implementazione
}
```

### 3. Gestione Errori
```php
// ✅ CORRETTO
if (!$user) {
    throw new \InvalidArgumentException('User is required');
}

// ❌ ERRATO
if (!$user) {
    return null;
}
```

### 4. Performance
```php
// ✅ CORRETTO - Eager loading
$users = User::with(['roles', 'permissions'])->get();

// ❌ ERRATO - N+1 query
$users = User::all();
foreach ($users as $user) {
    $user->roles; // Query aggiuntiva
}
```

## Checklist di Conformità

### Prima del Commit
- [ ] `declare(strict_types=1);` presente
- [ ] Type hints per tutti i parametri
- [ ] Return types espliciti
- [ ] PHPDoc completo per classi e metodi
- [ ] Namespace corretto (senza 'App')
- [ ] Ereditarietà corretta (XotBase classes)
- [ ] Traduzioni strutturate (label, placeholder, help)
- [ ] Test scritti e passanti
- [ ] PHPStan livello 9+ passante

### Durante lo Sviluppo
- [ ] Seguire principi DRY e KISS
- [ ] Utilizzare Spatie packages quando appropriato
- [ ] Evitare stringhe hardcoded
- [ ] Documentare decisioni complesse
- [ ] Testare edge cases
- [ ] Considerare implicazioni di sicurezza

## Errori Comuni e Soluzioni

### Errore: ParseError - Metodi Fuori dalla Classe
**Sintomo**: `ParseError: syntax error, unexpected token "protected", expecting end of file`

**Causa**: Una funzione viene dichiarata **fuori dal blocco della classe** dopo la parentesi graffa di chiusura `}`.

**Soluzione**:
1. Spostare il metodo all'interno della classe corretta
2. Verificare che la parentesi graffa di chiusura sia l'ultima istruzione del file
3. Se il metodo non serve più, eliminarlo

### Errore: Namespace Senza Segmento 'App'
**Sintomo**: `Class not found: Modules\ModuleName\App\Models\Example`

**Causa**: Utilizzo di namespace con segmento `App` che non esiste nella struttura modulare.

**Soluzione**:
```php
// ❌ ERRATO
namespace Modules\ModuleName\App\Models;
namespace Modules\ModuleName\App\Actions;

// ✅ CORRETTO
namespace Modules\ModuleName\Models;
namespace Modules\ModuleName\Actions;
```

### Errore: Estensione Diretta di Classi Filament
**Sintomo**: `Call to undefined method Filament\Resources\Resource::getFormSchema()`

**Causa**: Estensione diretta di classi Filament invece delle classi base Xot.

**Soluzione**:
```php
// ❌ ERRATO
use Filament\Resources\Resource;
class ExampleResource extends Resource

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class ExampleResource extends XotBaseResource
```

### Errore: Service Provider Senza Nome
**Sintomo**: `Service provider must have a name property`

**Causa**: Mancanza della proprietà `$name` nel service provider.

**Soluzione**:
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName'; // SEMPRE dichiarare subito

    public function boot(): void
    {
        parent::boot();
    }
}
```

### Errore: Traduzioni Hardcoded
**Sintomo**: Stringhe hardcoded nell'interfaccia invece di traduzioni.

**Causa**: Utilizzo di `->label()` o stringhe dirette invece di file di traduzione.

**Soluzione**:
```php
// ❌ ERRATO
TextInput::make('name')->label('Nome')
Select::make('role')->placeholder('Seleziona ruolo')

// ✅ CORRETTO
TextInput::make('name')  // Usa traduzione automatica
Select::make('role')     // Usa traduzione automatica
```

### Errore: Migrazioni con Metodo Down()
**Sintomo**: `Method down() not allowed in XotBaseMigration`

**Causa**: Implementazione del metodo `down()` in migrazioni che estendono `XotBaseMigration`.

**Soluzione**:
```php
// ❌ ERRATO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    public function down(): void { /* ... */ } // ERRORE
};

// ✅ CORRETTO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    // NIENTE metodo down()
};
```

### Errore: PHPStan - Livello Troppo Basso
**Sintomo**: `PHPStan analysis failed at level 5`

**Causa**: Codice non conforme agli standard di tipizzazione.

**Soluzione**:
```bash
# Eseguire da directory Laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G
```

### Correzioni Comuni
```php
// ❌ ERRATO
public function getData() { return $data; }

// ✅ CORRETTO
public function getData(): array { return $data; }

// ❌ ERRATO
public function process($user) { /* ... */ }

// ✅ CORRETTO
public function process(User $user): void { /* ... */ }
```

### Errore: Componenti UI nel Posto Sbagliato
**Sintomo**: `Component not found: x-logo`

**Causa**: Componenti UI posizionati in `resources/views/components/` invece di `Modules/UI/resources/views/components/ui/`.

**Soluzione**:
```bash
# Spostare componenti nella posizione corretta
mv resources/views/components/ui/* Modules/UI/resources/views/components/ui/
```

### Utilizzo Corretto
```blade
{{-- ✅ CORRETTO --}}
<x-ui::ui.logo />
<x-ui::ui.button>Salva</x-ui::ui.button>

{{-- ❌ ERRATO --}}
<x-logo />
<x-ui.button>Salva</x-ui.button>
```

### Errore: Helper Text Uguale a Placeholder
**Sintomo**: Duplicazione di testo nell'interfaccia utente.

**Causa**: `helper_text` uguale al `placeholder` o alla chiave dell'array.

**Soluzione**:
```php
// ❌ ERRATO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Inserisci indirizzo', // Uguale a placeholder
],

// ✅ CORRETTO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Indirizzo completo di residenza o domicilio',
],
```

### Errore: Traduzioni Incomplete
**Sintomo**: Chiavi di traduzione mancanti o incomplete.

**Causa**: Aggiunta di traduzioni senza implementare in tutte le lingue.

**Soluzione**:
```php
// Implementare SEMPRE in tutte le lingue
// Modules/ModuleName/lang/it/fields.php
'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Nome completo',
],

// Modules/ModuleName/lang/en/fields.php
'name' => [
    'label' => 'Name',
    'placeholder' => 'Enter name',
    'help' => 'Full name',
],

// Modules/ModuleName/lang/de/fields.php
'name' => [
    'label' => 'Name',
    'placeholder' => 'Name eingeben',
    'help' => 'Vollständiger Name',
],
```

### Errore: Upload File Placeholder Errato
**Sintomo**: Placeholder che descrive il contenuto invece dell'azione.

**Causa**: Placeholder che indica cosa inserire invece di cosa fare.

**Soluzione**:
```php
// ❌ ERRATO
'upload_file' => [
    'placeholder' => 'Numero fattura', // Contenuto
],

// ✅ CORRETTO
'upload_file' => [
    'placeholder' => 'Carica Fattura', // Azione
],
```

### Errore: Mescolanza di Lingue
**Sintomo**: Traduzioni che mescolano lingue diverse.

**Causa**: Utilizzo di termini in inglese in traduzioni italiane.

**Soluzione**:
```php
// ❌ ERRATO
'no_show' => 'Messaggio No-Show', // Mescola italiano e inglese

// ✅ CORRETTO
'no_show' => 'Messaggio Non Presentato', // Solo italiano
```

## Checklist di Risoluzione

### Prima di Implementare
- [ ] Studiare la documentazione del modulo
- [ ] Verificare namespace e struttura
- [ ] Controllare ereditarietà delle classi
- [ ] Verificare file di traduzione

### Durante l'Implementazione
- [ ] Seguire convenzioni di naming
- [ ] Utilizzare tipizzazione rigorosa
- [ ] Implementare traduzioni complete
- [ ] Testare funzionalità

### Dopo l'Implementazione
- [ ] Eseguire PHPStan livello 9+
- [ ] Verificare traduzioni in tutte le lingue
- [ ] Aggiornare documentazione
- [ ] Testare regressioni

## Comandi Utili

### Verifica Struttura
```bash
# Trova file con namespace errati
grep -r "namespace.*App" laravel/Modules/

# Trova stringhe hardcoded
grep -r "->label(" laravel/Modules/ --include="*.php"

# Verifica traduzioni
find laravel/Modules/*/lang -name "*.php" -exec php -l {} \;
```

### Correzione Automatica
```bash
# Aggiorna autoload
composer dump-autoload

# Pulisci cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Verifica PHPStan
./vendor/bin/phpstan analyze --level=9
```

## Collegamenti

- [PHPStan Guide](phpstan-consolidated.md)
- [Translation Guide](translation-system.md)
- [Filament Guide](filament.md)
- [Testing Guide](testing-consolidated.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Best Practices*
