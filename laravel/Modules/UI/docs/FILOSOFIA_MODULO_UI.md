# Analisi Approfondita del Modulo UI

> **Generato**: 2025-12-24
> **Scopo**: Documentare la filosofia, logica, business logic e architettura del modulo UI

---

## 1. LOGICA - Come Funziona il Modulo UI

### Architettura Componenti Custom Filament

Il modulo UI è **il layer di estensione e personalizzazione di Filament v4**, strutturato su tre pilastri:

**A) Custom Filament Components (56 file PHP)**
```
app/Filament/
├── Tables/Columns/        # 8 colonne custom (IconStateColumn, GroupColumn, etc.)
├── Forms/Components/      # 15 form fields custom (InlineDatePicker, RadioBadge, LocationSelector)
├── Widgets/              # 11 widgets (StatsOverviewWidget, UserCalendarWidget, DarkModeSwitcherWidget)
├── Blocks/               # 14 blocchi CMS (Hero, Heading, Paragraph, Image, Video, etc.)
└── Actions/              # 2 azioni (TableLayoutToggleHeaderAction, TableLayoutToggleTableAction)
```

**B) Blade View Components (11+ file PHP)**
```
app/View/Components/
├── Blocks/Hero/Simple.php
├── Render/Block.php, Blocks.php
├── Navbar.php, Sidebar.php, Logo.php, Svg.php
└── DarkModeSwitcher.php, BreadLink.php, Std.php
```

**C) Sistema di Enums & Traits**
- `TableLayoutEnum` - Gestione layout LIST/GRID con traduzioni automatiche
- `TableLayoutTrait` - Session persistence per scelta layout utente
- `TransTrait` - Traduzioni automatiche via `transClass()`

### Pattern di Estensione

**Estende Filament, NON lo sostituisce:**

```php
// IconStateColumn estende IconColumn (Filament)
class IconStateColumn extends IconColumn {
    // Aggiunge integrazione con Spatie ModelStates
    // Aggiunge modal per transizioni di stato
    // Mantiene 100% compatibilità Filament
}

// InlineDatePicker estende DatePicker (Filament)
class InlineDatePicker extends DatePicker {
    // Aggiunge calendario inline sempre visibile
    // Aggiunge date selettive con enabledDates()
    // Aggiunge localizzazione Carbon automatica
}

// RadioBadge estende Radio (Filament)
class RadioBadge extends Radio {
    // Aggiunge badge colorati per opzioni
    // Integra HasColor/HasIcon da enum
    // Mantiene validazione Filament
}
```

**NO UIBase - Usa XotBase:**

Il modulo UI **NON** ha classi UIBase. Tutti i componenti:
- Estendono direttamente classi Filament native (Column, Field, Widget, Block)
- **OPPURE** estendono classi XotBase del modulo Xot (XotBaseWidget, XotBaseColumn, XotBasePage, ecc.)

Questo è intenzionale: UI è un **consumer** di Xot, non un base layer.

---

## 2. FILOSOFIA - Principi di Design UI/UX ed Estensibilità

### Principi Core

**A) Riusabilità Senza Duplicazione (DRY)**

Ogni componente è progettato per essere riutilizzato in più moduli senza duplicazione:

```php
// InlineDatePicker - Usato in TechPlanner, Employee, Cms
// LocationSelector - Usato in TechPlanner, Employee, Geo
// IconStateColumn - Usato in tutti i moduli con Spatie ModelStates
// RadioCollection - Usato per selezioni complesse multimodulo
```

**B) KISS - Keep It Simple, Stupid**

I componenti seguono il principio KISS:

```php
// InlineDatePicker - Codice documentato come esempio:
/**
 * Principi:
 * - DRY: Don't Repeat Yourself - Codice senza duplicazioni
 * - KISS: Keep It Simple, Stupid - Semplicità sopra tutto
 * - Carbon First: Localizzazione automatica tramite Carbon
 * - Design One Theme: UI/UX conforme al tema standard
 */
```

**C) Estensibilità per Composizione**

Componenti sono estensibili tramite composizione, non ereditarietà multipla:

