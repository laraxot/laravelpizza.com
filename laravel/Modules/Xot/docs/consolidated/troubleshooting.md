# 🚨 **Troubleshooting Modulo Xot**

## 📋 **Panoramica**

Questo documento contiene le soluzioni ai problemi più comuni che possono verificarsi durante lo sviluppo con il modulo Xot, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**.

## 🚨 **Problemi Critici**
#### Composer
```bash

# Pulire la cache di Composer
composer clear-cache

### **1. Classe Base Non Trovata**

#### **Sintomi**
```
Fatal error: Class 'Modules\Xot\Models\BaseModel' not found
Class 'Modules\Xot\Filament\Resources\XotBaseResource' not found
```

#### **Cause Possibili**
- Autoload non aggiornato
- Namespace errato
- Modulo Xot non installato correttamente
#### NPM
```bash

# Pulire la cache di NPM
npm cache clean --force

#### **Soluzioni**

**Soluzione 1: Aggiornare Autoload**
```bash
# Dalla root del progetto Laravel
composer dump-autoload
composer install
```

**Soluzione 2: Verificare Namespace**
```php
// ✅ CORRETTO
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Filament\Resources\XotBaseResource;

// ❌ ERRATO
use App\Models\BaseModel;
use Filament\Resources\XotBaseResource;
#### Migrazioni
```bash

# Ripristinare le migrazioni
php artisan migrate:fresh

# Eseguire i seed
php artisan db:seed
```

**Soluzione 3: Verificare Installazione Modulo**
```bash
# Verificare che il modulo sia presente
ls -la laravel/Modules/Xot/

# Verificare la connessione
php artisan db:monitor

# Verificare composer.json
cat laravel/Modules/Xot/composer.json
```

### **2. Traduzioni Non Caricate**

#### **Sintomi**
- Chiavi di traduzione non tradotte
- Messaggi in inglese invece che in italiano
- Errori "Translation key not found"

#### **Soluzioni**

**Soluzione 1: Pulire Cache**
```bash

# Pulire la cache dell'applicazione
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

**Soluzione 2: Verificare Service Provider**
```bash
# Verificare che il service provider sia registrato

# Verificare lo stato dei moduli
php artisan module:list

# Verificare configurazione
php artisan config:show app.providers
```

**Soluzione 3: Verificare Struttura Traduzioni**
```bash
# Verificare struttura file traduzioni
ls -la laravel/Modules/Xot/lang/it/
ls -la laravel/Modules/Xot/lang/en/
ls -la laravel/Modules/Xot/lang/de/

# Pubblicare gli assets
php artisan module:publish ModuleName

# Pubblicare le configurazioni
php artisan module:publish-config ModuleName

# Pubblicare le migrazioni
php artisan module:publish-migration ModuleName
```

### **3. Errori PHPStan Livello 10**

#### **Sintomi**
```
ERROR: Access to an undefined property
ERROR: Method not found
ERROR: Return type mismatch
```

#### **Soluzioni**

**Soluzione 1: Aggiungere Annotazioni PHPDoc**
### 1. Errori di Compilazione
```bash

# Compilare gli assets
npm run build

# Compilare gli assets del tema
npm run theme:build
```

### 2. Errori di Visualizzazione
```bash

# Pulire la cache delle viste
php artisan view:clear

# Verificare i permessi
chmod -R 775 storage bootstrap/cache
```

### 3. Errori di copia asset
Se si ottiene un errore **Permission denied** durante la copia degli asset, eseguire:
```bash
mkdir -p public_html/assets/<module>/<path>
chmod -R 755 public_html/assets
```
Assicurarsi che l'utente del web server (es. www-data) abbia i permessi di scrittura su `public_html/assets`.

## Filament

### 1. Errori del Pannello
```bash

# Pubblicare gli assets
php artisan filament:assets

# Pubblicare le configurazioni
php artisan filament:config
```

### 2. Errori dei Widget
```bash

# Pubblicare i widget
php artisan filament:widgets

# Verificare i widget
php artisan filament:check
```

## Volt e Livewire

### 1. Errori dei Componenti

#### Pubblicazione Assets e Configurazioni
```bash

# Pubblicare gli assets
php artisan livewire:publish --assets

# Pubblicare le configurazioni
php artisan livewire:publish --config
```

#### Errore: Multiple Root Elements Detected

Se riscontri questo errore:
```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected.
```

Soluzione:
1. Ogni componente Volt deve avere un singolo elemento HTML radice
2. Racchiudi tutti gli elementi del componente in un unico `<div>` o altro elemento contenitore

**Esempio corretto:**
```php
/**
 * @property int $id
 * @property string $nome
 * @property \Carbon\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\app\Models\User> $users
 */
class MioModello extends BaseModel
{
    // Implementazione
}
```

