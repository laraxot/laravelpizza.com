# Common Filament Trait Conflicts - Xot Module

## 📋 Panoramica

Questa documentazione elenca i conflitti comuni che possono verificarsi quando si utilizzano trait di Filament insieme a proprietà personalizzate nelle classi.

**Modulo**: Xot
**Versione Filament**: 4.x
**Versione Laravel**: 12.x
**Data Creazione**: 2025-09-29

## 🎯 Obiettivo

Prevenire errori fatali causati da conflitti di proprietà tra trait di Filament e proprietà personalizzate delle classi.

## 🔴 Trait Problematici e Come Evitarli

### 1. HasFiltersSchema (ChartWidget)

**Location**: `Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema`

**Proprietà Definite**:
```php
public ?array $filters = [];
```

**Conflitto Tipico**:
```php
// ❌ CONFLITTO
class MyPage extends XotBaseViewRecord
{
    use HasFiltersSchema;

    public MyFilterData $filters;  // ERRORE: stesso nome, tipo diverso
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class MyPage extends XotBaseViewRecord
{
    // NON usare HasFiltersSchema se hai bisogno di una proprietà filters custom

    public MyFilterData $filterData;  // Usa un nome diverso

    public function getFilters(): ?array
    {
        return $this->filterData->toArray();
    }
}
```

**Widget Correlati**:
```php
// Widget che consumano i filtri
class MyChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;  // ✅ Trait corretto per i widget

    protected function getData(): array
    {
        $filters = $this->pageFilters;  // Accede ai filtri della pagina parent
        // ...
    }
}
```

---

### 2. HasFiltersForm (Dashboard)

**Location**: `Filament\Pages\Dashboard\Concerns\HasFiltersForm`

**Proprietà Definite**:
```php
public array $filters = [];
```

**Conflitto Tipico**:
```php
// ❌ CONFLITTO
class MyDashboard extends XotBaseDashboard
{
    use HasFiltersForm;

    public FilterObject $filters;  // ERRORE: stesso nome, tipo diverso
}
```

**Soluzione**:
```php
// ✅ CORRETTO - Opzione 1: Non usare proprietà custom
class MyDashboard extends XotBaseDashboard
{
    use HasFiltersForm;  // ✅ Usa la proprietà del trait

    // Implementa filtersForm() per definire i campi
    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date_from'),
            DatePicker::make('date_to'),
        ]);
    }
}

// ✅ CORRETTO - Opzione 2: Usa nome diverso
class MyDashboard extends XotBaseDashboard
{
    public FilterObject $filterData;  // Nome diverso

    public function getFilters(): array
    {
        return $this->filterData->toArray();
    }
}
```

---

### 3. InteractsWithTable (Tables)

**Location**: `Filament\Tables\Concerns\InteractsWithTable`

**Proprietà Definite**:
```php
public ?string $tableSearch = null;
public array $tableSortColumn = [];
public array $tableSortDirection = [];
public array $tableFilters = [];
public array $tableColumnSearches = [];
```

**Conflitto Tipico**:
```php
// ❌ CONFLITTO
class MyPage extends XotBaseViewRecord
{
    use InteractsWithTable;

    public string $tableSearch;  // ERRORE: diverso tipo nullable
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class MyPage extends XotBaseViewRecord
{
    use InteractsWithTable;

    // NON ridefinire proprietà del trait
    // Usa i metodi del trait per interagire con la tabella

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilters());
    }
}
```

---

### 4. HasForms

**Location**: `Filament\Forms\Concerns\HasForms`

**Proprietà Definite**:
```php
// Diverse proprietà interne per gestire i form
```

**Conflitto Tipico**:
```php
// ❌ POTENZIALE CONFLITTO
class MyPage extends XotBaseViewRecord
{
    use HasForms;

    public array $data = [];  // Potrebbe confliggere
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class MyPage extends XotBaseViewRecord
{
    use HasForms;

    public array $customData = [];  // Usa nome specifico

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            // Definisci i campi del form
        ]);
    }
}
```

---

### 5. InteractsWithPageFilters (Widget)

**Location**: `Filament\Widgets\Concerns\InteractsWithPageFilters`

**Proprietà Definite**:
```php
protected array $pageFilters = [];
```

**Conflitto Tipico**:
```php
// ❌ CONFLITTO
class MyWidget extends XotBaseWidget
{
    use InteractsWithPageFilters;

    public array $pageFilters;  // ERRORE: visibilità diversa
}
```

**Soluzione**:
```php
// ✅ CORRETTO
class MyWidget extends XotBaseWidget
{
    use InteractsWithPageFilters;

    // NON ridefinire $pageFilters
    // Accedi tramite $this->pageFilters

    protected function getData(): array
    {
        $filters = $this->pageFilters;  // ✅ Usa la proprietà del trait
        // ...
    }
}
```

---

## 📚 Best Practice Generali

### 1. Controllare i Trait Prima di Usarli

```bash
# Usa IDE per ispezionare i trait
# Oppure leggi il codice sorgente in vendor/filament/
```

### 2. Naming Convention per Evitare Conflitti

```php
// Usa nomi specifici e descrittivi
public MyType $filterData;      // ✅ Specifico
public MyType $customFilters;   // ✅ Prefissato
public MyType $pageFilterData;  // ✅ Contestuale

// Evita nomi generici che potrebbero confliggere
public MyType $filters;         // ⚠️  Potenziale conflitto
public MyType $data;            // ⚠️  Potenziale conflitto
public MyType $state;           // ⚠️  Potenziale conflitto
```

