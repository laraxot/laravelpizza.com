# PHPStan Corrections - Gennaio 2025

## Riepilogo

Correzioni sistematiche degli errori PHPStan livello 10 per migliorare la qualità del codice e la conformità architetturale.

## Correzioni Implementate

### 1. Componenti View - Proprietà Mancanti

#### Problema
I componenti View accedevano a proprietà non dichiarate nel costruttore, causando errori PHPStan `property.notFound`.

#### Soluzione
Aggiunte proprietà pubbliche nel costruttore per tutti i componenti View:

- **`Render/Blocks`**: Già corretto con proprietà `$view`, `$blocks`, `$model`
- **`Render/Block`**: Aggiunta proprietà `$block` nel costruttore
- **`Std`**: Aggiunta proprietà `$tpl` nel costruttore
- **`Page/WithSidebar`**: Aggiunta proprietà `$tpl` nel costruttore
- **`Svg`**: Aggiunta proprietà `$tpl` nel costruttore e corretto return type `View`
- **`Logo`**: Aggiunta proprietà `$tpl` nel costruttore e corretto return type `View`
- **`Sidebar`**: Implementato metodo `render()` mancante

### 2. Widget Filament - Proprietà e Return Types

#### Problema
Widget accedevano a proprietà non dichiarate o avevano return types non corretti.

#### Soluzione

- **`HeroWidget`**: Aggiunte proprietà pubbliche `$title` e `$icon`
- **`RedirectWidget`**: Corretto accesso da `$this->to` a `$this->url`
- **`TestChartWidget`**: Rimosso `?string` dal return type di `getDescription()` (non restituisce mai null)

### 3. Form Components - Type Annotations

#### Problema
Proprietà `$view` non riconosciute come `view-string` da PHPStan.

#### Soluzione
Aggiunto PHPDoc `@var view-string` per:

- **`PasswordStrengthField`**: Aggiunto `@var view-string` per `$view`
- **`TreeField`**: Aggiunto `@var view-string` per `$view`
- **`SingleRoleSelect`**: Aggiunto `@var view-string` per `$view`

### 4. Resources Pages - Estensioni XotBase

#### Problema
Pagine Resource estendevano direttamente classi Filament invece di XotBase.

#### Soluzione

- **`ViewLocation` (Geo)**:
  - Cambiato da `ViewRecord` a `XotBaseViewRecord`
  - Implementato metodo `getInfolistSchema()` richiesto
- **`EditUser` (User)**:
  - Cambiato da `EditRecord` a `XotBaseEditRecord`
  - Aggiunto import corretto
- **`CreateQuestionChart` (Quaeris)**:
  - Cambiato da `CreateRecord` a `XotBaseCreateRecord`
- **`EditQuestionChart` (Quaeris)**:
- **`CreateQuestionChart` (Quaeris)**:
  - Cambiato da `CreateRecord` a `XotBaseCreateRecord`
- **`EditQuestionChart` (Quaeris)**:
  - Cambiato da `EditRecord` a `XotBaseEditRecord`
- **`ViewPageContent` (Cms)**:
  - Cambiato da `ViewRecord` a `XotBaseViewRecord`
  - Implementato metodo `getInfolistSchema()` richiesto

### 5. Query Builder - Type Narrowing

#### Problema
Query dinamiche su modelli non riconosciute correttamente da PHPStan.

#### Soluzione

- **`LocationSelector`**:
  - Aggiunti type assertions per query builder dinamiche
  - Aggiunto controllo `is_array()` prima di usare risultati query
  - Aggiunto PHPDoc `@var \Illuminate\Database\Eloquent\Builder` per query builder

### 6. Metodi Statici Privati

#### Problema
Chiamate a metodi privati con `static::` invece di `self::`.

#### Soluzione

- **`QuestionChartResource`**:
  - Cambiato `static::` in `self::` per chiamate a metodi privati
  - Risolto errore `staticClassAccess.privateMethod`

### 7. Return Types Componenti View

#### Problema
Metodi `render()` con return types non specifici o errati.

#### Soluzione