**Soluzione 2: Tipizzazione Esplicita**
```php
// ✅ CORRETTO
public function getUser(): User
{
    return $this->belongsTo(User::class);
}

// ❌ ERRATO
public function getUser()
{
    return $this->belongsTo(User::class);
}
```

**Soluzione 3: Eseguire PHPStan**
```bash
# Dalla root del progetto Laravel
./vendor/bin/phpstan analyse --level=10

# Compilare gli assets
npm run dev

# Per un modulo specifico
./vendor/bin/phpstan analyse Modules/Xot --level=10
```

## 🔧 **Problemi Specifici**

### **1. Problemi di Ereditarietà**
### 1. Log dell'Applicazione
```bash

# Visualizzare i log
tail -f storage/logs/laravel.log

#### **Sintomi**
```
Fatal error: Cannot override final method
Fatal error: Cannot inherit from final class
```

#### **Soluzioni**

**Verificare Estensione Corretta**
```php
// ✅ CORRETTO - Estendere sempre le classi base Xot
class MioModello extends BaseModel
class MiaRisorsa extends XotBaseResource
class MioServiceProvider extends XotBaseServiceProvider

// ❌ ERRATO - Mai estendere direttamente le classi Laravel
class MioModello extends \Illuminate\Database\Eloquent\Model
class MiaRisorsa extends \Filament\Resources\Resource
```

**Verificare Metodi Final**
```php
// I metodi final non possono essere sovrascritti
// Utilizzare i metodi di hook invece
protected function afterCreate(): void
{
    // Logica dopo la creazione
}
```

### **2. Problemi di Service Provider**

#### **Sintomi**
- Views non caricate
- Traduzioni non funzionanti
- Migrazioni non eseguite

#### **Soluzioni**

**Verificare Struttura Service Provider**
```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MioModuloServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = 'MioModulo';
    
    public function boot(): void
    {
        parent::boot(); // IMPORTANTE: chiamare sempre parent::boot()
        
        // Solo personalizzazioni specifiche
    }
}
```

**Verificare Registrazione**
```bash
# Verificare che il service provider sia registrato
php artisan config:show app.providers | grep MioModulo

# Verificare autoload
composer dump-autoload
```

### **3. Problemi di Migrazioni**

#### **Sintomi**
```
SQLSTATE[42S01]: Base table or view already exists
SQLSTATE[42S02]: Base table or view not found
```

#### **Soluzioni**

**Verificare Estensione Corretta**
```php
// ✅ CORRETTO
return new class extends XotBaseMigration
{
    protected string $table_name = 'mio_modello';
    
    public function up(): void
    {
        if ($this->hasTable($this->table_name)) {
            return; // Importante: verificare esistenza
        }
        
        Schema::create($this->table_name, function (Blueprint $table) {
            // Schema
        });
    }
};
```

**Verificare Controlli Esistenza**
```php
public function up(): void
{
    // Verificare esistenza tabella
    if ($this->hasTable($this->table_name)) {
        return;
    }
    
    // Verificare esistenza colonne
    if ($this->hasColumn($this->table_name, 'nuova_colonna')) {
        return;
    }
}
```

## 🧪 **Problemi di Testing**

### **1. Test Non Eseguibili**

#### **Sintomi**
```
Class 'Modules\Xot\Tests\XotBaseTestCase' not found
Fatal error: Cannot instantiate abstract class
```

#### **Soluzioni**

**Verificare Estensione Test Case**
```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\Tests;

use Modules\Xot\Tests\XotBaseTestCase;
use Modules\MioModulo\app\Models\MioModello;

class MioModelloTest extends XotBaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    /** @test */
    public function it_can_create_model(): void
    {
        $modello = MioModello::create([
            'nome' => 'Test',
            'descrizione' => 'Test Description'
        ]);
        
        $this->assertModelExists($modello);
    }
}
```

**Verificare Autoload Test**
```bash
# Verificare che i test siano nell'autoload
composer dump-autoload

# Eseguire test specifico
php artisan test --filter=MioModelloTest
```

### **2. Problemi di Database nei Test**

#### **Sintomi**
```
SQLSTATE[42S02]: Base table or view not found
SQLSTATE[23000]: Integrity constraint violation
```

#### **Soluzioni**

**Utilizzare RefreshDatabase**
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MioModelloTest extends XotBaseTestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup database per i test
    }
}
```

**Verificare Migrazioni**
```bash
# Eseguire migrazioni per i test
php artisan migrate --env=testing

# Verificare stato migrazioni
php artisan migrate:status --env=testing
```

## 🔒 **Problemi di Sicurezza**

### **1. Problemi di Autorizzazione**

#### **Sintomi**
- Utenti possono accedere a risorse non autorizzate
- Errori "Unauthorized" o "Forbidden"

