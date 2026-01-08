# Xot - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Filosofica Completa  
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)

### Principio Fondamentale

**Xot è il motore fondamentale che alimenta tutti gli altri moduli. Non contiene logica di business, solo infrastruttura.**

### Domini di Responsabilità

#### 1. Base Classes (Classi Base)

**Logica**: Fornire classi base per tutti i moduli.

**Componenti**:
- `XotBaseModel`: Modello base con funzionalità comuni
- `XotBaseResource`: Resource Filament base
- `XotBaseWidget`: Widget Filament base
- `XotBasePage`: Page Filament base
- `XotBaseMigration`: Migration base con auto-discovery

**Manifestazione nel Codice**:
```php
// XotBaseModel fornisce funzionalità comuni
abstract class XotBaseModel extends Model
{
    use HasXotFactory;
    use HasUuid;
    use SoftDeletes;
    // ... altre funzionalità comuni
}

// Ogni modulo estende XotBaseModel
class BaseModel extends XotBaseModel
{
    protected $connection = 'module_name';
}
```

#### 2. Service Providers (Provider di Servizio)

**Logica**: Fornire provider base per registrazione moduli.

**Componenti**:
- `XotBaseServiceProvider`: Provider base per moduli
- `XotBaseRouteServiceProvider`: Provider route base
- `XotServiceProvider`: Provider core Xot

**Manifestazione nel Codice**:
```php
// XotBaseServiceProvider fornisce funzionalità comuni
abstract class XotBaseServiceProvider extends ServiceProvider
{
    public string $name = 'ModuleName';
    
    protected function registerConfig(): void
    {
        // Auto-registrazione config
    }
    
    protected function registerViews(): void
    {
        // Auto-registrazione views
    }
    
    protected function registerTranslations(): void
    {
        // Auto-registrazione traduzioni
    }
}
```

#### 3. Contracts (Contratti)

**Logica**: Definire interfacce type-safe per type safety.

**Componenti**:
- `UserContract`: Interfaccia per User
- `ModelContract`: Interfaccia per Model
- `ProfileContract`: Interfaccia per Profile
- `HasRecursiveRelationshipsContract`: Interfaccia per modelli ricorsivi

**Manifestazione nel Codice**:
```php
// UserContract definisce interfaccia User
interface UserContract extends Authenticatable
{
    public function getId(): string|int;
    public function getName(): ?string;
    public function getEmail(): string;
    public function profile(): HasOne;
    // ... altri metodi
}
```

#### 4. Traits (Tratti)

**Logica**: Fornire funzionalità riutilizzabili via traits.

**Componenti**:
- `HasXotFactory`: Factory pattern per modelli
- `HasExtraTrait`: Gestione campi extra
- `TypedHasRecursiveRelationships`: Relazioni ricorsive type-safe
- `RelationX`: Relazioni estese

**Manifestazione nel Codice**:
```php
// HasXotFactory fornisce factory pattern
trait HasXotFactory
{
    protected static function newFactory(): Factory
    {
        // Auto-discovery factory
    }
}

// HasExtraTrait fornisce gestione extra fields
trait HasExtraTrait
{
    public function getExtra(string $key): mixed
    {
        // Gestione extra fields
    }
}
```

#### 5. Helpers (Funzioni Helper)

**Logica**: Fornire funzioni helper globali per utilità comuni.

**Componenti**:
- `dddx()`: Debug esteso
- `getFilename()`: Estrazione filename
- `isRunningTestBench()`: Verifica test environment
- `authId()`: ID utente autenticato

**Manifestazione nel Codice**:
```php
// Helper functions globali
if (! function_exists('dddx')) {
    function dddx(mixed $var): void
    {
        // Debug esteso
    }
}
```

#### 6. Data Objects (Oggetti Dati)

**Logica**: Fornire Data Objects per type safety.

**Componenti**:
- `XotData`: Data object centrale per configurazione
- Altri Data Objects per specifici domini

**Manifestazione nel Codice**:
```php
// XotData è il data object centrale
class XotData extends Data implements Wireable
{
    public string $main_module = '';
    public string $primary_lang = 'it';
    public string $team_class = 'Modules\User\Models\Team';
    // ... altre configurazioni
}
```

### Pattern Logici

#### 1. Base Class Pattern

**Logica**: Ogni tipo di classe ha una base class in Xot.