```php
// TableLayoutEnum - Composizione di interfacce
enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;  // Composizione via trait

    case LIST = 'list';
    case GRID = 'grid';

    // Metodi specifici per layout
    public function getTableContentGrid(): ?array { ... }
    public function toggle(): self { ... }
}
```

**D) Auto-Discovery e Convention Over Configuration**

Il modulo preferisce auto-discovery a configurazione esplicita:

```php
// UIServiceProvider estende XotBaseServiceProvider
class UIServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'UI';

    // Componenti Blade auto-scoperti da directory
    public function getComponentViewPath(): string
    {
        return app(GetModulePathByGeneratorAction::class)
            ->execute($this->name, 'component-view');
    }
}
```

---

## 3. BUSINESS LOGIC - Componenti Forniti

### Categorie Componenti

**A) Table Columns (8 componenti)**

| Componente | Scopo Business | Pattern Utilizzato |
|------------|----------------|-------------------|
| `IconStateColumn` | Visualizza e transiziona stati (Spatie ModelStates) | State Machine + Modal Action |
| `IconStateSplitColumn` | Stati split in due colonne (stato corrente + prossimo) | Complex State Transition |
| `SelectStateColumn` | Transizione stati via dropdown | Inline State Selection |
| `IconStateGroupColumn` | Raggruppa più stati in column group | State Aggregation |
| `GroupColumn` | Raggruppa più colonne logicamente | Logical Grouping |
| `TreeColumn` | Visualizza dati gerarchici (nested sets) | Tree Navigation |
| `IconColumn` | Icone custom estendibili | Icon Display |
| `DummyActionsColumn` | Placeholder per azioni | Placeholder Pattern |

**B) Form Components (15 componenti)**

| Componente | Scopo Business | Use Case |
|------------|----------------|----------|
| `InlineDatePicker` | Selezione date con calendario inline | Appuntamenti, prenotazioni, scadenze |
| `RadioBadge` | Radio con badge colorati (enum HasColor) | Stato, priorità, categoria |
| `RadioCollection` | Radio con item custom (template personalizzabile) | Selezione studi medici, sedi, prodotti |
| `RadioIcon` | Radio con icone | Scelta icona, tipo attività |
| `RadioImage` | Radio con immagini | Selezione tema, layout, prodotto |
| `LocationSelector` | Geolocation (Regione → Provincia → CAP) | Indirizzi, sedi, clienti |
| `OpeningHoursField` | Orari apertura business (mattina/pomeriggio) | Studi, negozi, uffici |
| `IconPicker` | Selezione icona da pack | Personalizzazione UI |
| `AddressField` | Indirizzo completo strutturato | Indirizzi clienti, sedi |
| `TreeField` | Selezione gerarchica | Categorie, organizzazione |
| `SelectState` | Select per transizioni stato | Workflow management |
| `PasswordStrengthField` | Password con strength indicator | Sicurezza account |
| `QrReader` | Lettura QR code | Check-in, inventario |
| `ParentSelect` | Select parent per alberi | Categorie, organizzazione |
| `Children` | Gestione figli (nested) | Relazioni parent-child |

**C) Widgets (11 componenti)**

| Widget | Scopo Business |
|--------|----------------|
| `StatsOverviewWidget` | Dashboard statistiche overview |
| `HeroWidget` | Banner hero homepage |
| `UserCalendarWidget` | Calendario eventi utente |
| `DarkModeSwitcherWidget` | Toggle tema chiaro/scuro |
| `RowWidget` | Layout helper per righe |
| `GroupWidget` | Raggruppamento widget |
| `OverlookWidget` | Panoramica dati |
| `RedirectWidget` | Redirect automatico |
| `TestWidget`, `TestChartWidget` | Testing e sviluppo |
| `StatWithIconWidget` | Stat singola con icona |

**D) Blocks CMS (14 componenti)**

Sistema per composizione pagine dinamiche:

```
Hero, Heading, Paragraph, Image, VideoSpatie, Slider, Contact,
Category, Navigation, Post, Page, ImagesGallery, Title, + altri
```

Utilizzati dal modulo Cms per costruire pagine senza hard-coding HTML.

---

