# PHPStan Code Quality Guide - Laraxot

**Ultimo aggiornamento**: [DATE]  
**Principi**: DRY + KISS + SOLID + Robust  
**Stack**: Laravel 12 + Filament 4 + PHP 8.3 + Laraxot  
**Obiettivo**: 0 errori PHPStan Level 10 + Complexity < 10 + Quality > 80%

---

## 📑 Indice

1. [Regole Assolute](#-regole-assolute)
2. [Quick Reference - Comandi](#-quick-reference---comandi-essenziali)
3. [Workflow Operativo](#-workflow-operativo)
4. [Autonomous Priority Rule](./autonomous-priority-rule.md) (NEW!)
5. [Regole Architetturali](#-regole-architetturali)
5. [Patterns di Correzione](#-patterns-di-correzione)
6. [Complexity Reduction](#-complexity-reduction-patterns)
7. [Widget Best Practices](#-widget-best-practices)
8. [Code Quality Tools](#-code-quality-tools)
9. [Commenti e TODO](#-commenti-e-todo)
10. [Filament Class Extensions](#-filament-class-extension-rules)
11. [Anti-Pattern da Evitare](#-anti-pattern-da-evitare)
12. [Checklist e Mantra](#-checklist-e-mantra-finale)

---

## 🚨 Regole Assolute

### Mai Modificare Configurazione
- **NON modificare MAI** `laravel/phpstan.neon`
- **NON creare baseline** - tutti gli errori vanno corretti
- **NON ignorare errori** - approccio "fix, don't ignore"
- **NON usare** `@phpstan-ignore` (eccezione: solo per bug noti di PHPStan con issue aperta)

### Filosofia Fondamentale
- **Docs come Bibbia**: Studia `Modules/{Modulo}/docs/` prima di ogni correzione
- **Link sempre relativi**: Mai path assoluti nei file .md
- **Naming files**: Minuscolo, no date, solo README.md può essere maiuscolo
- **Property exists**: NON funziona con magic attributes Eloquent - usa `isset()`
- **Complexity target**: Ogni metodo < 10 cyclomatic complexity
- **Function length**: Ogni metodo < 20 righe (target), max 50 righe

---

## 📋 Quick Reference - Comandi Essenziali

```bash
# Analisi PHPStan completa
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1

# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1

# Analisi file specifico
./vendor/bin/phpstan analyse Modules/{Module}/app/path/to/File.php --level=10 --error-format=table

# Verifica autoload
composer dump-autoload && php artisan config:clear && php artisan cache:clear

# Code Quality Tools
./vendor/bin/pint --dirty                    # Format changed files
php phpmd.phar path/to/file text cleancode,codesize,design,naming
./vendor/bin/phpinsights analyse Modules/{Module} --format=table

# Complexity Analysis
php phpmd.phar Modules/{Module} text codesize --reportfile /tmp/complexity.txt
```

---

## 🎯 Workflow Operativo - Metodologia "Super Mucca"

### Fase 0: SCELTA PRIORITÀ 🎯

**REGOLA FONDAMENTALE**: L'AI Assistant DEVE SEMPRE scegliere autonomamente la priorità dei task.

**Criteri di Priorità**:
1. **CRITICO**: Conflitti Git, errori PHPStan L10, bug sicurezza, errori sintassi
2. **ALTO**: Refactoring architetturale, documentazione critica, performance issues
3. **MEDIO**: Miglioramenti codice, documentazione generale, test coverage
4. **BASSO**: Code style, commenti, ottimizzazioni minori

**Output**: Priorità chiara e motivata

### Fase 1: ANALISI PROFONDA 🔍

**Obiettivo**: Capire il PERCHÉ, non solo il COSA

1. **Aumenta confidenza**: Studia architettura e business logic
2. **Studia docs**: Leggi `Modules/{Modulo}/docs/` e `Themes/{Tema}/docs/`
3. **Comprendi filosofia**: Logica, politica, business logic, scopo del progetto
4. **Identifica problemi**: Elenca tutti i problemi identificati

**Domande da Porsi**:
- 🤔 Qual è la **business logic** di questo codice?
- 🎯 Qual è lo **scopo** di questa funzionalità?
- 🧘 Qual è la **filosofia** architettuale?
- 📊 Quali sono le **dipendenze** e gli **impatti**?
- 🔗 Come si **integra** con altri moduli?

**Output**: Comprensione profonda del contesto

### Fase 2: AGGIORNA E STUDIA DOCS 📚

**Obiettivo**: Mantenere la documentazione come "memoria viva" del progetto

1. **Verifica esistenza**: Prima di creare un nuovo file `.md`, controlla che non esista già un documento sullo stesso argomento.
2. **Naming files**: Nomi dei file `.md` in minuscolo, senza date, eccetto `README.md` e `CHANGELOG.md`.
3. **Posizione**: Crea file `.md` **solo** dentro le cartelle `docs` esistenti (`Modules/{ModuleName}/docs/` o `Themes/{ThemeName}/docs/`). NON creare nuove cartelle `docs`.
4. **Contenuto**: Documenta ciò che stai per fare, le decisioni prese, i pattern applicati, i bugfix, le analisi delle pagine.
5. **Link relativi**: Usa sempre link relativi nei file `.md`.

**Output**: Documentazione aggiornata e conforme alle regole

### Fase 3: LITIGA FURIOSAMENTE CON TE STESSO (Ragionamento) 🧠

**Obiettivo**: Trovare la soluzione più Laraxot-compliant, DRY, KISS, SOLID, Robust

1. **Brainstorming**: Genera diverse soluzioni possibili.
2. **Valutazione**: Analizza ogni soluzione rispetto ai principi Laraxot e agli obiettivi del progetto.
3. **Conflitto Interno**: Metti in discussione le tue ipotesi, cerca i punti deboli.
4. **Decisione**: Scegli la soluzione migliore e giustificala.

**Output**: Decisione chiara sulla soluzione da implementare e motivazioni

### Fase 4: IMPLEMENTA 💻

**Obiettivo**: Scrivere codice pulito, efficiente e conforme agli standard

1. **Scrivi codice**: Implementa la soluzione scelta.
2. **Type Safety**: Usa `declare(strict_types=1);`, type hints rigorosi, gestisci nullable values, array con strutture definite.
3. **Webmozart Assert**: Usa `Webmozart\Assert\Assert` per validazioni robuste.
4. **TheCodingMachine Safe**: Usa `TheCodingMachine\Safe` per funzioni PHP sicure.
5. **Complexity Reduction**: Applica pattern come "Extract Method", "Guard Clauses", "Template Method", "Strategy Pattern", "Single Responsibility Principle".
6. **Filament Class Extensions**: Estendi sempre classi `XotBase` (vedi sezione [Filament Class Extensions](#-filament-class-extension-rules)).
7. **Traduzioni**: NON usare `->label()`, `->placeholder()`, `->tooltip()` direttamente; usa file di traduzione.
8. **Actions vs Services**: Preferisci `Spatie\QueueableAction\QueueableAction` per la business logic.
9. **Eloquent Magic Properties**: Usa `isset()` invece di `property_exists()` per gli attributi magici dei modelli Eloquent.
10. **Filament Methods Return Types**: Assicurati che metodi come `getTableColumns`, `getFormSchema`, `getTableBulkActions`, `getTableActions`, `getTableFilters`, `getHeaderActions` restituiscano `array<string, mixed>` (array associativi).

**Output**: Codice implementato

### Fase 5: CONTROLLA E CORREGGI (Verifica Incrementale) ✅

**Obiettivo**: Garantire 0 errori PHPStan L10, complexity < 10, quality > 80%

1. **PHPStan Level 10**: Esegui `./vendor/bin/phpstan analyse --level=10 path/to/file.php`. Corregge **TUTTI** gli errori. NON procedere se ci sono errori.
2. **PHPMD**: Esegui `./phpmd.phar path/to/file.php text cleancode,codesize,design`. Risolvi code smells.
3. **PHPInsights**: Esegui `./vendor/bin/phpinsights analyse path/to/file.php`. Verifica qualità complessiva.
4. **Pint**: Esegui `./vendor/bin/pint --dirty` per formattare il codice.
5. **Autoload**: `composer dump-autoload && php artisan config:clear && php artisan cache:clear`.
6. **Applicazione si avvia**: Verifica che l'applicazione si avvii senza errori.

**Output**: Codice verificato e corretto, pronto per il miglioramento

**Output**: Codice corretto e verificato

### Fase 6: CONTROLLA (Triple Check) ✅

**Obiettivo**: Zero errori, massima qualità

```bash
# 1. PHPStan Level 10
./vendor/bin/phpstan analyse path/to/File.php --level=10 --error-format=table

# 2. PHPMD (Complexity)
./vendor/bin/phpmd path/to/File.php text codesize,cleancode

# 3. PHP Insights (Quality Score)
./vendor/bin/phpinsights analyse path/to/File.php --format=table

# 4. Pint (Formatting)
./vendor/bin/pint path/to/File.php
```

**Thresholds Obbligatori**:
- ✅ PHPStan: 0 errori Level 10
- ✅ Complexity: < 10 per metodo
- ✅ Function Length: < 20 righe (target), max 50
- ✅ Quality Score: > 80%

**Se NON passa**: Torna a Fase 2 (Litiga) e ripensa l'approccio

### Fase 7: VERIFICA 🧪

**Obiettivo**: Conferma funzionamento completo

```bash
# 1. Autoload
composer dump-autoload

# 2. Cache clear
php artisan config:clear
php artisan cache:clear

# 3. Test (se esistono)
php artisan test --filter={TestName}

# 4. PHPStan finale
./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10
```

**Checklist Verifica**:
- [ ] Composer autoload OK?
- [ ] PHPStan 0 errori?
- [ ] PHPMD complexity OK?
- [ ] PHP Insights quality OK?
- [ ] Test passano (se esistono)?
- [ ] Runtime funziona?

**Output**: Verifica completa del funzionamento

### Fase 8: MIGLIORA 🚀

**Obiettivo**: Eccellenza oltre la compliance

**Domande per Miglioramento**:
- 💡 Posso ridurre ulteriormente la complexity?
- 💡 Posso estrarre metodi per maggiore chiarezza?
- 💡 Posso migliorare i nomi di variabili/metodi?
- 💡 Posso aggiungere PHPDoc più descrittivi?
- 💡 Ci sono pattern riutilizzabili da estrarre?

**Output**: Codice migliorato e ottimizzato

### Fase 9: AGGIORNA DOCS (DOPO) 📝

**Obiettivo**: Conoscenza permanente per il team

1. **Finalizza documentazione**: Dettagli dell'implementazione
2. **Documenta decisioni**: Motivazioni e scelte architetturali
3. **Aggiorna collegamenti**: Link bidirezionali con altre docs

**Output**: Documentazione completa e aggiornata
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
- `getTableActions()` e `getTableBulkActions()` devono restituire `array<string, Action>` e `array<string, BulkAction>` rispettivamente
- Se solo azioni standard → **rimuovile completamente**
- Se azioni personalizzate → includi `...parent::getTableActions()`

### Metodi Page Filament
Chi estende `XotBasePage` **NON deve avere**:
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

## 🔧 Patterns di Correzione

### 1. Carbon createFromFormat (Carbon|null vs Carbon|false)
```php
// ✅ CORRETTO - L'estensione Carbon restituisce Carbon|null
$targetMonth = Carbon::createFromFormat('Y-m', $month);
if ($targetMonth === null) {
    $targetMonth = now()->startOfMonth();
} else {
    $targetMonth = $targetMonth->startOfMonth();
}
```

### 2. Type Narrowing con Assert
```php
use Webmozart\Assert\Assert;

// ✅ CORRETTO
if (is_array($data)) {
    Assert::isArray($data);
    $value = $data['key'] ?? null;
}
```

### 3. Cast Actions Centralizzate
```php
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// ✅ CORRETTO
$data = SafeArrayCastAction::cast($input);
$title = SafeStringCastAction::cast($mod->title);
```

### 4. Array Associativi Filament - Chiavi Sempre Stringhe

**REGOLA CRITICA**: I metodi Filament restituiscono sempre `array<string, ...>` - le chiavi DEVONO essere stringhe esplicite, NON mixed, NON int.

```php
// ❌ ERRORE - array<int, Action> (chiavi numeriche) - VIETATO
public function getTableActions(): array
{
    return [EditAction::make(), DeleteAction::make()];
}

// ❌ ERRORE - array<mixed, Action> (chiavi mixed) - VIETATO
/**
 * @return array<mixed, Action>
 */
public function getTableActions(): array
{
    return [...];
}

// ✅ CORRETTO - array<string, Action> (chiavi stringhe esplicite) - OBBLIGATORIO
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

**Metodi che DEVONO restituire `array<string, ...>` con chiavi stringhe esplicite**:
- `getTableColumns()` → `array<string, Column>` (chiavi string obbligatorie)
- `getFormSchema()` → `array<string, Component>` (chiavi string obbligatorie)
- `getTableActions()` → `array<string, Action>` (chiavi string obbligatorie)
- `getTableBulkActions()` → `array<string, BulkAction>` (chiavi string obbligatorie)
- `getTableFilters()` → `array<string, Filter>` (chiavi string obbligatorie)
- `getHeaderActions()` → `array<string, Action>` (chiavi string obbligatorie)

**REGOLA ASSOLUTA**: Le chiavi degli array DEVONO essere sempre string esplicite.

**MIXED come tipo valore è consentito SOLO come ultima spiaggia e deve essere documentato con PHPDoc.**

**❌ VIETATO**: Array con chiavi numeriche (`array<int, ...>`) o chiavi mixed (`array<mixed, ...>`).

### 5. Property Access su Mixed (Eloquent) - property_exists() NON Funziona

**REGOLA CRITICA**: `property_exists()` NON funziona con magic attributes Eloquent. Usa SEMPRE `isset()`.

```php
// ❌ ERRORE - property_exists() NON funziona con magic attributes Eloquent
if (property_exists($model, 'attribute')) {
    $value = $model->attribute; // PHPStan: Cannot access property on mixed
}

// ✅ CORRETTO - usa isset() per magic attributes
if (isset($model->attribute)) {
    $value = $model->attribute;
}

## 📚 Risorse Filament v4

Studia costantemente:
- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [What's New in Filament v4](https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4)
- [Filament v4 Forms Overview](https://filamentphp.com/docs/4.x/forms/overview)
- [Filament v4 Tables](https://filamentphp.com/docs/4.x/tables/overview)
- [Filament v4 Widgets](https://filamentphp.com/docs/4.x/widgets/overview)

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

## 🔍 Errori Più Comuni

### 1. Property Access su Mixed
```php
// ERRORE: Cannot access property $state on mixed
$record->state->transitionTo($newState);

// SOLUZIONE
if (method_exists($record, 'getState')) {
    $state = $record->getState();
    Assert::notNull($state);
    if (method_exists($state, 'transitionTo')) {
        $state->transitionTo($newState);
    }
}
```

### 2. Array Access su Mixed
```php
// ERRORE: Cannot access offset on mixed
$value = $data['key'];

// SOLUZIONE
$data = SafeArrayCastAction::cast($data);
$value = $data['key'] ?? null;
```

### 3. Return Type Mismatch
```php
// ERRORE: Method should return array but returns mixed
public function getData(): array {
    return $this->data;
}

// SOLUZIONE
public function getData(): array {
    Assert::isArray($this->data);
    return $this->data;
}
```

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

## 🚫 Anti-Pattern da Evitare

### ❌ Ignorare Errori
```php
// SBAGLIATO
/** @phpstan-ignore-next-line */
$value = $data['key'];
```

### ❌ Modificare Configurazione
```php
// SBAGLIATO - Modificare phpstan.neon
parameters:
    ignoreErrors:
        - '#Cannot access property#'
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

## 💡 Regole Speciali

### Lock Files
Prima di modificare un file:
1. Crea file `.lock` con stesso nome nella stessa locazione
2. Se `.lock` esiste → vai a fare altro
3. Dopo modifica → cancella `.lock`

### Verifica Post-Modifica
Dopo ogni modifica file:
- [ ] PHPStan Level 10
- [ ] PHPMD (complexity < 10)
- [ ] PHP Insights (quality > 80%)
- [ ] Pint formatting
- [ ] Aggiorna docs moduli/temi

### Git
- **MAI tornare indietro** di versione
- Solo avanti, mai backward

### Property Exists vs Isset
- **property_exists()** NON funziona con magic attributes Eloquent
- Usa sempre **isset()** per proprietà dinamiche modelli

---

## 🎓 Mantra Finale

**DRY + KISS + SOLID + Robust + Laravel 12 + Filament 4 + PHP 8.3 + Laraxot**

**Filosofia Zen**: "Non avrai altro path all'infuori del relativo"

**Poteri Supermucca**: Massima confidenza, zero compromessi, correzione completa

**Approccio**: Fix, don't ignore - tutti gli errori vanno corretti, nessuno ignorato

**Quality Mantra**: Complexity < 10, Functions < 20 lines, Quality > 80%

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

---

## 🔗 Collegamenti Utili

- [Code Quality Tools Setup](./code-quality-tools-setup.md) - Setup PHPMD e PHP Insights
- [Code Quality Mandatory Checks](./code-quality-mandatory-checks.md) - Workflow obbligatorio
- [XotBase Extension Rules](./filament-class-extension-rules.md)
- [Filament Best Practices](./filament-best-practices.md)
- [Code Quality Standards](./code_quality_standards.md)
- [Autonomous Priority Rule](./autonomous-priority-rule.md)
- [Super Mucca Methodology](./super-mucca-methodology.md)