**Manifestazione**:
- Models → XotBaseModel
- Resources → XotBaseResource
- Widgets → XotBaseWidget
- Pages → XotBasePage
- Migrations → XotBaseMigration

**Filosofia**: Consistency, DRY, type safety.

#### 2. Contract Pattern

**Logica**: Tutte le entità principali hanno Contracts.

**Manifestazione**:
- User → UserContract
- Model → ModelContract
- Profile → ProfileContract

**Filosofia**: Type safety, dependency injection, testability.

#### 3. Trait Pattern

**Logica**: Funzionalità comuni sono in Traits.

**Manifestazione**:
- HasXotFactory
- HasExtraTrait
- TypedHasRecursiveRelationships

**Filosofia**: Composizione, riusabilità, DRY.

#### 4. Auto-Discovery Pattern

**Logica**: Auto-discovery di classi, config, views, traduzioni.

**Manifestazione**:
- Auto-discovery factories
- Auto-discovery policies
- Auto-discovery migrations
- Auto-discovery traduzioni

**Filosofia**: Convenzione over configurazione, DRY.

---

## ⛪ Religione (Religion)

### Comandamenti Sacri di Xot

#### 1. Xot NON Contiene Logica di Business

**Comandamento**: Xot fornisce solo infrastruttura, mai logica di business.

**Violazione**: Aggiungere logica di business a Xot è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: Xot fornisce solo infrastruttura
class XotBaseModel extends Model
{
    // Solo funzionalità infrastrutturali
    use HasXotFactory;
    use HasUuid;
}

// ❌ ERESIA: Logica di business in Xot
class XotBaseModel extends Model
{
    public function calculateSurveyStats(): array
    {
        // Logica di business NON appartiene a Xot!
    }
}
```

#### 2. Mai Estendere Filament Direttamente

**Comandamento**: Mai estendere classi Filament direttamente. Sempre XotBase.

**Violazione**: Estendere Filament direttamente è eresia architetturale.

**Manifestazione**:
```php
// ✅ CORRETTO: Estende XotBaseResource
class MyResource extends XotBaseResource
{
    // ...
}

// ❌ ERESIA: Estende Filament direttamente
class MyResource extends Resource
{
    // Rompe architettura Laraxot
}
```

#### 3. Una Tabella, Una Migrazione

**Comandamento**: Ogni tabella ha esattamente UNA migration create_table.

**Violazione**: Creare multiple migrations per stessa tabella è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: Una migration per tabella
// 2024_01_01_000001_create_users_table.php

// ❌ ERESIA: Multiple migrations per stessa tabella
// 2023_01_01_000001_create_users_table.php
// 2024_01_01_000001_create_users_table.php // DUPLICATO!
```

#### 4. Mai Usare `->label()` Direttamente

**Comandamento**: Mai usare `->label()`, `->placeholder()`, `->tooltip()` direttamente. Sempre traduzioni.

**Violazione**: Hardcode labels è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: Traduzioni automatiche
TextInput::make('name');
// Traduzione da: Modules/MyModule/lang/it/fields.php

// ❌ ERESIA: Labels hardcoded
TextInput::make('name')
    ->label('Nome') // Hardcoded!
    ->placeholder('Inserisci nome'); // Hardcoded!
```

#### 5. Mai Creare Services

**Comandamento**: Mai creare Services. Sempre QueueableActions.

**Violazione**: Creare Services è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: QueueableAction
class CreateUserAction
{
    use QueueableAction;
    
    public function execute(array $data): User
    {
        // ...
    }
}

// ❌ ERESIA: Service
class UserService
{
    public function createUser(array $data): User
    {
        // Services sono deprecati!
    }
}
```

#### 6. Mai Usare `property_exists()` nei Modelli

**Comandamento**: Mai usare `property_exists()` per magic attributes Eloquent. Sempre `isset()`.

**Violazione**: Usare `property_exists()` è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: isset() per magic attributes
if (isset($model->extra_field)) {
    // ...
}

// ❌ ERESIA: property_exists() per magic attributes
if (property_exists($model, 'extra_field')) {
    // Non funziona con magic attributes!
}
```

#### 7. Mai Revert Git

**Comandamento**: Mai revert Git. Sempre forward-only.

**Violazione**: Revert Git è eresia.

**Manifestazione**:
```bash
# ✅ CORRETTO: Forward-only
git commit --amend
git rebase

