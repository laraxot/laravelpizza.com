# Best Practices - Modulo IndennitaResponsabilita

**Versione**: 1.0  
**Data**: 2025-01-02  
**Maintainer**: Development Team

---

## 📋 Indice

1. [Architettura e Pattern](#architettura-e-pattern)
2. [Coding Standards](#coding-standards)
3. [Database e Model](#database-e-model)
4. [Filament Components](#filament-components)
5. [Testing](#testing)
6. [Performance](#performance)
7. [Security](#security)
8. [Documentation](#documentation)

---

## 🏗️ Architettura e Pattern

### Service Layer

**✅ DO**: Usare servizi per logica business complessa

```php
// ✅ CORRETTO
namespace Modules\IndennitaResponsabilita\Services;

class IndennitaCalculationService
{
    public function calculateTotaleRatings(Collection $ratings, array $formData): int
    {
        return $ratings
            ->where('is_disabled', '!=', true)
            ->where('is_readonly', '!=', true)
            ->reduce(/* logica calcolo */, 0);
    }
}
```

**❌ DON'T**: Mettere business logic nei controller/page

```php
// ❌ ERRATO
class CompilaPage extends XotBasePage
{
    protected function getViewData(): array
    {
        // 100 linee di calcoli complessi
        $tot = 0;
        foreach($ratings as $rating) {
            // calcoli manuali...
        }
    }
}
```

---

### Data Transfer Objects

**✅ DO**: Usare Spatie Laravel Data per DTO

```php
// ✅ CORRETTO
use Spatie\LaravelData\Data;

class IndennitaCompilazioneData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly Carbon $dal,
        public readonly Carbon $al,
        public readonly array $ratings,
    ) {}
    
    public static function fromModel(IndennitaResponsabilita $model): self
    {
        return new self(/* mapping */);
    }
}
```

**❌ DON'T**: Passare array non tipizzati

```php
// ❌ ERRATO
public array $form_data = []; // tipo mixed, nessuna validazione
```

---

### Actions

**✅ DO**: Usare Spatie QueueableActions per operazioni

```php
// ✅ CORRETTO
use Spatie\QueueableAction\QueueableAction;

class SaveIndennitaCompilazioneAction
{
    use QueueableAction;
    
    public function execute(IndennitaCompilazioneData $data): IndennitaResponsabilita
    {
        // Logica di salvataggio
    }
}
```

**❌ DON'T**: Implementare operazioni complesse inline

```php
// ❌ ERRATO
public function save(): void
{
    // 80 linee di logica complessa qui
}
```

---

## 📝 Coding Standards

### Type Declarations

**✅ DO**: Type hints completi

```php
// ✅ CORRETTO
declare(strict_types=1);

class IndennitaCalculationService
{
    public function calculateImportoMensile(int $totale): int
    {
        return $totale * 10;
    }
}
```

**❌ DON'T**: Omettere type hints

```php
// ❌ ERRATO
public function calculate($value) // Nessun tipo
{
    return $value * 10; // Tipo di ritorno non dichiarato
}
```

---

### PHPDoc

**✅ DO**: PHPDoc completi per array e collections

```php
// ✅ CORRETTO
/**
 * Get ratings for calculation.
 *
 * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\Rating\Models\Rating>
 */
protected function getRatingsForCalculation(): Collection
{
    // ...
}
```

**❌ DON'T**: PHPDoc generico o mancante

```php
// ❌ ERRATO
protected function getRatingsForCalculation() // Nessun PHPDoc
{
    // ...
}
```

---

### Naming Conventions

**✅ DO**: Nomi descrittivi in inglese

```php
// ✅ CORRETTO
public function calculateImportoMensileAttribuito(
    int $importoMensile,
    float $percPartTime
): float {
    // ...
}
```

**❌ DON'T**: Nomi abbreviati o poco chiari

```php
// ❌ ERRATO
public function calcImp($imp, $perc) // Poco chiaro
{
    // ...
}
```

---

### Method Length

**✅ DO**: Metodi corti (<40 linee)

```php
// ✅ CORRETTO
protected function getViewData(): array
{
    $this->calculateTotaleRatings();
    $this->calculateImportoMensile();
    $this->calculateImportoAttribuito();
    
    return [];
}

private function calculateTotaleRatings(): void
{
    // 10-15 linee di logica
}
```

**❌ DON'T**: Metodi lunghi (>50 linee)

```php
// ❌ ERRATO
protected function getViewData(): array
{
    // 100+ linee di codice complesso
}
```

---

## 💾 Database e Model

### Casts

**✅ DO**: Metodo `casts()` per Laravel 11+

```php
// ✅ CORRETTO
protected function casts(): array
{
    return [
        'id' => 'integer',
        'anno' => 'integer',
        'dal' => 'date',
        'al' => 'date',
        'created_at' => 'datetime',
    ];
}
```

**❌ DON'T**: Property `$casts` (deprecata)

```php
// ❌ ERRATO
protected $casts = [
    'dal' => 'date',
];
```

---

### Fillable Annotation

**✅ DO**: Annotazione per PHPStan

```php
// ✅ CORRETTO
/**
 * @var list<string>
 */
protected $fillable = [
    'id',
    'ente',
    'matr',
];
```

**❌ DON'T**: Nessuna annotazione

```php
// ❌ ERRATO
protected $fillable = ['id', 'ente', 'matr']; // PHPStan error
```

---

### Relationships

**✅ DO**: Type hints nelle relazioni

```php
// ✅ CORRETTO
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\Sigma\Models\Anag, $this>
 */
public function anag(): BelongsTo
{
    return $this->belongsTo(Anag::class, 'matr', 'matr')
        ->where('ente', $this->getAttribute('ente'));
}
```

**❌ DON'T**: Relazioni senza type hints

```php
// ❌ ERRATO
public function anag() // Nessun tipo
{
    return $this->belongsTo(Anag::class);
}
```

---

## 🎨 Filament Components

### Traduzioni

**✅ DO**: Solo traduzioni automatiche

```php
// ✅ CORRETTO - Nel Form
TextInput::make('nome')
    ->required();

// ✅ CORRETTO - Nella View Blade
{{ __('indennitaresponsabilita::fields.nome.label') }}
```

**❌ DON'T**: Label hardcoded

```php
// ❌ ERRATO
TextInput::make('nome')
    ->label('Nome') // VIETATO
    ->placeholder('Inserisci nome'); // VIETATO
```

---

### Custom Pages

**✅ DO**: Estendere XotBasePage

```php
// ✅ CORRETTO
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class CompilaIndennitaResponsabilita extends XotBasePage
{
    // Implementation
}
```

**❌ DON'T**: Estendere direttamente Filament Page

```php
// ❌ ERRATO
use Filament\Pages\Page;

class CompilaIndennitaResponsabilita extends Page
{
    // Implementation
}
```

---

### View Components

**✅ DO**: Usare componenti Filament

```blade
{{-- ✅ CORRETTO --}}
<x-filament::page>
    <x-filament::card>
        <x-filament::input
            type="number"
            wire:model.live="form_data.value"
        />
    </x-filament::card>
</x-filament::page>
```

**❌ DON'T**: HTML nativo mixed con Filament

```blade
{{-- ❌ ERRATO --}}
<div>
    <input type="number" wire:model="value" />
</div>
```

---

## 🧪 Testing

### Unit Tests

**✅ DO**: Test per ogni servizio

```php
// ✅ CORRETTO
class IndennitaCalculationServiceTest extends TestCase
{
    /** @test */
    public function it_calculates_totale_correctly(): void
    {
        // Arrange
        $service = new IndennitaCalculationService();
        $ratings = collect([/* data */]);
        
        // Act
        $result = $service->calculateTotaleRatings($ratings, []);
        
        // Assert
        $this->assertEquals(expected, $result);
    }
}
```

**❌ DON'T**: Nessun test o test incompleti

```php
// ❌ ERRATO
// Nessun test per servizi critici
```

---

### Feature Tests

**✅ DO**: Test per flow completi

```php
// ✅ CORRETTO
/** @test */
public function it_saves_indennita_compilazione_successfully(): void
{
    // Arrange
    $user = User::factory()->create();
    $record = IndennitaResponsabilita::factory()->create();
    
    // Act
    $this->actingAs($user)
        ->post(route('...'), $data);
    
    // Assert
    $this->assertDatabaseHas('indennita_responsabilita', [
        'id' => $record->id,
        'dal' => $data['dal'],
    ]);
}
```

---

### Test Coverage

**✅ DO**: Mantenere coverage >85%

```bash
# Verifica coverage
php artisan test --coverage --min=85
```

**❌ DON'T**: Ignorare test coverage

---

## ⚡ Performance

### Query Optimization

**✅ DO**: Eager loading

```php
// ✅ CORRETTO
$records = IndennitaResponsabilita::with(['anag', 'ratings'])
    ->get();
```

**❌ DON'T**: N+1 queries

```php
// ❌ ERRATO
$records = IndennitaResponsabilita::all();
foreach ($records as $record) {
    $anag = $record->anag; // N+1 problem
}
```

---

### Caching

**✅ DO**: Cache dati statici

```php
// ✅ CORRETTO
public function getRatingsForYear(int $anno): Collection
{
    return Cache::remember(
        "ratings_anno_{$anno}",
        3600,
        fn() => Rating::withExtraAttributes('anno', $anno)->get()
    );
}
```

**❌ DON'T**: Query pesanti senza cache

---

### Chunking

**✅ DO**: Chunk per operazioni su molti record

```php
// ✅ CORRETTO
IndennitaResponsabilita::chunk(100, function ($records) {
    foreach ($records as $record) {
        // Process
    }
});
```

---

## 🔒 Security

### Input Validation

**✅ DO**: Validazione con DTO

```php
// ✅ CORRETTO
class IndennitaCompilazioneData extends Data
{
    public function __construct(
        #[Required, IntegerType, Min(1)]
        public readonly int $id,
        
        #[Required, Date, After('today')]
        public readonly Carbon $dal,
    ) {}
}
```

**❌ DON'T**: Nessuna validazione

---

### Authorization

**✅ DO**: Policy e Gates

```php
// ✅ CORRETTO
private function authorizeAccess(): void
{
    if (! Gate::allows('compila', $this->record)) {
        abort(403);
    }
}
```

**❌ DON'T**: Accesso non controllato

---

### XSS Prevention

**✅ DO**: Escape output

```blade
{{-- ✅ CORRETTO --}}
<div>{{ $record->nome }}</div>

{{-- Solo quando HTML è sicuro e validato --}}
<div>{!! $record->safe_html !!}</div>
```

**❌ DON'T**: Output non escaped

```blade
{{-- ❌ ERRATO --}}
<div>{!! $user_input !!}</div>
```

---

## 📚 Documentation

### Code Comments

**✅ DO**: PHPDoc completi

```php
// ✅ CORRETTO
/**
 * Calculate total ratings excluding disabled and readonly items.
 *
 * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\Rating\Models\Rating> $ratings
 * @param array<string, mixed> $formData
 *
 * @return int The calculated total
 *
 * @throws \Modules\IndennitaResponsabilita\Exceptions\RatingNotFoundException
 */
public function calculateTotaleRatings(Collection $ratings, array $formData): int
{
    // Implementation
}
```

---

### README Updates

**✅ DO**: Mantenere README aggiornato

- Ogni nuova feature documentata
- API changes documented
- Breaking changes highlighted
- Migration guides provided

---

### Changelog

**✅ DO**: Mantenere CHANGELOG.md

```markdown
## [Unreleased]

### Added
- New calculation service for indennita
- Data transfer objects for type safety

### Changed
- Refactored CompilaIndennitaResponsabilita page
- Updated translation files

### Fixed
- Fixed N+1 query problem in ratings
- Fixed type juggling issues
```

---

## 🔗 Collegamenti

### Documentazione Correlata
- [Code Quality Analysis](./code-quality-analysis.md)
- [Refactoring Action Plan](./refactoring-action-plan.md)
- [Laraxot Best Practices](../../Xot/docs/BEST_PRACTICES.md)

### Standard Esterni
- [PSR-12: Extended Coding Style Guide](https://www.php-fig.org/psr/psr-12/)
- [PHPStan Rules](https://phpstan.org/user-guide/rule-levels)
- [Laravel Best Practices](https://laravel.com/docs/11.x)

---

## ✅ Checklist Rapida

### Prima di ogni Commit

- [ ] `declare(strict_types=1);` presente
- [ ] Type hints completi
- [ ] PHPDoc completi
- [ ] PHPStan Level 10 passa (0 errori)
- [ ] Tests passano con coverage >85%
- [ ] Pint formattazione corretta
- [ ] Nessuna stringa hardcoded
- [ ] Nessun debug code (dddx, var_dump)

### Prima di ogni PR

- [ ] Documentation aggiornata
- [ ] CHANGELOG aggiornato
- [ ] Tests di regressione passano
- [ ] Code review self-check completato
- [ ] Performance non degradata
- [ ] Security check passato

---

**Ultima Revisione**: 2025-01-02  
**Prossima Revisione**: Trimestrale


