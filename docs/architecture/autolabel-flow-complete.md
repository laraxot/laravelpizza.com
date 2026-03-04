# AutoLabel Flow - Analisi Completa del Flusso

**Tipo**: Documentazione Tecnica Approfondita
**Audience**: Sviluppatori che devono comprendere il meccanismo interno

---

## 📋 Indice

1. [Overview](#overview)
2. [Flusso Step-by-Step](#flusso-step-by-step)
3. [Componenti Coinvolti](#componenti-coinvolti)
4. [Esempio Pratico Completo](#esempio-pratico-completo)
5. [Edge Cases e Fallback](#edge-cases-e-fallback)
6. [Performance e Caching](#performance-e-caching)

---

## Overview

Il sistema AutoLabel intercetta OGNI componente Filament creato e:
1. Estrae il backtrace per identificare la classe che lo ha creato
2. Genera una chiave di traduzione strutturata
3. Cerca la traduzione nei file del modulo
4. Se mancante, la crea automaticamente
5. Applica la traduzione al componente

**Tutto questo avviene AUTOMATICAMENTE, senza intervento dello sviluppatore.**

---

## Flusso Step-by-Step

### Step 1: Registrazione Interceptor

**File**: `LangServiceProvider.php` (boot method)

```php
public function boot(): void
{
    parent::boot();

    // Registra interceptor per Field
    Field::configureUsing(function (Field $component) {
        // label
        $component = app(AutoLabelAction::class)->execute($component);

        // validation messages (required, email, ecc.)
        $component = $this->setValidMessages($component);

        // placeholder
        $component = app(AutoLabelAction::class)->execute($component, 'placeholder');

        // helperText
        $component = app(AutoLabelAction::class)->execute($component, 'helperText');

        // description
        return app(AutoLabelAction::class)->execute($component, 'description');
    });

    // Registra interceptor per Section
    Section::configureUsing(function (Section $component) {
        $component = app(AutoLabelAction::class)->execute($component);
        return app(AutoLabelAction::class)->execute($component, 'heading');
    });

    // Registra interceptor per Column
    Column::configureUsing(function (Column $component) {
        $component = app(AutoLabelAction::class)->execute($component);
        return $component->wrapHeader()->verticallyAlignStart()->grow();
    });

    // Registra interceptor per Action
    Action::configureUsing(function (Action $component) {
        $component = app(AutoLabelAction::class)->execute($component);
        $component = app(AutoLabelAction::class)->execute($component, 'icon');
        return app(AutoLabelAction::class)->execute($component, 'tooltip');
    });
}
```

**Quando avviene**: All'avvio dell'applicazione, nel boot del ServiceProvider.

**Cosa fa**: Registra delle callback che Filament chiamerà per OGNI componente creato.

---

### Step 2: Intercettazione Componente

**Quando**: Ogni volta che viene creato un `TextInput::make('name')` o altro componente.

**File**: `AutoLabelAction.php` (execute method)

```php
public function execute(
    Field|BaseFilter|Column|Step|Action|Section $component,
    string $type = 'label'
): Field|BaseFilter|Column|Step|Action|Section
{
    // Il componente appena creato viene passato qui
    // $type indica quale attributo stiamo gestendo: label, placeholder, helperText, ecc.

    // Continua al passo successivo...
}
```

---

### Step 3: Estrazione Backtrace

**File**: `AutoLabelAction.php` (riga 31-60)

```php
// Ottiene il backtrace completo
$backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);

// Filtra per trovare la prima classe in Modules\ che ha creato il componente
$backtrace_slice = array_slice($backtrace, 3, 7);

$class = Arr::first($backtrace_slice, function ($item) use ($component) {
    if (! isset($item['object'])) {
        return false;
    }

    // Cerca classe che inizia con 'Modules\'
    if (Str::startsWith($item['object']::class, 'Modules\\')) {
        // Ma non il component stesso
        if (get_class($component) !== get_class($item['object'])) {
            return true;
        }
    }

    return false;
});
```

**Risultato esempio**:
```php
$class = [
    'object' => PageResource instance,
    'class' => 'Modules\Cms\Filament\Resources\PageResource',
    'function' => 'getFormSchema',
    ...
];
```

---

### Step 4: Generazione Namespace

**File**: `AutoLabelAction.php` (riga 62-68)

```php
if (is_array($class)) {
    $object_class = $class['object']::class;
    $trans_key = app(GetTransKeyAction::class)->execute($object_class);
} else {
    // Fallback se non trova classe
    $trans_key = 'lang::txt';
}
```

**File**: `GetTransKeyAction.php`

```php
public function execute(string $class = ''): string
{
    // Input: 'Modules\Cms\Filament\Resources\PageResource'

    $arr = explode('\\', $class);
    // ['Modules', 'Cms', 'Filament', 'Resources', 'PageResource']

    $module = $arr[1];  // 'Cms'
    $module_low = mb_strtolower($module);  // 'cms'

    $type = Str::singular($arr[count($arr) - 2]);  // 'Resource'
    $class_name = $arr[count($arr) - 1];  // 'PageResource'

    // Rimuove suffisso 'Resource'
    if (Str::endsWith($class_name, $type)) {
        $class_name = Str::beforeLast($class_name, $type);  // 'Page'
    }

    $class_snake = Str::of($class_name)->snake()->toString();  // 'page'

    return $module_low.'::'.$class_snake;  // 'cms::page'
}
```

**Risultato**: `'cms::page'`

---

### Step 5: Determinazione Tipo Componente

**File**: `AutoLabelAction.php` (riga 70-100)

```php
// Estrae il valore del componente (es: 'title' per TextInput::make('title'))
$val = null;

if ($component instanceof Step) {
    $val = $component->getId();  // Per wizard steps
    $label_tkey = $trans_key.'.steps.'.$val.'';
}

if ($label_tkey === null && $component instanceof Section) {
    // Section può avere heading
    $label_tkey = $trans_key.'.sections.'.$val.'';
}

if ($label_tkey === null && method_exists($component, 'getName')) {
    $val = $component->getName();  // 'title'

    // ← QUI È CRITICO: hardcoded '.fields.'
    $label_tkey = $trans_key.'.fields.'.$val.'';
    // Risultato: 'cms::page.fields.title'
}

if ($component instanceof Action) {
    $val = $component->getName();
    $label_tkey = $trans_key.'.actions.'.$val.'';
}
```

**Risultato esempio**: `'cms::page.fields.title'`

---

### Step 6: Aggiunta Attributo

**File**: `AutoLabelAction.php` (riga 133)

```php
// Aggiunge il tipo di attributo alla chiave
$label_key = $label_tkey.'.'.Str::snake($type);

// $type può essere: 'label', 'placeholder', 'helperText', 'description', 'tooltip'
// Str::snake('helperText') → 'helper_text'
```

**Risultato finale**:
```php
// Per label:
'cms::page.fields.title.label'

// Per placeholder:
'cms::page.fields.title.placeholder'

// Per helperText:
'cms::page.fields.title.helper_text'
```

---

### Step 7: Caricamento Traduzione

**File**: `AutoLabelAction.php` (riga 135-150)

```php
// Usa la funzione trans() di Laravel
$label = trans($label_key);

// Se la traduzione non esiste, trans() ritorna la chiave stessa
if (is_string($label) && $label_key === $label) {
    // Traduzione mancante → Salvala automaticamente
    app(SaveTransAction::class)->execute($label_key, $val);

    // Riprova a caricarla
    $label = trans($label_key);
}
```

**File**: `SaveTransAction.php` (per traduzioni mancanti)

```php
public function execute(string $key, int|string|array|Htmlable|null $data): void
{
    // Input: 'cms::page.fields.title.label', 'title'

    // 1. Determina il file da modificare
    $filename = app(GetTransPathAction::class)->execute($key);
    // Risultato: 'Modules/Cms/lang/it/fields.php'

    // 2. Carica il contenuto attuale
    if (! File::exists($filename)) {
        // Crea il file se non esiste
        app(SaveArrayAction::class)->execute([], $filename);
    }

    $cont = File::getRequire($filename);
    // Ottiene l'array da fields.php

    // 3. Estrae il path della chiave (rimuove namespace e nome file)
    $piece = implode('.', array_slice(explode('.', $key), 1));
    // 'cms::page.fields.title.label' → 'page.fields.title.label'
    // Ma poi rimuove 'fields' (nome file) → 'title.label'

    // 4. Imposta il valore nell'array
    Arr::set($cont, $piece, $data);
    // $cont['title']['label'] = 'title';

    // 5. Salva il file
    app(SaveArrayAction::class)->execute($cont, $filename);
}
```

**Risultato**: Se mancante, aggiunge in `fields.php`:
```php
'title' => [
    'label' => 'title',  // Valore fallback
],
```

---

### Step 8: Applicazione al Componente

**File**: `AutoLabelAction.php` (riga 152-160)

```php
// Applica la traduzione al componente
if (strip_tags($label) !== $label && in_array($type, ['helperText'])) {
    // Se contiene HTML (es: helperText con tag), usa HtmlString
    $component->{$type}(new HtmlString($label));
} else {
    // Altrimenti applica come stringa normale
    $component->{$type}($label);
}

return $component;
```

**Risultato**: Il componente ora ha il suo attributo impostato:
```php
// Prima:
TextInput::make('title')

// Dopo AutoLabelAction:
TextInput::make('title')->label('Titolo')->placeholder('Inserisci il titolo')
```

---

## Componenti Coinvolti

### 1. LangServiceProvider

**Ruolo**: Registra gli interceptor per ogni tipo di componente Filament

**File**: `Modules/Lang/app/Providers/LangServiceProvider.php`

**Metodi chiave**:
- `boot()`: Registrazione interceptor
- `registerFilamentLabel()`: Setup callback configureUsing
- `translatableComponents()`: Componenti custom aggiuntivi

---

### 2. AutoLabelAction

**Ruolo**: Core del sistema - gestisce l'intero flusso di auto-label

**File**: `Modules/Lang/app/Actions/Filament/AutoLabelAction.php`

**Metodi chiave**:
- `execute()`: Flusso principale
- Estrae backtrace
- Genera chiave traduzione
- Carica o crea traduzione
- Applica al componente

---

### 3. GetTransKeyAction

**Ruolo**: Genera il namespace della traduzione dal backtrace

**File**: `Modules/Xot/app/Actions/GetTransKeyAction.php`

**Input**: `'Modules\Cms\Filament\Resources\PageResource'`
**Output**: `'cms::page'`

**Logica**:
1. Estrae il nome del modulo (arr[1])
2. Estrae il nome della classe (ultimo elemento)
3. Rimuove il suffisso 'Resource', 'Widget', ecc.
4. Converte in snake_case
5. Combina: `{module}::{class}`

---

### 4. GetTransPathAction

**Ruolo**: Localizza il file di traduzione da modificare

**File**: `Modules/Lang/app/Actions/GetTransPathAction.php`

**Input**: `'cms::page.fields.title.label'`
**Output**: `'Modules/Cms/lang/it/fields.php'`

**Logica**:
1. Estrae namespace (`cms`)
2. Estrae nome file (primo elemento dopo `::` → `fields`)
3. Costruisce path: `Modules/{Module}/lang/{locale}/{file}.php`

---

### 5. SaveTransAction

**Ruolo**: Salva traduzioni mancanti automaticamente

**File**: `Modules/Lang/app/Actions/SaveTransAction.php`

**Input**:
- Chiave: `'cms::page.fields.title.label'`
- Valore: `'title'` (fallback)

**Output**: Aggiorna `fields.php` con la nuova chiave

**Logica**:
1. Localizza il file con GetTransPathAction
2. Carica contenuto attuale
3. Aggiunge chiave nidificata con Arr::set()
4. Salva il file aggiornato

---

### 6. TranslatorService

**Ruolo**: Traccia chiavi mancanti nel database

**File**: `Modules/Lang/app/Services/TranslatorService.php`

**Estende**: `Illuminate\Translation\Translator`

**Override**: `get()` method

**Logica**:
1. Chiama parent::get()
2. Se traduzione mancante (ritorna la chiave)
3. Crea record nel database Translation
4. Riprova con fallback

**Beneficio**: Visibilità completa sulle traduzioni mancanti tramite admin panel

---

## Esempio Pratico Completo

### Scenario: Creare PageResource nel modulo Cms

#### Step 1: Developer Scrive il Resource

```php
<?php
// File: Modules/Cms/app/Filament/Resources/PageResource.php

namespace Modules\Cms\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class PageResource extends XotBaseResource
{
    protected static ?string $model = Page::class;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('slug')->required(),
            Textarea::make('content'),
        ];
    }
}
```

**Nota**: Nessuna label definita!

---

#### Step 2: Filament Crea il Form

Quando l'utente visita la pagina, Filament esegue:
```php
$schema = PageResource::getFormSchema();
```

Questo crea 3 componenti:
1. `TextInput::make('title')`
2. `TextInput::make('slug')`
3. `Textarea::make('content')`

---

#### Step 3: AutoLabelAction Intercetta

Per ogni componente, Filament chiama:
```php
Field::configureUsing(function (Field $component) {
    return app(AutoLabelAction::class)->execute($component);
});
```

---

#### Step 4: Primo Campo 'title'

**AutoLabelAction riceve**: `TextInput` con name='title'

**Estrae backtrace**: Trova `PageResource`

**Genera namespace**: `'cms::page'` (da `GetTransKeyAction`)

**Determina tipo**: È un Field → usa `.fields.`

**Costruisce chiave**: `'cms::page.fields.title.label'`

**Cerca traduzione**: `trans('cms::page.fields.title.label')`

**Risultato iniziale**: Traduzione non esiste (ritorna la chiave)

**SaveTransAction**: Crea automaticamente in `Modules/Cms/lang/it/fields.php`:
```php
'title' => [
    'label' => 'title',  // Fallback
],
```

**Applica al componente**: `->label('title')`

---

#### Step 5: Developer Migliora la Traduzione

Developer apre `Modules/Cms/lang/it/fields.php` e migliora:
```php
<?php
declare(strict_types=1);

return [
    'title' => [
        'label' => 'Titolo',
        'placeholder' => 'Inserisci il titolo della pagina',
        'help' => 'Il titolo apparirà nell\'elenco',
    ],
    'slug' => [
        'label' => 'Slug',
        'placeholder' => 'slug-url-friendly',
        'help' => 'URL univoco per la pagina',
    ],
    'content' => [
        'label' => 'Contenuto',
        'placeholder' => 'Scrivi qui il contenuto...',
        'help' => 'Supporta Markdown',
    ],
];
```

---

#### Step 6: Refresh Pagina

Filament riesegue AutoLabelAction:

**Per 'title'**:
- Cerca: `trans('cms::page.fields.title.label')`
- Trova: `'Titolo'` ✅
- Applica: `->label('Titolo')`

**Per 'title' placeholder**:
- Cerca: `trans('cms::page.fields.title.placeholder')`
- Trova: `'Inserisci il titolo della pagina'` ✅
- Applica: `->placeholder('Inserisci il titolo della pagina')`

**Risultato finale**: Form completamente tradotto senza toccare il Resource!

---

## Edge Cases e Fallback

### Case 1: File fields.php Mancante

**Scenario**: Modulo nuovo, nessun file traduzione

**Comportamento**:
1. `GetTransPathAction` ritorna path: `Modules/NewModule/lang/it/fields.php`
2. `SaveTransAction` verifica con `File::exists()` → false
3. `SaveTransAction` crea il file vuoto
4. Aggiunge la prima chiave
5. Salva il file

**Risultato**: File creato automaticamente!

---

### Case 2: Struttura Nidificata Profonda

**Scenario**: Field nidificato come `author.email`

**Comportamento**:
```php
TextInput::make('author.email')

// AutoLabelAction genera:
'cms::page.fields.author.email.label'

// In fields.php cerca:
$translations['author']['email']['label']

// Se manca, SaveTransAction usa Arr::set():
Arr::set($cont, 'author.email.label', 'author.email');

// Risultato in fields.php:
'author' => [
    'email' => [
        'label' => 'author.email',
    ],
],
```

---

### Case 3: Componente Senza getName()

**Scenario**: Componente custom che non ha il metodo `getName()`

**Comportamento**:
```php
if ($label_tkey === null && method_exists($component, 'getName')) {
    // Salta questo blocco
}

// Fallback: usa 'lang::txt'
$trans_key = 'lang::txt';
```

**Risultato**: Cerca traduzione in modulo Lang generico

---

### Case 4: HTML in Traduzione

**Scenario**: helperText con tag HTML

```php
'content' => [
    'help' => 'Supporta <strong>Markdown</strong>',
],
```

**Comportamento**:
```php
$label = 'Supporta <strong>Markdown</strong>';

if (strip_tags($label) !== $label && in_array($type, ['helperText'])) {
    // Contiene HTML → Usa HtmlString per renderizzare
    $component->helperText(new HtmlString($label));
}
```

**Risultato**: HTML renderizzato correttamente

---

### Case 5: Traduzione Non Stringa

**Scenario**: Valore traduzione è array invece di stringa

```php
'title' => [
    'label' => ['it' => 'Titolo', 'en' => 'Title'],  // Array!
],
```

**Comportamento**:
```php
$label = trans('cms::page.fields.title.label');
// Risultato: ['it' => 'Titolo', 'en' => 'Title']

if (is_string($label) && $label_key === $label) {
    // Non è stringa → Salta
}

// Tenta di applicare array al componente
$component->label($label);
// Filament converte array in stringa → errore o fallback
```

**Soluzione**: Evitare array in traduzioni per label - usare solo stringhe

---

## Performance e Caching

### Caching Traduzioni

Laravel cached automaticamente le traduzioni:
```php
// config/cache.php
'stores' => [
    'translations' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/translations'),
    ],
],
```

**Lifetime**: Fino a `php artisan cache:clear`

---

### Optimizzazione Backtrace

Il backtrace può essere costoso:
```php
$backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);
//                           ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^   ^
//                           Fornisce oggetti, max 10 livelli
```

**Perché limitare a 10**: Bilancia tra trovare la classe giusta e performance

---

### Lazy Loading File Traduzione

Laravel carica file traduzione on-demand:
```php
$label = trans('cms::page.fields.title.label');
// Solo ora Laravel carica Modules/Cms/lang/it/fields.php
```

Non carica tutti i file all'avvio → Performance migliori

---

### SaveTransAction - Scrittura Minimale

Quando salva una nuova chiave:
```php
// Carica solo il file necessario
$cont = File::getRequire($filename);

// Modifica solo la chiave
Arr::set($cont, $piece, $data);

// Salva solo quel file
app(SaveArrayAction::class)->execute($cont, $filename);
```

Non tocca altri file → Performance ottimali

---

## Troubleshooting

### Issue 1: Label Non Appare

**Sintomi**: Campo form senza label

**Cause possibili**:
1. File `fields.php` mancante
2. Struttura nidificata errata
3. Cache traduzione vecchia
4. ServiceProvider non registrato

**Debug**:
```php
// 1. Verifica file esiste
ls Modules/{Module}/lang/it/fields.php

// 2. Verifica struttura
cat Modules/{Module}/lang/it/fields.php

// 3. Pulisci cache
php artisan cache:clear

// 4. Verifica provider registrato
php artisan about
```

---

### Issue 2: Label Sbagliata

**Sintomi**: Label mostra valore errato o chiave

**Cause possibili**:
1. Chiave nidificata errata in fields.php
2. Namespace sbagliato (modulo errato)
3. Cache vecchia

**Debug**:
```php
// 1. Traccia chiave generata
dd(trans('cms::page.fields.title.label'));

// 2. Controlla namespace
// In AutoLabelAction, aggiungi:
dd($trans_key);  // Dovrebbe essere 'cms::page'

// 3. Pulisci cache
php artisan cache:clear
php artisan config:clear
```

---

### Issue 3: Traduzioni Non Salvate

**Sintomi**: SaveTransAction non crea/aggiorna fields.php

**Cause possibili**:
1. Permessi file/directory
2. Directory `lang/` mancante
3. SaveArrayAction failure

**Debug**:
```bash
# 1. Verifica permessi
ls -la Modules/{Module}/lang/it/

# 2. Crea directory se manca
mkdir -p Modules/{Module}/lang/it/

# 3. Test manuale SaveTransAction
php artisan tinker
>>> app(\Modules\Lang\app\Actions\SaveTransAction::class)
    ->execute('cms::page.fields.test.label', 'Test');
```

---

## Conclusione

Il sistema AutoLabel è un **meccanismo sofisticato ma elegante** che:

1. ✅ **Elimina boilerplate** - Zero label hardcoded
2. ✅ **Auto-discovery** - Trova automaticamente il modulo
3. ✅ **Auto-creation** - Crea traduzioni mancanti
4. ✅ **Flessibile** - Supporta nesting, HTML, fallback
5. ✅ **Performante** - Caching, lazy loading, scrittura minimale
6. ✅ **Tracciabile** - Database tracking chiavi mancanti

**Il file `fields.php` è il cuore del sistema** - contiene la struttura gerarchica che AutoLabel cerca per ogni campo.

**Senza `fields.php`, il sistema fallisce completamente.**

---

**Versione**: 1.0
**Autore**: System Architect
**Ultima Revisione**: 2026-01-09
