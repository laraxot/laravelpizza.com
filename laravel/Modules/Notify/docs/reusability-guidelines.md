# Linee Guida per la Riusabilità del Modulo Notify

## Principio Fondamentale
Il modulo Notify è progettato per essere **completamente riutilizzabile** tra diversi progetti Laraxot. Questo significa che NON deve mai contenere riferimenti hardcoded a progetti specifici.

## Regole Critiche per la Riusabilità

### 1. NO Hardcoding di Nomi Progetti
❌ **MAI usare stringhe hardcoded di progetti specifici:**
```php
// ERRORE: Hardcoding del nome progetto
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
$user = \Modules\SaluteOra\Models\User::factory()->create();
'database' => 'saluteora_test',
$this->app['config']->set('database.connections.saluteora_test', [
```

✅ **SEMPRE utilizzare pattern riutilizzabili:**
```php
// CORRETTO: Utilizzo di XotData per ottenere la classe User del progetto corrente
$user = XotData::make()->getUserClass()::factory()->create();
$database = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$database}", [
```

### 2. Utilizzo di XotData per Classi Dynamic
Il modulo Notify deve utilizzare `XotData::make()->getUserClass()` per ottenere dinamicamente la classe User del progetto corrente:

```php
use Modules\Xot\Datas\XotData;

// Invece di: \Modules\<nome progetto>\Models\User::class
// Invece di: \Modules\SaluteOra\Models\User::class
$userClass = XotData::make()->getUserClass();
$user = $userClass::factory()->create();
```

### 3. Configurazioni Database Dynamic
Per i test che richiedono configurazioni database specifiche:

```php
// Invece di: '<nome progetto>_test'
// Invece di: 'saluteora_test'
$testDatabase = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$testDatabase}", [
    // configurazione
]);
```

### 4. Pattern per Namespace Dynamic
Quando necessario riferirsi a modelli di altri moduli:

```php
// Per ottenere il namespace del progetto corrente
$projectNamespace = XotData::make()->getProjectNamespace();
$userModel = "{$projectNamespace}\\Models\\User";
```

## Anti-Pattern da Evitare

### ❌ Riferimenti Diretti a Progetti
```php
// VIETATO: Riferimenti hardcoded
use Modules\<nome progetto>\Models\User;
use Modules\<nome progetto>\Models\Patient;
'database' => '<nome progetto>_test'
$this->artisan('migrate', ['--database' => '<nome progetto>_test']);
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
'database' => 'saluteora_test'
$this->artisan('migrate', ['--database' => 'saluteora_test']);
```

### ❌ Configurazioni Project-Specific
```php
// VIETATO: Configurazioni specifiche del progetto
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
'app_name' => 'SaluteOra',
'tenant_model' => \Modules\SaluteOra\Models\Studio::class,
```

## Pattern Corretti per Riusabilità

### ✅ Utilizzo di Helper e Configuration
```php
// CORRETTO: Utilizzo di configurazioni dynamic
$appName = config('app.name');
$tenantModel = config('filament.tenancy.tenant_model');
$userClass = XotData::make()->getUserClass();
```

### ✅ Test Configurabili
```php
// CORRETTO: Test che si adattano al progetto corrente
public function setUp(): void
{
    parent::setUp();
    
    $this->userClass = XotData::make()->getUserClass();
    $this->testDatabase = config('database.default') . '_test';
    
    // Configurazione dynamic
    $this->app['config']->set("database.connections.{$this->testDatabase}", [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
}
```

### ✅ Factory Pattern Riutilizzabili
```php
// CORRETTO: Factory che si adatta al progetto
protected function createTestUser(): mixed
{
    $userClass = XotData::make()->getUserClass();
    return $userClass::factory()->create([
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
}
```

## Checklist per Moduli Riutilizzabili

Prima di committare modifiche al modulo Notify:

- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
- [ ] Nessun riferimento hardcoded a "saluteora" o altri nomi di progetti
- [ ] Utilizzo di `XotData::make()->getUserClass()` per la classe User
- [ ] Configurazioni database dinamiche nei test
- [ ] Nessun import diretto di modelli da altri progetti
- [ ] Traduzioni generiche senza riferimenti a progetti specifici
- [ ] Documentazione che non menziona progetti specifici
- [ ] Test che funzionano indipendentemente dal progetto host

## Testing della Riusabilità

Per verificare che il modulo sia veramente riutilizzabile:

```bash
# Cerca hardcoding di nomi progetti
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
grep -r -i "saluteora\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor

# Cerca import diretti da altri moduli
grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]" Modules/Notify/

# Cerca configurazioni hardcoded
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
grep -r "database.*saluteora\|app.*saluteora" Modules/Notify/
```

## Benefici della Riusabilità

1. **Portabilità**: Il modulo può essere utilizzato in qualsiasi progetto Laraxot
2. **Manutenibilità**: Un solo codebase da mantenere per tutti i progetti
3. **Coerenza**: Comportamento uniforme delle notifiche tra progetti
4. **Efficienza**: Evita duplicazione di codice e logica
5. **Scalabilità**: Facilita l'aggiunta di nuovi progetti

## Collegamenti

- [../../../docs/module_reusability_guidelines.md](../../../docs/module_reusability_guidelines.md)
- [../../Xot/docs/xotdata_usage.md](../../Xot/docs/xotdata_usage.md)
- [testing_best_practices.md](testing_best_practices.md)

*Ultimo aggiornamento: gennaio 2025*