## 4. POLITICA - Regole per Naming, Convenzioni Blade/Livewire

### Regole Critiche

**A) MAI usare `->label()` - SEMPRE traduzioni automatiche**

Questa è la **regola religiosa più importante** del modulo:

```php
// ❌ GRAVEMENTE ERRATO - NON FARE MAI QUESTO
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')

// ✅ CORRETTO - Traduzioni automatiche da lang/
TextColumn::make('name')  // Traduzione: ui::fields.name.label
Action::make('save')      // Traduzione: ui::actions.save.label
```

**Perché:**
- Sistema traduzioni automatico del `LangServiceProvider`
- Centralizzazione in file `lang/`
- Type safety e controllo PHPStan
- Performance ottimizzata

**B) Struttura Traduzioni Espansa**

Ogni campo deve avere struttura completa:

```php
// lang/it/fields.php
'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci nome',
    'tooltip' => 'Nome completo dell\'utente',
    'helper_text' => 'Nome e cognome dell\'utente',
],
```

**C) MAI `property_exists()` con Eloquent - SEMPRE `isset()`**

```php
// ❌ GRAVEMENTE ERRATO
if (property_exists($model, 'email')) { ... }

// ✅ CORRETTO - isset() rispetta __isset() magico
if (isset($model->email)) { ... }
```

**D) Naming Conventions**

- **Componenti Blade**: `kebab-case` (es. `inline-date-picker`)
- **Classi PHP**: `PascalCase` (es. `InlineDatePicker`)
- **Views**: `kebab-case` (es. `filament/forms/components/inline-date-picker.blade.php`)
- **Props componenti**: `camelCase` con type hints

**E) Case-Sensitive File Naming**

**CRITICO**: Mai creare file che differiscono solo per case:

```
❌ ERRATO - Conflitto cross-filesystem
TimeclockWidget.php
TimeClockWidget.php

✅ CORRETTO - Consistente PascalCase
TimeClockWidget.php  # Solo questo
```

### Convenzioni Blade/Livewire

**Slots Nominati:**
```blade
<x-ui.component>
    <x-slot:header>...</x-slot>
    <x-slot:footer>...</x-slot>
    {{ $slot }}  <!-- Contenuto principale -->
</x-ui.component>
```

**Props Tipizzate:**
```php
class CustomComponent extends Component
{
    public function __construct(
        public readonly string $label,
        public readonly ?string $hint = null,
        public readonly bool $required = false,
    ) {}
}
```

---

## 5. RELIGIONE - Dogmi (Mai label, Sempre traduzioni, UIBase vs XotBase)

### Dogmi Inviolabili

**A) DOGMA #1: Mai usare `->label()`, SEMPRE traduzioni**

Questo è il **dogma religioso centrale**:

- **Pentimento**: Ogni `->label()` nel codice è un peccato mortale
- **Penitenza**: Implementare traduzione in `lang/it/`, `lang/en/`, `lang/de/`
- **Redenzione**: Rimuovere `->label()` e testare traduzione automatica

**Documentazione ufficiale:** `docs/never-use-label-rule.md`

**B) DOGMA #2: UIBase NON ESISTE - Usa XotBase**

**Rivelazione critica:** Il modulo UI **NON** ha classi UIBase.

```php
// ❌ NON ESISTE
use Modules\UI\Filament\Resources\UIBaseResource;

// ✅ ESISTE - Usa sempre XotBase
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
```

**Perché:** UI è un **modulo consumer**, non un base layer. XotBase è il layer di base.

**C) DOGMA #3: TransTrait per Enum - Mai hardcoded labels**

Enum devono sempre usare `TransTrait` per label/color/icon:

```php
enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;  // ← DOGMA

    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }
}
```

**D) DOGMA #4: PHPStan Level 10 - Zero Tolerance**

Ogni file deve passare PHPStan Level 10:
- Type hints completi
- No `@phpstan-ignore` senza justification
- No generic non risolti

**E) DOGMA #5: Strict Types Everywhere**

```php
<?php

declare(strict_types=1);  // ← SEMPRE in ogni file PHP

namespace Modules\UI\...;
```

---

