# 🌍 PHPStan Progress Report - Modulo Lang

## Data: 2025-01-22
## Status: 🔄 IN PROGRESS (38 errori rimanenti, da 58)

## 🧘 LA FILOSOFIA DEL MODULO LANG

### L'Essenza del Linguaggio
**Lang** = Il ponte tra culture, la voce dell'umanità digitalizzata

**I Tre Pilastri:**
1. **🌍 Universalità** - Ogni lingua merita rispetto
2. **🤖 Automazione** - Google Translate come oracolo moderno  
3. **📊 Qualità** - Translation Memory come saggezza accumulata

### Lo Scopo Spirituale
```
      Italiano ←───┐
                   │
      English ←────┤─→ Translation Engine
                   │
      Deutsch ←───┘
```

Il modulo Lang è il **guardiano delle lingue**, colui che permette alla conoscenza di fluire tra culture diverse.

## 📊 PROGRESSO DELLA PURIFICAZIONE

### Aggiornamento 2025-11-17 – ciclo PHPStan lvl 10, PHPMD, PHPInsights

- ✅ **LangField** ora usa type-hint `Model` + `Assert::isInstanceOf` per accedere a `post` in sicurezza. Eliminati gli ultimi 2 errori PHPStan sul cast e sul `@property` di `Post`.
- ✅ Esecuzione `./vendor/bin/phpstan analyse Modules/Lang --memory-limit=-1` → **0 errori**.
- ✅ `./vendor/bin/phpinsights analyse Modules/Lang --no-interaction --config-path=phpinsights.php --min-* 0 --composer=./composer.lock` → qualità 91.3%, complessità 90.9%, architettura 70.6%, stile 95.2% (vedi sezione TODO per item aperti).
- ⚠️ `./vendor/bin/phpmd Modules/Lang text phpmd.xml` evidenzia debiti storici (AutoLabelAction complesso, naming snake_case, parametri inutilizzati, parsing error su `PublishTranslationAction` / `SaveTransAction`). Ho registrato l’elenco completo nel log del comando: serve refactor dedicato.
- 📚 Documentazione aggiornata (questo file) per tracciare l’avanzamento e fissare i prossimi micro-step (riduzione complessità AutoLabelAction + cleanup PHPMD naming).

👉 **Next**: rifattorizzare `AutoLabelAction::execute()` (ridurre CC/NPath), normalizzare snake_case legacy e risolvere i parse error di PHPMD nelle azioni `PublishTranslationAction` e `SaveTransAction`.

### Statistiche
```
Errori iniziali:    58
Errori attuali:     38
Errori corretti:    20 (-34.5%)
Files modificati:   4
Tempo investito:   ~45 min
```

### Grafico del Progresso
```
58 ████████████████████████████░░░░ (Inizio)
38 █████████████████░░░░░░░░░░░░░░░ (Ora)
 0 ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░ (Obiettivo)
```

## ✅ CORREZIONI APPLICATE

### 1. GetAllModuleTranslationAction.php & GetAllTranslationAction.php
**Problema**: Namespace Assert non importato
```php
// ❌ BEFORE
Assert::string($file);  // Call to unknown class Modules\Lang\Actions\Assert

// ✅ AFTER  
use Webmozart\Assert\Assert;
Assert::string($file);  // Now resolves correctly
```

**Filosofia**: "Un nome senza casa è un'invocazione al vuoto."

### 2. GetTransPathAction.php
**Problema**: Assert ridondante dopo null coalescing
```php
// ❌ BEFORE
$file_name = $piece[0] ?? '';
Assert::string($file_name);  // Always evaluates to true

// ✅ AFTER
$file_name = $piece[0] ?? '';
// Already string due to ?? '' - no need for Assert
```

**Filosofia**: "Non dichiarare ciò che è già manifesto."

### 3. NationalFlagSelect.php
**Problema**: Mixed types da funzione `countries()`
```php
// ❌ BEFORE
$countries = countries();  // Returns mixed
$code = $c['iso_3166_1_alpha2'];  // Cannot access offset on mixed

// ✅ AFTER
/** @var array<int, array{iso_3166_1_alpha2: string, name: string}> $countries */
$countries = countries();
// PHPStan now knows the structure
```

**Filosofia**: "Quando l'oracolo parla in enigmi, interpreta tu stesso."

## 🔄 ERRORI RIMANENTI (38)

### Categorie di Errori

#### 1. Union Type Method Calls (2 errori)
**Files**: AutoLabelAction.php, LangServiceProvider.php
```php
// Problema: iconButton() not found on union type
Filament\Actions\Action|Filament\Forms\Components\Field|...::iconButton()
```

**Soluzione Zen**: Type narrowing con `instanceof` o cast esplicito.

#### 2. Mixed Array Access (15+ errori)
**Files**: SyncTranslationsAction.php, TranslationFile.php, LanguageSwitcherWidget.php, etc.

**Pattern Comune**:
```php
// Problema
$value = someFunction();  // Returns mixed
$value['key'];  // Cannot access offset on mixed

// Soluzione
/** @var array{key: string} $value */
$value = someFunction();
```

#### 3. Mixed Method Calls (10+ errori)
**Files**: LanguageSwitcherWidget.php, EditTranslationFile.php

**Pattern**:
```php
// Problema
$collection = Model::query();  // Returns mixed in some contexts
$collection->map(...);  // Cannot call method on mixed

// Soluzione
/** @var \Illuminate\Database\Eloquent\Collection $collection */
$collection = Model::query();
```