### 3. Type Safety con Data Objects

```php
// ✅ CORRETTO: Usa Spatie Laravel Data
use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public function __construct(
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public ?string $search = null,
    ) {}
}

class MyPage extends XotBaseViewRecord
{
    public FilterData $filterData;  // Type safe, nome univoco
}
```

### 4. Metodi Getter per Esposizione

```php
class MyPage extends XotBaseViewRecord
{
    public FilterData $filterData;

    /**
     * Espone i filtri ai widget in formato array
     */
    public function getFilters(): ?array
    {
        return [
            'date_from' => $this->filterData->dateFrom,
            'date_to' => $this->filterData->dateTo,
            'search' => $this->filterData->search,
        ];
    }
}
```

### 5. Widget che Consumano Filtri dalla Pagina

```php
// Widget
class MyTableWidget extends XotBaseTableWidget
{
    use InteractsWithPageFilters;  // ✅ Trait per accedere ai filtri

    protected function getTableQuery(): Builder
    {
        $filters = $this->pageFilters;  // Array dei filtri dalla pagina parent

        return MyModel::query()
            ->when($filters['date_from'] ?? null, fn($q, $date) =>
                $q->whereDate('created_at', '>=', $date)
            );
    }
}
```

---

## 🔍 Checklist Pre-Implementazione

Prima di aggiungere trait di Filament a una classe, verifica:

- [ ] Quali proprietà definisce il trait
- [ ] Se la tua classe ha proprietà con gli stessi nomi
- [ ] Se i tipi sono compatibili (nullable, array, object)
- [ ] Se la visibilità è corretta (public, protected, private)
- [ ] Se esiste un metodo getter alternativo
- [ ] Se puoi usare un nome diverso per la proprietà

---

## 🛠️ Debugging Trait Conflicts

### Metodo 1: Ispezionare il Trait

```bash
# Leggi il codice del trait
cat vendor/filament/widgets/src/ChartWidget/Concerns/HasFiltersSchema.php
```

### Metodo 2: IDE Inspection

```php
// Hover sul trait nel tuo IDE per vedere le proprietà
use HasFiltersSchema;  // ← Ctrl+Click or Cmd+Click
```

### Metodo 3: PHP Reflection

```php
use ReflectionClass;

$reflection = new ReflectionClass(HasFiltersSchema::class);
$properties = $reflection->getProperties();

foreach ($properties as $property) {
    echo $property->getName() . ' => ' . $property->getType() . PHP_EOL;
}
```

---

## 📖 Casi Reali Risolti

### Caso 1: ViewQuestionChart - HasFiltersSchema Conflict

**Problema**: Conflitto tra `public QuestionChartFilterData $filters` e trait `HasFiltersSchema`

**Soluzione**: Rinominato in `$filterData` e rimosso il trait

**File**: `/Modules/Quaeris/docs/PROPERTY_CONFLICT_RESOLUTION_FILAMENT_TRAITS.md`

---

## 🎯 Pattern Raccomandati

### Pattern 1: Pagina con Filtri per Widget

```php
// Pagina
class ViewRecord extends XotBaseViewRecord
{
    public FilterData $filterData;  // ✅ Nome univoco

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->filterData = new FilterData(...);
    }

    public function getFilters(): ?array
    {
        return $this->filterData->toArray();
    }

    protected function getHeaderWidgets(): array
    {
        return [MyWidget::class];
    }
}

// Widget
class MyWidget extends ChartWidget
{
    use InteractsWithPageFilters;  // ✅ Accede ai filtri

    protected function getData(): array
    {
        $filters = $this->pageFilters;
        // Usa i filtri...
    }
}
```

### Pattern 2: Dashboard con Filtri

```php
class MyDashboard extends XotBaseDashboard
{
    use HasFiltersForm;  // ✅ Usa il trait di Filament

    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date_from'),
            DatePicker::make('date_to'),
            Select::make('status'),
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MyStatsWidget::class,
            MyChartWidget::class,
        ];
    }
}
```

---

## ⚠️ Anti-Patterns da Evitare

### Anti-Pattern 1: Proprietà con Stesso Nome del Trait

```php
// ❌ NON FARE
class MyPage extends XotBaseViewRecord
{
    use HasFiltersSchema;

    public MyType $filters;  // CONFLITTO!
}
```

### Anti-Pattern 2: Ridefininizione di Proprietà del Trait

```php
// ❌ NON FARE
class MyWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected array $pageFilters = [];  // CONFLITTO! Già definita dal trait
}
```

### Anti-Pattern 3: Modifica Visibilità

```php
// ❌ NON FARE
class MyPage extends XotBaseViewRecord
{
    use SomeTrait;  // Definisce: protected $data

    public array $data;  // CONFLITTO! Visibilità diversa
}
```

---

## ✅ Conclusioni

- **Sempre verificare** i trait prima di usarli
- **Usare nomi univoci** per le proprietà personalizzate
- **Preferire Data Objects** per filtri complessi
- **Documentare** le scelte architetturali
- **Testare** dopo ogni modifica

---

**Autore**: Claude Code
**Versione**: 1.0
**Ultimo Aggiornamento**: 2025-09-29

## 📎 Riferimenti

- [Filament 4 Documentation](https://filamentphp.com/docs)
- [Laravel Traits](https://www.php.net/manual/en/language.oop5.traits.php)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)
- `/Modules/Xot/docs/FILAMENT_4_LARAXOT_RULES.md`
- `/Modules/Quaeris/docs/PROPERTY_CONFLICT_RESOLUTION_FILAMENT_TRAITS.md`