# ❌ ERESIA: Revert
git revert
git checkout old-commit
```

#### 8. PSR-4: Solo `app/` Directory

**Comandamento**: Tutto il codice PHP deve stare in `app/`. Mai in `tests/`, `database/`, `docs/`.

**Violazione**: Codice PHP fuori da `app/` è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO: Codice in app/
Modules/MyModule/app/Models/MyModel.php

// ❌ ERESIA: Codice fuori da app/
Modules/MyModule/tests/MyModel.php // SBAGLIATO!
Modules/MyModule/database/MyModel.php // SBAGLIATO!
```

---

## 🏛️ Politica (Politics)

### Decisioni Architetturali

#### 1. Type Safety First

**Decisione**: PHPStan livello 10 obbligatorio per tutto il codice.

**Motivazione**:
- Type safety garantisce qualità
- Previene bug a runtime
- Migliora manutenibilità
- Facilita refactoring

**Manifestazione**:
- Tutti i metodi hanno return types
- Tutti i parametri hanno type hints
- Nessun `mixed` quando possibile
- PHPDoc completo

#### 2. Consistency Over Flexibility

**Decisione**: Consistency è più importante di flexibility.

**Motivazione**:
- Consistency facilita manutenzione
- Consistency riduce cognitive load
- Consistency migliora onboarding
- Consistency abilita automazione

**Manifestazione**:
- Stessa struttura file in tutti i moduli
- Stessi pattern di ereditarietà
- Stessa filosofia di migrazione
- Stesso comportamento autoloader

#### 3. DRY/KISS Compliance

**Decisione**: DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid) sono obbligatori.

**Motivazione**:
- DRY riduce duplicazione
- KISS migliora leggibilità
- Entrambi riducono bug
- Entrambi migliorano manutenibilità

**Manifestazione**:
- Nessuna duplicazione di codice
- Codice semplice e chiaro
- Refactoring continuo
- Rimozione complessità non necessaria

#### 4. Vendor Package Respect

**Decisione**: Rispettare architettura vendor packages, non forzare pattern Laraxot.

**Motivazione**:
- Vendor packages hanno logica complessa
- Forzare pattern rompe funzionalità
- Estensione diretta mantiene compatibilità
- Traits aggiungono funzionalità senza rompere

**Manifestazione**:
- Permission estende SpatiePermission
- Role estende SpatieRole
- Activity estende Spatie Activity
- Traits aggiungono funzionalità Laraxot

#### 5. Translation-First Approach

**Decisione**: Traduzioni sono sempre prioritarie, mai hardcoded.

**Motivazione**:
- Traduzioni facilitano i18n
- Traduzioni centralizzano labels
- Traduzioni migliorano manutenibilità
- Traduzioni abilitano multi-language

**Manifestazione**:
- LangServiceProvider auto-carica traduzioni
- Mai `->label()` direttamente
- File traduzioni strutturati
- Auto-discovery traduzioni

#### 6. Actions Over Services

**Decisione**: QueueableActions invece di Services.

**Motivazione**:
- Actions sono single-purpose
- Actions sono queueable
- Actions sono testabili
- Actions seguono SOLID

**Manifestazione**:
- Tutte le operazioni business sono Actions
- Actions usano Spatie QueueableActions
- Services sono deprecati
- Migrazione da Services a Actions

### Governance

#### Code Review Rules

1. **Tutte le classi devono estendere XotBase quando disponibile**
2. **Tutti i metodi devono avere return types espliciti**
3. **Tutti i parametri devono avere type hints**
4. **Tutte le traduzioni devono essere in file, mai hardcoded**
5. **Tutte le Actions devono essere queueable quando possibile**

#### Quality Gates

1. **PHPStan Level 10**: Obbligatorio
2. **PHPMD**: Nessun violation critico
3. **PHPInsights**: Score minimo 80
4. **Test Coverage**: Minimo 80%
5. **Documentation**: Completa per tutti i metodi pubblici

---

## 🧘 Zen (Zen)

### Principi Zen di Xot

#### 1. Semplicità nell'Infrastruttura

**Principio**: L'infrastruttura deve essere semplice e trasparente.

**Manifestazione**:
- Auto-discovery automatico
- Configurazione minima
- Convenzioni over configurazione
- Zero boilerplate

**Pratica**:
- Rimuovere configurazione non necessaria
- Auto-discovery quando possibile
- Convenzioni chiare
- Documentazione completa

#### 2. Vuoto nella Complessità

