# PHPStan Code Quality Guide - base_ptvx_fila5_mono

**Principi**: DRY + KISS + SOLID + Robust  
**Stack**: Laravel 12 + Filament 4 + PHP 8.3 + Laraxot  
**Obiettivo**: 0 errori PHPStan Level 10 + Complexity < 10 + Quality > 90%

---

## 🚨 Regole Assolute

### Configurazione
- **NON modificare MAI** `laravel/phpstan.neon`
- **NON creare baseline** - tutti gli errori vanno corretti
- **NON ignorare errori** - approccio "fix, don't ignore"
- **NON usare** `@phpstan-ignore` (eccezione: solo per bug noti di PHPStan con issue aperta)

### Filosofia Fondamentale
- **Docs come Bibbia**: Studia `Modules/{Modulo}/docs/` e `Themes/{Tema}/docs/` prima di ogni correzione
- **Link sempre relativi**: Mai path assoluti nei file .md
- **Naming files**: Minuscolo, no date, solo README.md può essere maiuscolo
- **Property exists**: NON funziona con magic attributes Eloquent - usa `isset()`
- **Complexity target**: Ogni metodo < 10 cyclomatic complexity
- **Function length**: Ogni metodo < 20 righe (target), max 50 righe
- **Mixed types**: Usali solo come ultima spiaggia

---

## 📋 Quick Reference - Comandi Essenziali

```bash
# Analisi PHPStan completa
cd /var/www/_bases/base_ptvx_fila5_mono/laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1

# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1

# Verifica autoload
composer dump-autoload && php artisan config:clear && php artisan cache:clear

# Code Quality Tools
./vendor/bin/pint --dirty
./vendor/bin/phpmd Modules/{Module} text codesize
./vendor/bin/phpinsights analyse Modules/{Module} --format=table
```

---

## 🎯 Workflow Operativo

### Fase 1: Preparazione
1. **Aumenta confidenza**: Studia architettura e business logic
2. **Studia docs**: Leggi `Modules/{Modulo}/docs/` e `Themes/{Tema}/docs/`
3. **Aggiorna docs**: Mantieni documentazione sempre aggiornata

### Fase 2: Analisi
```bash
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1 > /tmp/phpstan-report.txt
```

### Fase 3: Correzione Sistematica
1. **Scegli modulo**: Inizia da moduli con meno errori (quick wins)
2. **Categorizza errori**: Raggruppa per tipo (argument.type, return.type, ecc.)
3. **Correggi batch**: Pattern simili insieme
4. **Verifica incrementale**: Riesegui PHPStan dopo ogni batch
5. **Aggiorna docs**: Documenta modifiche e pattern applicati
6. **Quality check**: Verifica complexity e PHP Insights

### Fase 4: Verifica Finale
```bash
./vendor/bin/phpstan analyse Modules --memory-limit=-1
./vendor/bin/pint --dirty
./vendor/bin/phpinsights analyse Modules/{Module}
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

## 🏗️ Regole Architetturali

### Struttura Modulare
- Ogni modulo è **completamente indipendente**
- Namespace: `Modules\{ModuleName}\` (MAI con prefisso "app")
- Autoload indipendente per ogni modulo
- Ogni modulo ha proprio `composer.json`

### Estensione Classi Filament
**MAI estendere classi Filament direttamente** - sempre XotBase:
- `Filament\Resources\Resource` → `Modules\Xot\Filament\Resources\XotBaseResource`
- `Filament\Resources\Pages\CreateRecord` → `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- `Filament\Resources\Pages\EditRecord` → `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord`
- `Filament\Resources\Pages\ListRecords` → `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
- `Filament\Widgets\Widget` → `Modules\Xot\Filament\Widgets\XotBaseWidget`
- `Filament\Widgets\TableWidget` → `Modules\Xot\Filament\Widgets\XotBaseTableWidget`
- `Filament\Widgets\ChartWidget` → `Modules\Xot\Filament\Widgets\XotBaseChartWidget`
- `Filament\Widgets\StatsOverviewWidget` → `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget`
- `Illuminate\Support\ServiceProvider` → `Modules\Xot\Providers\XotBaseServiceProvider`

### Metodi Resource Filament
- Chi estende `XotBaseResource` **NON deve avere** `getTableColumns()`
- `getTableActions()` e `getTableBulkActions()` devono restituire `array<string, mixed>`
- Se solo azioni standard → **rimuovile completamente**
- Se azioni personalizzate → includi `...parent::getTableActions()`

### Metodi Page Filament
Chi estende `Modules\Xot\Filament\Pages\XotBasePage` **NON deve avere**:
- `protected static ?string $navigationIcon`
- `protected static ?string $title`
- `protected static ?string $navigationLabel`

### Gestione Traduzioni
- **NON usare MAI**: `->label()`, `->placeholder()`, `->tooltip()`
- Tutte le etichette tramite file di traduzione nei moduli
- Usa `LangServiceProvider` per gestione automatica
- Struttura chiavi: `modulo::risorsa.fields.campo.label`

### Type Safety
- **Type hints rigorosi** per tutti i parametri e return types
- Gestisci **nullable values** (`?string`, `?int`)
- Evita `mixed` types salvo necessità documentate
- Array con **strutture definite** (`array<string, mixed>`)
- Usa `declare(strict_types=1);` in tutti i file PHP
- Usa **Webmozart Assert** per validazioni robuste
- Usa **TheCodingMachine Safe** per funzioni PHP sicure

---

## 🔧 Patterns di Correzione Essenziali

### 1. Property Access su Mixed (Eloquent)
```php
// ❌ ERRORE - property_exists() NON funziona con magic attributes
if (property_exists($model, 'attribute')) {
    $value = $model->attribute;
}