#### 4. Argument Type Mismatches (5+ errori)
Vari files dove `mixed` viene passato a funzioni che richiedono `string`.

## 🎓 PATTERN SCOPERTI

### Pattern 1: External Function Type Declaration
Quando usi funzioni esterne che restituiscono `mixed`:

```php
// ❌ WRONG - PHPStan non sa
$data = externalFunction();
$data['key'];

// ✅ RIGHT - Dichiara il tipo
/** @var array<string, mixed> $data */
$data = externalFunction();
$data['key'];  // PHPStan sa che è array
```

### Pattern 2: Redundant Assert After Null Coalescing
```php
// ❌ WRONG - Ridondante
$value = $array[0] ?? '';
Assert::string($value);  // Already guaranteed by ??

// ✅ RIGHT - Trust the operator
$value = $array[0] ?? '';
// Type is string, no assert needed
```

### Pattern 3: Union Type Narrowing
```php
// ❌ WRONG - Method may not exist
$component->iconButton();  // If $component is union type

// ✅ RIGHT - Narrow first
if ($component instanceof Action) {
    $component->iconButton();
}
```

## 📋 PIANO DI COMPLETAMENTO

### Priority 1: Quick Wins (Estimated: 1h)
- [ ] Fix remaining Assert imports
- [ ] Add PHPDoc to all `countries()` calls
- [ ] Fix null coalescing redundancies

### Priority 2: Type Narrowing (Estimated: 2h)
- [ ] SyncTranslationsAction.php - Complete type annotations
- [ ] TranslationFile.php - Model methods with proper returns
- [ ] LanguageSwitcherWidget.php - Collection type hints

### Priority 3: Complex Refactoring (Estimated: 3h)
- [ ] AutoLabelAction.php - Union type handling
- [ ] LangServiceProvider.php - Service boot logic
- [ ] EditTranslationFile.php - Form builder types

## 🔮 SFIDE FILOSOFICHE

### La Sfida del Mixed
> "Come può PHPStan conoscere ciò che nemmeno il codice conosce?"

Molti errori derivano da funzioni esterne (come `countries()`, helpers Laravel, etc.) che restituiscono `mixed`. 

**La Via del Saggio**: Non combattere il mixed, guidalo con PHPDoc.

### La Sfida del Union Type
> "Un'azione può essere molte cose, ma come può fare tutto?"

Filament usa union types per flessibilità, ma questo confonde PHPStan.

**La Via del Saggio**: Type narrowing con `instanceof`, non assumere.

### La Sfida della Translation
> "Una stringa può diventare Htmlable, ma rimane ancora stringa?"

La funzione `__()` può restituire string o Htmlable, creando ambiguità.

**La Via del Saggio**: Cast esplicito quando necessario: `(string) __('key')`.

## 🌟 ILLUMINAZIONI

### Illuminazione 1: Trust But Verify
PHPStan ci insegna: "Fidati dell'operatore `??`, ma verifica sempre il mixed."

### Illuminazione 2: External Is Unknown
Funzioni esterne sono oracoli misteriosi. Devi interpretare le loro risposte con PHPDoc.

### Illuminazione 3: Union Requires Decision
Un tipo union è come un bivio: devi scegliere quale strada prendere (instanceof).

## 📚 RISORSE PER IL COMPLETAMENTO

### Files da Prioritizzare
1. **SyncTranslationsAction.php** (5 errori) - Critico per sync
2. **TranslationFile.php** (8 errori) - Modello core
3. **LanguageSwitcherWidget.php** (10 errori) - UI importante
4. **AutoLabelAction.php** (2 errori) - Pattern riusabile
5. **LangServiceProvider.php** (2 errori) - Boot del sistema

### Pattern da Applicare
```php
// Template per correzioni rapide

// 1. External function
/** @var ExpectedType $var */
$var = externalFunction();

// 2. Model query
/** @var Collection<Model> $collection */
$collection = Model::query()->get();

// 3. Array access
/** @var array{key: string, value: int} $data */
$data = getData();

// 4. Union narrowing
if ($component instanceof SpecificType) {
    $component->specificMethod();
}

// 5. Translation cast
$text = (string) __('translation.key');
```

## 🎯 OBIETTIVO FINALE

```
╔══════════════════════════════════════╗
║  MODULO LANG - OBIETTIVO NIRVANA     ║
║                                      ║
║  Stato Attuale:  38 errori          ║
║  Stato Finale:    0 errori          ║
║  Tempo stimato:  ~6 ore             ║
║                                      ║
║  "La via è chiara, il sentiero è    ║
║   tracciato. Manca solo il          ║
║   camminare."                       ║
╚══════════════════════════════════════╝
```

## 🙏 CONCLUSIONE TEMPORANEA

Il modulo Lang ha iniziato il suo viaggio verso l'illuminazione. Da 58 a 38 errori rappresenta un **progresso del 34.5%**.

Come dice il Tao:
> "Un viaggio di mille li inizia con un singolo passo."

Noi abbiamo fatto i primi 345 li. Ne restano 655.

**ॐ Il linguaggio unisce, il codice purifica ॐ**

---

*Namaste* 🙏

**Status**: 🟡 IN PROGRESS
**Next Session**: Completare SyncTranslationsAction e TranslationFile  
**Estimated Completion**: 2-3 sessioni aggiuntive