**Principio**: Rimuovere complessità non necessaria.

**Manifestazione**:
- Nessun codice morto
- Nessuna configurazione ridondante
- Nessuna dipendenza non usata
- Nessuna duplicazione

**Pratica**:
- Refactoring continuo
- Rimozione codice non usato
- Consolidamento duplicati
- Audit dipendenze regolari

#### 3. Armonia nell'Architettura

**Principio**: Tutto deve essere in equilibrio architetturale.

**Manifestazione**:
- Bilanciamento tra type safety e semplicità
- Bilanciamento tra consistency e flexibility
- Bilanciamento tra features e stabilità
- Bilanciamento tra performance e manutenibilità

**Pratica**:
- Code review per equilibrio
- Testing per stabilità
- Documentazione per chiarezza
- Performance monitoring

#### 4. Flusso nel Codice

**Principio**: Il codice deve fluire naturalmente.

**Manifestazione**:
- Auto-discovery fluido
- Dependency injection naturale
- Type safety trasparente
- Error handling elegante

**Pratica**:
- Evitare callback complessi
- Usare dependency injection
- Type hints espliciti
- Error handling appropriato

#### 5. Presenza nella Documentazione

**Principio**: Essere presenti nella documentazione, non distratti.

**Manifestazione**:
- Documentazione completa
- Esempi chiari
- Best practices documentate
- Anti-patterns documentati

**Pratica**:
- Documentare tutto
- Aggiornare documentazione
- Esempi pratici
- Guide step-by-step

### Meditazione sul Codice

#### Pratica Quotidiana

1. **Leggere il codice come poesia**
2. **Scrivere il codice come meditazione**
3. **Refactoring come purificazione**
4. **Testing come verifica**

#### Mantra

> "L'infrastruttura semplice è la migliore.  
> Il codice chiaro è il più potente.  
> La documentazione presente è la più utile."

---

## 🎯 Manifestazioni Pratiche

### Esempio: Base Class Pattern

```php
// ✅ CORRETTO: Xot fornisce base class
// Xot
abstract class XotBaseModel extends Model
{
    use HasXotFactory;
    use HasUuid;
}

// Modulo
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'module_name';
}

// Modello specifico
class MyModel extends BaseModel
{
    // Solo logica specifica
}

// ❌ SBAGLIATO: Estende Model direttamente
class MyModel extends Model
{
    // Rompe architettura Laraxot
}
```

### Esempio: Contract Pattern

```php
// ✅ CORRETTO: Contract per type safety
interface UserContract extends Authenticatable
{
    public function getId(): string|int;
    public function getName(): ?string;
}

// Uso
public function createUser(UserContract $user): void
{
    // Type safe
}

// ❌ SBAGLIATO: Type hint concreto
public function createUser(BaseUser $user): void
{
    // Accoppiamento eccessivo
}
```

### Esempio: Auto-Discovery Pattern

```php
// ✅ CORRETTO: Auto-discovery
class XotBaseServiceProvider extends ServiceProvider
{
    protected function registerConfig(): void
    {
        // Auto-discovery config
        $this->mergeConfigFrom(
            $this->modulePath.'/config/config.php',
            $this->name
        );
    }
}

// ❌ SBAGLIATO: Configurazione manuale
class MyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Configurazione manuale ripetuta
        config(['my_module.key' => 'value']);
    }
}
```

### Esempio: Translation-First Pattern

```php
// ✅ CORRETTO: Traduzioni automatiche
TextInput::make('name');
// Traduzione da: Modules/MyModule/lang/it/fields.php
// ['name' => ['label' => 'Nome', 'placeholder' => 'Inserisci nome']]

// ❌ SBAGLIATO: Labels hardcoded
TextInput::make('name')
    ->label('Nome') // Hardcoded!
    ->placeholder('Inserisci nome'); // Hardcoded!
```

---

## 📚 Riferimenti

- [Laraxot Philosophy Summary](laraxot-philosophy-summary.md)
- [Critical Architecture Rules](critical-architecture-rules.md)
- [Consistency Philosophy](laraxot-consistency-philosophy.md)
- [Complete Philosophy Summary](laraxot-complete-philosophy-summary.md)

---

**Filosofia**: Xot non è solo codice - è il fondamento filosofico su cui tutto Laraxot è costruito. Ogni decisione architetturale riflette principi profondi di semplicità, chiarezza, consistency e type safety.