// ✅ CORRETTO - usa isset() per magic attributes
if (isset($model->attribute)) {
    $value = $model->attribute;
}
```

### 2. Cast Actions Centralizzate
```php
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// ✅ CORRETTO
$data = SafeArrayCastAction::cast($input);
$title = SafeStringCastAction::cast($mod->title);
```

### 3. Array Associativi Filament
```php
// ❌ ERRORE - array<int, Action>
public function getTableActions(): array
{
    return [EditAction::make(), DeleteAction::make()];
}

// ✅ CORRETTO - array<string, mixed>
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### 4. Casts Completi per Properties
```php
// ✅ CORRETTO - Tutte le properties usate DEVONO essere nei casts()
protected function casts(): array
{
    return [
        'auto_cleanup_num' => 'integer',
        'auto_cleanup_type' => 'string',
        'notification_email_address' => 'string',
    ];
}
```

### 5. HasXotFactory NON è Generico
```php
// ❌ ERRORE - HasXotFactory NON accetta generics
/** @use HasXotFactory<TFactory> */
use HasXotFactory;

// ✅ CORRETTO - Rimuovi generics
use HasXotFactory;
```

### 6. Relazioni Eloquent con Generics
```php
// ✅ CORRETTO - Generics solo in PHPDoc
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @return HasMany<Post>
 */
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
```

### 7. Type Narrowing con Assert
```php
use Webmozart\Assert\Assert;

// ✅ CORRETTO
if (is_array($data)) {
    Assert::isArray($data);
    $value = $data['key'] ?? null;
}
```

### 8. Notification via() Return Type
```php
// ❌ ERRORE - list<string>
public function via($notifiable): array
{
    return ['mail', 'nexmo'];
}

// ✅ CORRETTO - array<string, mixed>
/**
 * @return array<string, mixed>
 */
public function via($notifiable): array
{
    return [
        'mail' => 'mail',
        'nexmo' => 'nexmo',
    ];
}
```

### 9. protected $casts Deprecato (Laravel 11+)
```php
// ❌ DEPRECATO - Laravel 10 e precedenti
protected $casts = [
    'email_verified_at' => 'datetime',
];

// ✅ CORRETTO - Laravel 11+ (metodo casts())
/**
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
    ];
}
```

---

## 🎯 Complexity Reduction Patterns

### Extract Method Pattern
**Problema**: Funzione troppo lunga (> 20 righe) o complessa (cyclomatic complexity > 10)

**Soluzione**: Estrarre logica in metodi privati focalizzati

### Guard Clauses Pattern
**Problema**: Nesting profondo, difficile da seguire

**Soluzione**: Early returns per validazione

---

## 🎨 Widget Best Practices

### Estensione Base Widgets
```php
// ✅ CORRETTO - Sempre estendere XotBase widgets
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class MyTableWidget extends XotBaseTableWidget
{
    // Auto-managed properties from parent
}
```

### Widget con Record Key Univoca
```php
public function getTableRecordKey(\Illuminate\Database\Eloquent\Model|array $record): string
{
    if (\is_array($record)) {
        return (string) ($record['id'] ?? $record['_id'] ?? '');
    }
    return (string) ($record->id ?? $record->_id ?? '');
}
```

---

## 🛠️ Code Quality Tools

### Laravel Pint (Code Formatting)
```bash
./vendor/bin/pint --dirty
```

### PHPMD (Mess Detector)
```bash
./vendor/bin/phpmd Modules/{Module} text codesize
```

**Thresholds PHPMD**:
- Cyclomatic Complexity: < 10
- Function Length: < 20 righe (raccomandato), max 50

