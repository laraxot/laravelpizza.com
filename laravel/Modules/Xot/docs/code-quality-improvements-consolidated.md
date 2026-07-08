# Code Quality Improvements - Documento Consolidato

**Data creazione**: 2025-01-22
**Filosofia**: Super Mucca + DRY + KISS + Type Safety
**Obiettivo**: Miglioramento continuo qualità codice basato su best practices 2024-2025

---

## 📊 Analisi Stato Attuale

### File con Nomi Non Conformi
Trovati **30+ file .md** con nomi che violano le regole:
- Date nei nomi: `phpstan-fixes-january-2025.md`, `roadmap-2025.md`
- Maiuscole: `ROADMAP_2026.md`, `FILAMENT_4_LARAXOT_RULES.md`
- Underscore maiuscole: `TRAIT_METHOD_SIGNATURE_RULES.md`

**Azione richiesta**: Rinominare tutti i file seguendo convenzioni (minuscolo, no date, solo README.md/CHANGELOG.md possono avere maiuscole).

### Uso di `mixed` nel Codice
Trovati **1155 usi di `mixed`** in 394 file PHP.

**Analisi**:
- Molti sono necessari (API responses, configurazioni dinamiche)
- Alcuni possono essere sostituiti con union types o generics
- Target: Ridurre del 30% gli usi non necessari di `mixed`

### Array con Chiavi Numeriche
Trovati **121 usi di `array<int, ...>`** in 98 file.

**Problema**: Filament richiede `array<string, ...>` per metodi come `getTableActions()`, `getFormSchema()`, ecc.

**Azione richiesta**: Convertire tutti gli array numerici in associativi con chiavi string per metodi Filament.

---

## 🎯 Miglioramenti Identificati da Best Practices 2024-2025

### 1. PHPStan Level 10 - Best Practices Aggiornate

#### Pattern Type Narrowing Migliorato
```php
// ❌ Vecchio pattern
/** @var mixed $value */
$value = $data['key'];
if (is_string($value)) {
    // ...
}

// ✅ Nuovo pattern (PHP 8.3 + PHPStan L10)
use Webmozart\Assert\Assert;

Assert::keyExists($data, 'key');
Assert::string($data['key']);
// PHPStan ora sa che $data['key'] è string
$value = $data['key'];
```

#### Generics per Collections Eloquent
```php
// ✅ Pattern ottimizzato per relazioni
/**
 * @return MorphMany<StoredEvent>
 */
public function storedEvents(): MorphMany
{
    return $this->morphMany(StoredEvent::class, 'aggregate');
}
```

### 2. PHPMD - Regole Aggiornate 2024

#### Complexity Target Ridotto
- **Cyclomatic Complexity**: < 8 (prima era < 10)
- **NPath Complexity**: < 150 (prima era < 200)
- **Method Length**: < 15 righe (prima era < 20)

#### Nuove Regole da Applicare
```xml
<!-- phpmd.ruleset.xml -->
<ruleset>
    <rule ref="rulesets/codesize.xml/TooManyPublicMethods">
        <properties>
            <property name="maxmethods" value="10"/>
        </properties>
    </rule>
    <rule ref="rulesets/design.xml/TooManyDependencies">
        <properties>
            <property name="threshold" value="5"/>
        </properties>
    </rule>
</ruleset>
```

### 3. PHPInsights - Configurazione Ottimizzata

#### Threshold Aggiornati
```php
// config/insights.php
return [
    'min_quality' => 90,        // Era 80
    'min_complexity' => 90,     // Era 70
    'min_architecture' => 90,  // Era 80
    'min_style' => 95,          // Era 80
];
```

#### Nuove Insight da Abilitare
- **ForbiddenPublicProperty**: Evita proprietà pubbliche
- **ForbiddenNormalClasses**: Preferisci final classes
- **ForbiddenTraits**: Limita uso di trait (max 2 per classe)

### 4. Pest - Best Practices 2024

#### Test Structure Migliorata
```php
// ✅ Nuovo pattern Pest
describe('Event Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    });

    it('can create an event', function () {
        $event = Event::factory()->make();

        $response = $this->post(route('events.store'), $event->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('events', ['title' => $event->title]);
    });
});
```

#### Coverage Target
- **Unit Tests**: > 80% coverage
- **Feature Tests**: > 70% coverage
- **Integration Tests**: > 60% coverage

### 5. Filament 4 - Best Practices Aggiornate

#### Schema Components (Filament 4)
```php
// ✅ Nuovo pattern Filament 4
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

public static function getFormSchema(): array
{
    return [
        'details' => Section::make('Details')
            ->schema([
                'title' => TextInput::make('title')->required(),
                'description' => Textarea::make('description'),
            ])
            ->columns(2),
    ];
}
```