## 6. SCOPO - Obiettivo: Libreria Componenti Riusabili

### Mission Statement

**Fornire una libreria completa di componenti UI riusabili che:**

1. **Estende Filament v4** senza sostituirlo
2. **Elimina duplicazione** tra moduli
3. **Centralizza pattern UI** comuni
4. **Garantisce consistenza** visiva
5. **Facilita localizzazione** automatica
6. **Ottimizza performance** rendering

### Use Cases Principali

**A) Module Consumer Pattern**

Altri moduli consumano componenti UI:

```php
// In TechPlanner/Filament/Resources/DeviceResource.php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;

public static function form(Form $form): Form
{
    return $form->schema([
        InlineDatePicker::make('installation_date')
            ->enabledDates(fn () => $this->getAvailableDates()),
    ]);
}

public static function table(Table $table): Table
{
    return $table->columns([
        IconStateColumn::make('status'),
    ]);
}
```

**B) CMS Content Builder**

Il modulo Cms usa Blocks UI per costruire pagine:

```php
// In Cms/Models/Page.php
use Filament\Forms\Components\Builder;
use Modules\UI\Filament\Blocks\{HeroBlock, HeadingBlock, ParagraphBlock};

public static function form(Form $form): Form
{
    return $form->schema([
        Builder::make('content')
            ->blocks([
                HeroBlock::make(),
                HeadingBlock::make(),
                ParagraphBlock::make(),
                // ... altri blocchi UI
            ]),
    ]);
}
```

**C) Dashboard Widgets**

Tutti i moduli usano widgets UI per dashboard:

```php
// Dashboard di qualsiasi modulo
class Dashboard extends XotBaseDashboard
{
    protected function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            UserCalendarWidget::class,
            // ... altri widget UI
        ];
    }
}
```

---

## 7. ZEN - L'Essenza del Sistema Componenti UI

### Il Cuore del Sistema

**"I componenti si scoprono da soli, le traduzioni emergono automaticamente, il layout si adatta responsivamente."**

### Principi Zen

**A) Auto-Discovery (Wu Wei - 無為)**

Non forzare la registrazione dei componenti, lascia che emergano:

```php
// UIServiceProvider - Auto-discovery senza configurazione
public function boot(): void
{
    // Auto-discovery dei componenti Blade dalla directory
    $componentPath = $this->getComponentViewPath();
    if (file_exists($componentPath)) {
        // Componenti auto-registrati
    }
}
```

**B) Convention Over Configuration (道 - Tao)**

Segui il Tao delle convenzioni:

```
app/Filament/Forms/Components/InlineDatePicker.php
  → resources/views/filament/forms/components/inline-date-picker.blade.php
    → Registrato automaticamente come 'ui::filament.forms.components.inline-date-picker'
```

**C) Semplicità Emergente (簡 - Kan)**

I componenti più semplici emergono come pattern comuni:

```php
// RadioBadge - Emergente da pattern ripetuto
// Prima: RadioButton + Badge hardcoded ovunque
// Dopo: RadioBadge componente riusabile
class RadioBadge extends Radio {
    // Tutta la logica badge centralizzata
}
```

**D) Flow State (流 - Ryu)**

Il layout fluisce naturalmente tra LIST e GRID:

```php
// TableLayoutEnum - Flow tra stati
public function toggle(): self
{
    return match ($this) {
        self::LIST => self::GRID,
        self::GRID => self::LIST,
    };
}
```

**E) Unità nella Molteplicità (一 - Ichi)**

Un sistema, molti componenti, una filosofia:

```
UI Module (1)
  ├── 8 Table Columns
  ├── 15 Form Components
  ├── 11 Widgets
  └── 14 Blocks
= 48 componenti, 1 filosofia coerente
```

### L'Essenza (精髓)

**Il cuore del sistema UI è:**

> **"Estendere senza sostituire, riutilizzare senza duplicare, tradurre senza hardcodare, adattare senza forzare."**

Ogni componente:
- **Estende** Filament (non lo sostituisce)
- **Riutilizza** logica comune (no duplicazione)
- **Traduce** automaticamente (no `->label()`)
- **Si adatta** responsivamente (LIST/GRID fluido)

