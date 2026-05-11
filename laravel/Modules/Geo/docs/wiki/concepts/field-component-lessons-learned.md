# Field Component Lessons Learned

## Data: 2026-04-23

Raccolta di lezioni, anti-pattern e false friends scoperti durante lo sviluppo e il fix dei componenti Geo e Filament.

---

## 1. Merge Conflict = Bootstrap Failure

### Problema

Marker di merge conflict (`<<<<<<<`, `=======`, `>>>>>>>`) in qualsiasi file PHP — anche un solo file — causano il failure totale del bootstrap Laravel. PHPStan, Pint, e qualsiasi tool che richiede l'avvio dell'app fallisce con errore generico "syntax error, unexpected token <<".

### Sintomi

```
Note: Using configuration file phpstan.neon.
Application bootstrap failed
Error: syntax error, unexpected token "<<", expecting end of file
```

### Lezione

**PRIMA di qualsiasi analisi (PHPStan, Pint, test):**

```bash
grep -rl "<<<<<<" laravel/Modules/ --include="*.php" --include="*.blade.php" | grep -v vendor | grep -v node_modules
```

Se ritorna anche un solo file — risolverlo. Un merge conflict in un solo file del Geo module blocca l'intera analisi di TUTTI i 4890 file.

### Anti-pattern

- Eseguire PHPStan senza verificare l'assenza di merge conflict → errore generico, perdita di tempo
- Cercare l'errore nel file che si stava modificando → l'errore è spesso altrove

---

## 2. Blocks Constructor Syntax — Named Arguments

### Problema

In `ThemeComposer.php`, l'istanziazione del componente `Blocks` era stata scritta così:

```php
// SBAGLIATO
$blocksComponent = new Blocks()
    view: 'ui::components.render.blocks.v1',
    blocks: $blocks,
    model: $page,
);
```

La sintassi corretta per named arguments in PHP richiede le parentesi graffe del costruttore aperte:

```php
// CORRETTO
$blocksComponent = new Blocks(
    view: 'ui::components.render.blocks.v1',
    blocks: $blocks,
    model: $page,
);
```

### Lezione

`new Blocks()` + newline + named arguments = syntax error. Il `()` vuoto chiude il costruttore, poi i named arguments sono token floating.

### Come evitarlo

Sempre aprire la graffa `(` sulla stessa riga del `new Class()` quando si usano named arguments.

---

## 3. `GeopointPicker` Blade — Funzionalità Perduta nel Conflict

### Problema

Nel file `geopoint-picker.blade.php`, il conflitto di merge aveva rimosso le funzioni `searchAddress()`, `selectAddress()`, e `handleGeopointChanged()` dal template Blade Alpine.

### Cosa era stato perso

1. **`searchAddress()`** — chiamata a `$wire.callSchemaComponentMethod()` per cercare indirizzi via API Filament
2. **`selectAddress()`** — selezione risultato ricerca → aggiornamento coordinate + Livewire state
3. **`handleGeopointChanged()`** — gestione evento cambio coordinate dal componente Lit

### Lezione

Quando si risolve un merge conflict, SEMPRE verificare che entrambe le parti del conflitto siano valutate per il loro valore — non basta scegliere "la parte più grande" o "HEAD".

---

## 4. GeopointPicker `$view` Property

### Problema

Nel file `GeopointPicker.php`, il conflitto di merge aveva rimosso completamente la proprietà `$view`:

```php
// DOPO il conflict HEAD (sbagliato - view missing)
class GeopointPicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void  // $view mancante!
```

### Lezione

Ogni Filament Field DEVE avere `protected string $view = '...'`. La rimozione di questa proprietà in un merge conflict causa errore di view non trovata a runtime — un errore che non viene catturato dall'autoloader ma solo a runtime.

---

## 5. `CoordinatePicker` — `dehydrated(false)` Importance

### Problema

Il conflitto aveva rimosso `$this->dehydrated(false)` da `CoordinatePicker::setUp()`.

### Perché è importante

Senza `dehydrated(false)`, il campo CoordinatePicker tenta di serializzare il suo stato completo nel form submit. Dato che il campo coordina la comunicazione tra il componente Lit e Livewire, la deidratazione causa duplicazione di stato e potenziali problemi di serializzazione.

### Lezione

I campi che coordinano comunicazione JS↔Livewire spesso non hanno bisogno di essere deidratati — il loro stato è gestito dal componente Lit figlio. Usare `dehydrated(false)` per prevenire duplicazione.

---

## 6. Filament Field Signature Compatibility

### Problema

`EnumSelect::make(string $name)` deve essere compatibile con `Field::make(?string $name = null)`.

### Lezione

Quando si override `make()` su un componente Filament custom:

```php
// SBAGLIATO — signature mismatch con Field::make
public static function make(string $name): static

// CORRETTO — match della signature del parent
public static function make(?string $name = null): static
```

PHPStan level max cattura questo errore, ma solo se il bootstrap non fallisce per altri errori (es. merge conflict).

---

## 7. Geo Module — Due CoordinatePicker Esistono

### Fatto Architetturale

Esistono DUE classi CoordinatePicker nel modulo Geo:

1. **`Geo/Filament/Forms/Components/CoordinatePicker.php`** — Estende `XotBaseField`, usa trait `HasCoordinatePicker`. Il componente Filament ufficiale.
2. **`Geo/Forms/Components/CoordinatePicker.php`** — Estende `Field` direttamente. Legacy / alternativa standalone.

### Lezione

Quando si importano componenti Geo, verificare SEMPRE il namespace corretto:

```php
// CORRETTO per Filament Form in progetto
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

// ATTENZIONE: questo è un altro componente simile ma diverso
// use Modules\Geo\Forms\Components\CoordinatePicker;
```

Il namespace `Geo\Filament\Forms\Components` è la fonte di verità per l'integrazione con il form builder Filament.

---

## 8. XotBaseField — `$view` Property Rule

### Best Practice

Tutte le classi che estendono `XotBaseField` DEVONO dichiarare `protected string $view`. Non viene ereditata dalla base — ogni sottoclasse è responsabile del proprio template.

### Anti-pattern

Ridefinire `$view` come ereditato da un parent intermedio. Ogni Field è proprietario del suo template.

---

## False Friends Riepilogo

| False Friend | Perché Sembra Giusto | Perché È Sbagliato |
|---|---|---|
| `new Class()` + named args newline | Sembra stile Filament chaining | PHP syntax error — `()` chiude il costruttore |
| Scegliere HEAD nel conflict | HEAD = "la nostra versione più recente" | L'altro branch può contenere funzionalità nuove necessarie |
| `make(string $name)` | La name è obbligatoria nel mio contesto | Il parent signature è `?string $name = null` |
| `$view` ereditata da XotBaseField | "La base dovrebbe gestirlo" | XotBaseField NON definisce $view — è astratta |
| `dehydrated()` opzionale | "Livewire gestisce lo stato" | Senza dehydrated(false), stato duplicato nel submit |
| Merge conflict in un file isolato | "Non tocca il mio lavoro" | Bootstrap failure → TUTTA l'analisi fallisce |