#### **Soluzioni**

**Verificare Policy**
```php
<?php

declare(strict_types=1);

namespace Modules\MioModulo\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\app\Models\User;
use Modules\MioModulo\app\Models\MioModello;

class MioModelloPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny', MioModello::class);
    }
    
    public function view(User $user, MioModello $modello): bool
    {
        return $user->can('view', $modello);
    }
}
```

**Verificare Registrazione Policy**
```php
// Nel service provider del modulo
protected function registerPolicies(): void
{
    Gate::policy(MioModello::class, MioModelloPolicy::class);
}
```

### **2. Problemi di Validazione**

#### **Sintomi**
- Dati non validati correttamente
- Errori di validazione non gestiti

#### **Soluzioni**

**Verificare Regole Validazione**
```php
public static function rules(): array
{
    return [
        'nome' => ['required', 'string', 'max:255'],
        'descrizione' => ['nullable', 'string', 'max:1000'],
        'is_active' => ['required', 'boolean'],
    ];
}
```

**Verificare Gestione Errori**
```php
try {
    $modello = MioModello::create($data);
} catch (\Illuminate\Database\QueryException $e) {
    Log::error('Errore creazione modello', [
        'data' => $data,
        'error' => $e->getMessage()
    ]);
    
    throw new ModelCreationException('Impossibile creare il modello', 0, $e);
}
```

## 📈 **Problemi di Performance**

### **1. N+1 Query Problem**

#### **Sintomi**
- Performance lente
- Troppe query al database

#### **Soluzioni**

**Utilizzare Eager Loading**
```php
// ✅ CORRETTO
$modelli = MioModello::with(['user', 'altriModelli'])->get();

// ❌ ERRATO
$modelli = MioModello::all();
foreach ($modelli as $modello) {
    echo $modello->user->name; // Query aggiuntiva per ogni modello
}
```

**Utilizzare Query Builder**
```php
$modelli = MioModello::query()
    ->with(['user', 'altriModelli'])
    ->where('is_active', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### **2. Problemi di Caching**

#### **Sintomi**
- Performance inconsistenti
- Dati non aggiornati

#### **Soluzioni**

**Verificare Configurazione Cache**
```bash
# Verificare driver cache
php artisan config:show cache.default

# Pulire cache
php artisan cache:clear
```

**Utilizzare Cache Tags**
```php
// Cache con tag per invalidazione selettiva
cache()->tags(['modelli', 'user_' . $userId])->remember(
    "modello_{$id}",
    now()->addMinutes(30),
    fn() => MioModello::find($id)
);

// Invalidare cache specifica
cache()->tags(['modelli'])->flush();
```

## 🔍 **Debug e Diagnostica**

### **1. Abilitare Debug**

```php
// Nel file .env
APP_DEBUG=true
APP_ENV=local

// Nel codice
Log::debug('Debug info', ['context' => 'value']);
dd($variable); // Solo in sviluppo
```

### **2. Utilizzare Telescope (se disponibile)**

```bash
# Installare Laravel Telescope
composer require laravel/telescope --dev

# Pubblicare configurazione
php artisan telescope:install

# Accedere a Telescope
http://localhost/telescope
```

### **3. Utilizzare Query Log**

```php
// Abilitare query log
DB::enableQueryLog();

// Eseguire operazioni
$modelli = MioModello::with('user')->get();

// Visualizzare query eseguite
dd(DB::getQueryLog());
```

## 📋 **Checklist Troubleshooting**

### **Problemi Comuni**
- [ ] Autoload aggiornato (`composer dump-autoload`)
- [ ] Cache pulita (`php artisan cache:clear`)
- [ ] Namespace corretto
- [ ] Estensione classi base Xot
- [ ] Service provider registrato
- [ ] Migrazioni eseguite
- [ ] PHPStan livello 10 superato

### **Verifiche Specifiche**
- [ ] Modulo Xot installato correttamente
- [ ] File di traduzioni presenti
- [ ] Views nella posizione corretta
- [ ] Migrazioni estendono XotBaseMigration
- [ ] Test estendono XotBaseTestCase
- [ ] Policy registrate correttamente

### **Performance**
- [ ] Eager loading utilizzato
- [ ] Indici database presenti
- [ ] Caching implementato
- [ ] Query ottimizzate

## 🔗 **Collegamenti e Riferimenti**

- [**README.md**](README.md) - Documentazione principale del modulo
- [**Best Practices**](best-practices.md) - Best practices per evitare problemi
- [**Architettura**](architecture.md) - Architettura del modulo Xot
- [**Documentazione Laravel**](https://laravel.com/docs) - Troubleshooting generale

---

*Ultimo aggiornamento: giugno 2025 - Versione 2.0.0*