---

## DIFFERENZA CRITICA: UIBase vs XotBase

### Verità Rivelata

**UIBase NON ESISTE nel modulo UI.**

Il modulo UI **non fornisce classi base**, ma **consuma XotBase**:

```php
// Modulo Xot fornisce le basi:
XotBaseResource
XotBasePage
XotBaseWidget
XotBaseColumn
XotBaseServiceProvider
// ... ecc.

// Modulo UI estende le basi Xot:
class StatsOverviewWidget extends BaseWidget  // Filament native
class IconStateColumn extends IconColumn      // Filament native
class TreeColumn extends XotBaseColumn        // Xot base
class UIServiceProvider extends XotBaseServiceProvider  // Xot base
```

### Gerarchia di Estensione

```
Filament v4 Native
  ├── Column, Field, Widget, Block, Action
  │
  └── Modulo Xot (Layer Base)
      ├── XotBaseResource
      ├── XotBasePage
      ├── XotBaseWidget
      └── XotBaseServiceProvider
      │
      └── Modulo UI (Consumer Layer)
          ├── IconStateColumn extends IconColumn (Filament)
          ├── InlineDatePicker extends DatePicker (Filament)
          ├── TreeColumn extends XotBaseColumn (Xot)
          └── UIServiceProvider extends XotBaseServiceProvider (Xot)
```

### Pattern Decisionale

**Quando UI estende Filament direttamente:**
- Se non serve logica base custom (es. IconStateColumn)
- Se il componente è auto-contenuto

**Quando UI estende XotBase:**
- Se serve logica base condivisa (es. TreeColumn usa XotBaseColumn)
- Se serve ServiceProvider modulare (UIServiceProvider estende XotBaseServiceProvider)

---

## INTEGRAZIONE CON TEMI

### Struttura Temi

Il modulo UI si integra con il sistema temi (Sixteen, Two, Zero):

```
laravel/Themes/Sixteen/
├── vite.config.js      # Build config tema-specifico
├── resources/
│   └── views/
│       └── components/  # Override componenti UI
└── lang/               # Traduzioni tema-specifico
```

### Override Pattern

I temi possono override componenti UI:

```blade
<!-- Default UI view -->
Modules/UI/resources/views/filament/forms/components/inline-date-picker.blade.php

<!-- Theme override (se esiste) -->
Themes/Sixteen/resources/views/filament/forms/components/inline-date-picker.blade.php
```

Laravel risolve automaticamente override temi con view namespace precedence.

---

## CONCLUSIONI

### Punti di Forza

1. **56 componenti Filament** ben organizzati e documentati
2. **PHPStan Level 10 compliant** su file core
3. **Sistema traduzioni automatico** via TransTrait
4. **TableLayoutEnum** elegante per LIST/GRID responsive
5. **Blocks CMS** per composizione pagine dinamiche
6. **No UIBase** - Architettura pulita consumer di XotBase

### Aree di Miglioramento

1. **Documentazione inline** - Alcuni componenti mancano PHPDoc completo
2. **File backup** - Rimuovere `.bak`, `.to_geo`, `.disabled`
3. **Complessità** - `OpeningHoursField` >100 righe, considerare refactoring
4. **Testing** - Coverage migliorabile

### Raccomandazioni

**Immediate:**
- Completare PHPDoc per tutti i componenti
- Rimuovere file backup/disabled
- Aggiornare docs per chiarire "NO UIBase"

**Long-term:**
- Estrarre sub-componenti da form complessi
- Aumentare test coverage
- Implementare E2E tests per workflow completi

---

**Modulo**: UI
**Versione**: 4.1.0
**Framework**: Laravel 12 + Filament 4
**PHPStan**: Level 10 ✅
**Filosofia**: Estendere, Riutilizzare, Tradurre, Adattare
**Zen**: I componenti si scoprono da soli 禅

---

## Collegamenti Utili

- [Never Use Label Rule](./never-use-label-rule.md)
- [Components Guide](./components-guide.md)
- [Filament 4 Migration Guide](./filament/filament-4-migration-guide.md)
- [Architecture Documentation](./architecture.md)