#### Array Keys Sempre String
```php
// ✅ OBBLIGATORIO: chiavi string
/**
 * @return array<string, Action>
 */
protected function getHeaderActions(): array
{
    return [
        'create' => CreateAction::make(),
        'export' => ExportAction::make(),
    ];
}
```

### 6. Laravel 12 - Nuove Features da Usare

#### Model Events con Type Hints
```php
// ✅ Laravel 12 pattern
protected static function booted(): void
{
    static::creating(function (Event $event): void {
        $event->created_by = auth()->id();
    });
}
```

#### Query Builder Type Safety
```php
// ✅ Pattern ottimizzato
/** @var \Illuminate\Database\Eloquent\Builder<Event> $query */
$query = Event::query()
    ->where('status', 'published')
    ->whereDate('start_date', '>=', now());
```

---

## 🔧 Pattern di Miglioramento Specifici

### Pattern 1: Eliminare `mixed` con Union Types
```php
// ❌ Prima
/**
 * @param mixed $value
 */
public function process($value): void
{
    // ...
}

// ✅ Dopo
/**
 * @param string|int|float|null $value
 */
public function process(string|int|float|null $value): void
{
    // ...
}
```

### Pattern 2: Convertire Array Numerici in Associativi
```php
// ❌ Prima (Filament)
public function getTableActions(): array
{
    return [
        EditAction::make(),
        DeleteAction::make(),
    ];
}

// ✅ Dopo
/**
 * @return array<string, Action>
 */
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### Pattern 3: Type Narrowing con Assert
```php
// ❌ Prima
public function process(array $data): Result
{
    if (!isset($data['email']) || !is_string($data['email'])) {
        throw new InvalidArgumentException('Email required');
    }
    // ...
}

// ✅ Dopo
use Webmozart\Assert\Assert;

public function process(array $data): Result
{
    Assert::keyExists($data, 'email');
    Assert::string($data['email']);
    // PHPStan sa che $data['email'] è string
    $email = $data['email'];
    // ...
}
```

### Pattern 4: Safe Functions per File Operations
```php
// ❌ Prima
$content = file_get_contents($path);
if ($content === false) {
    throw new Exception('File not found');
}

// ✅ Dopo
use function Safe\file_get_contents;

$content = file_get_contents($path); // Lancia eccezione se fallisce
```

---

## 📋 Checklist Miglioramenti

### Priorità Alta
- [ ] Rinominare tutti i file .md con nomi non conformi
- [ ] Convertire `array<int, ...>` in `array<string, ...>` per metodi Filament
- [ ] Aggiungere generics alle relazioni Eloquent (`MorphMany<Model>`)
- [ ] Ridurre uso di `mixed` del 30% sostituendo con union types

### Priorità Media
- [ ] Aggiornare threshold PHPMD (complexity < 8, method length < 15)
- [ ] Configurare PHPInsights con threshold più alti (min_quality 90)
- [ ] Aggiungere Safe functions per tutte le file operations
- [ ] Implementare Webmozart Assert per input validation

### Priorità Bassa
- [ ] Migliorare coverage test (unit > 80%, feature > 70%)
- [ ] Aggiungere test Pest per tutti i moduli
- [ ] Documentare pattern comuni in ogni modulo
- [ ] Creare template per nuovi moduli con best practices

---

## 🔗 Risorse Studiate

### Documentazione Ufficiale
- [PHPStan](https://phpstan.org/) - Static analysis
- [PHPMD](https://phpmd.org/) - Mess detector
- [PHPInsights](https://phpinsights.com/) - Code quality
- [Pest](https://pestphp.com/) - Testing framework
- [Filament](https://filamentphp.com/docs) - Admin panel
- [Laravel Modules](https://laravelmodules.com/) - Modular architecture
- [Laravel 12](https://laravel.com/docs/12.x) - Framework docs

### Blog e Risorse
- [Laravel News](https://laravel-news.com/) - News e tutorial
- [Laravel Daily](https://laraveldaily.com/) - Daily tips
- [Beyond CRUD](https://beyond-crud.stitcher.io/) - Architecture patterns
- [Dev.to Laravel](https://dev.to/t/laravel) - Community articles

### Schema.org
- [Schema.org](https://schema.org/) - Structured data (per SEO e semantic web)

---

## 📝 Note Finali

### Filosofia Super Mucca
- **Analisi profonda** prima di ogni modifica
- **Docs come memoria** - aggiornare sempre
- **DRY + KISS** - non duplicare, non complicare
- **Type safety** - zero tolerance per `mixed` non necessario
- **Quality first** - PHPStan L10, PHPMD, PHPInsights sempre

### Workflow Consigliato
1. Studiare docs del modulo
2. Analizzare codice esistente
3. Identificare pattern da migliorare
4. Implementare miglioramenti
5. Verificare con tutti i tool (PHPStan, PHPMD, PHPInsights)
6. Aggiornare docs con pattern applicati

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: In progress