- **`Simple` (Hero)**: Aggiunto return type `View`
- **`Svg`**: Cambiato da `Renderable` a `View` e aggiunto parametro `$tpl`
- **`Logo`**: Cambiato da `Renderable` a `View` e aggiunto parametro `$tpl`

## Pattern Applicati

### Type Narrowing per Query Dinamiche

```php
// ❌ ERRORE
$regions = $model::select('regione')
    ->distinct()
    ->orderBy('regione->nome')
    ->get()
    ->pluck('regione.nome', 'regione.codice')
    ->toArray();

// ✅ CORRETTO
/** @var class-string $model */
/** @var \Illuminate\Database\Eloquent\Builder $query */
$query = $model::select('regione')
    ->distinct()
    ->orderBy('regione->nome')
    ->get()
    ->pluck('regione.nome', 'regione.codice')
    ->toArray();

if (!is_array($query)) {
    return [];
}

/** @var array<string, string> $regions */
$regions = $query;
```

### Proprietà View Components

```php
// ❌ ERRORE - Proprietà non dichiarata
public function render(): Renderable
{
    $view = app(GetViewAction::class)->execute($this->tpl);
}

// ✅ CORRETTO - Proprietà dichiarata nel costruttore
public function __construct(
    public string $tpl = '',
) {}

public function render(): View
{
    $view = app(GetViewAction::class)->execute($this->tpl);
    return view($view);
}
```

### Estensioni XotBase

```php
// ❌ ERRORE - Estensione diretta Filament
class ViewLocation extends ViewRecord
{
    // ...
}

// ✅ CORRETTO - Estensione XotBase
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Informazioni')->schema([
                TextEntry::make('name'),
                // ...
            ]),
        ];
    }
}
```

## File Modificati

### Modulo Geo
- `app/Filament/Resources/LocationResource/Pages/ViewLocation.php`

### Modulo User
- `app/Filament/Resources/UserResource/Pages/EditUser.php`
- `app/Filament/Forms/Components/SingleRoleSelect.php`

### Modulo UI
- `app/View/Components/Sidebar.php`
- `app/View/Components/Render/Block.php`
- `app/View/Components/Render/Blocks.php`
- `app/View/Components/Std.php`
- `app/View/Components/Page/WithSidebar.php`
- `app/View/Components/Svg.php`
- `app/View/Components/Logo.php`
- `app/View/Components/Blocks/Hero/Simple.php`
- `app/Filament/Widgets/HeroWidget.php`
- `app/Filament/Widgets/RedirectWidget.php`
- `app/Filament/Widgets/TestChartWidget.php`
- `app/Filament/Forms/Components/PasswordStrengthField.php`
- `app/Filament/Forms/Components/TreeField.php`
- `app/Filament/Forms/Components/LocationSelector.php`

### Modulo Quaeris
### Modulo Quaeris
- `app/Filament/Resources/QuestionChartResource.php`
- `app/Filament/Resources/SurveyPdfResource/Resources/QuestionCharts/Pages/CreateQuestionChart.php`
- `app/Filament/Resources/SurveyPdfResource/Resources/QuestionCharts/Pages/EditQuestionChart.php`
- `app/Filament/Widgets/QuestionChartStatsOverviewWidget.php`

### Modulo Cms
- `app/Filament/Resources/PageContentResource/Pages/ViewPageContent.php`
- `app/Filament/Resources/PageContentResource/Pages/ListPageContents.php`

## Risultati

- ✅ Ridotti errori fatali da 4 a 0
- ✅ Corretti errori di proprietà mancanti nei componenti View
- ✅ Migliorato type safety per query dinamiche
- ✅ Conformità architetturale con XotBase classes
- ✅ Return types corretti per tutti i componenti View

## Note

- Tutte le correzioni rispettano le regole architetturali Laraxot
- Mantenuta compatibilità con Filament 4.x
- Type hints rigorosi per PHPStan livello 10
- Documentazione PHPDoc completa per type narrowing

## Riferimenti

- [Regole Architetturali Critiche](../../Xot/docs/critical-architecture-rules.md)
- [PHPStan Patterns](./phpstan-patterns.md)
- [PHPStan Compliance](./phpstan-compliance.md)