### PHP Insights (Architettura + Quality)
```bash
./vendor/bin/phpinsights analyse Modules/{Module} --format=table
```

**PHP Insights Scores**:
- Code: > 90%
- Complexity: > 70% (target: 90%)
- Architecture: > 90%
- Style: > 95%

---

## 💬 Commenti e TODO

### Regole per Commenti
- Spiega il "perché", non il "cosa"
- Documenta decisioni architetturali
- Rimuovi codice commentato

### Gestione TODO
**REGOLA ASSOLUTA**: NON lasciare TODO nel codice production

---

## 🚫 Anti-Pattern da Evitare

### ❌ Ignorare Errori
```php
// SBAGLIATO
/** @phpstan-ignore-next-line */
$value = $data['key'];
```

### ❌ Modificare Configurazione
```php
// SBAGLIATO - Modificare phpstan.neon per ignorare errori
```

### ❌ Cast Non Sicuri
```php
// SBAGLIATO
$array = (array) $data;
$string = (string) $value;
```

### ✅ Pattern Corretti
```php
// CORRETTO - Cast Actions
$array = SafeArrayCastAction::cast($data);
$string = SafeStringCastAction::cast($value);
```

---

## ✅ Checklist Pre-Correzione

Prima di correggere un errore:
- [ ] Ho letto la documentazione del modulo in `docs/`?
- [ ] Ho compreso la causa radice dell'errore?
- [ ] Ho valutato l'impatto architetturale?
- [ ] La soluzione rispetta i pattern esistenti?
- [ ] La soluzione usa classi XotBase quando necessario?
- [ ] La soluzione usa Cast Actions centralizzate?
- [ ] Ho verificato la complexity del metodo (< 10)?
- [ ] Ho verificato la lunghezza del metodo (< 20 righe)?

---

## ✅ Checklist Post-Correzione

Dopo aver corretto un batch:
- [ ] PHPStan Level 10 non segnala nuovi errori?
- [ ] Il numero totale di errori è diminuito?
- [ ] Pint ha formattato correttamente il codice?
- [ ] PHPMD non segnala complexity > 10?
- [ ] PHP Insights score è migliorato?
- [ ] L'autoload funziona correttamente?
- [ ] L'applicazione si avvia senza errori?
- [ ] La documentazione è aggiornata?
- [ ] TODO e codice commentato rimossi?

---

## 🎯 Strategia Ottimale

1. **Analisi per Modulo**: Eseguire PHPStan su singolo modulo
2. **Pattern Recognition**: Identificare errori ricorrenti
3. **Batch Fixes**: Correggere pattern simili insieme
4. **Complexity Check**: Verificare e ridurre complexity dopo ogni batch
5. **Documentazione Parallela**: Aggiornare docs durante correzioni
6. **Verifica Incrementale**: Riesegui tutti i tool dopo ogni batch

**Quick Wins**: Inizia da moduli con meno errori per massimizzare impatto.

---

## 📖 Documentazione

### Struttura
- **Modulo**: `Modules/{ModuleName}/docs/` - Documentazione tecnica approfondita
- **Root**: `docs/` - Indici e collegamenti bidirezionali
- **Tema**: `Themes/{ThemeName}/docs/` - Documentazione tema

### Aggiornamento
- **Prima di correggere**: Studia docs del modulo
- **Dopo correzione**: Aggiorna docs con modifiche e pattern
- **Link relativi**: Mai path assoluti nei file .md
- **Naming**: Minuscolo, no date, solo README.md maiuscolo

---

## 🎓 Mantra Finale

**DRY + KISS + SOLID + Robust + Laravel 12 + Filament 4 + PHP 8.3 + Laraxot**

**Filosofia Zen**: "Non avrai altro path all'infuori del relativo"

**Poteri Supermucca**: Massima confidenza, zero compromessi, correzione completa

**Approccio**: Fix, don't ignore - tutti gli errori vanno corretti, nessuno ignorato

**Quality Mantra**: Complexity < 10, Functions < 20 lines, Quality > 90%

---

## 📝 Note Operative

- **Lavora dentro** `laravel/` directory
- **Esegui PHPStan** da dentro `laravel/`
- **Non usiamo controller**: Backoffice = Filament, Frontoffice = Folio + Volt
- **Test**: Tutti i test in Pest
- **Architettura**: Capisci logica, politica, business logic prima di implementare
- **Complexity**: Ogni correzione PHPStan deve anche ridurre complexity se > 10
- **Documentazione**: Ogni pattern applicato va documentato in `docs/`

---

**Ricorda**: Le cartelle docs sono la tua bibbia. Studiale, rispettale, aggiornale costantemente.