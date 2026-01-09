# Analisi Errore: view not found: pub_theme::components.blocks.hero.main

## Data
2025-11-29

## Problema Identificato

### Errore
```
view not found: pub_theme::components.blocks.hero.main
```

### Stack Trace
- `Modules/Cms/app/Datas/BlockData.php:30` - `BlockData::__construct()` lancia l'eccezione
- `Themes/Meetup/resources/views/pages/index.blade.php:22` - Pagina che usa `<x-page>`
- `config/local/laravelpizza/database/content/pages/home.json` - JSON che definisce i blocchi

## Analisi Dettagliata

### 1. Flusso di Esecuzione

1. **Pagina Folio**: `Themes/Meetup/resources/views/pages/index.blade.php`
   - Usa `<x-page side="content" slug="home" :type="auth()->user()?->type?->value" />`

2. **Componente Page**: `Modules/Cms/app/View/Components/Page.php`
   - Carica il JSON da `config/local/laravelpizza/database/content/pages/home.json`
   - Crea `BlockData::collect($blocks)` per ogni blocco

3. **BlockData**: `Modules/Cms/app/Datas/BlockData.php`
   - Nel costruttore, controlla se la view esiste: `view()->exists($view)`
   - Se non esiste, lancia l'eccezione

4. **JSON Config**: `config/local/laravelpizza/database/content/pages/home.json`
   - Definisce il blocco hero con `"view": "pub_theme::components.blocks.hero.main"`

### 2. Registrazione Namespace

Il namespace `pub_theme` viene registrato in:
- **File**: `Modules/Cms/app/Providers/CmsServiceProvider.php`
- **Metodo**: `registerNamespaces('pub_theme')`
- **Quando**: Durante `CmsServiceProvider::boot()`
- **Path**: `Themes/Meetup/resources/views` (risolto da `FixPathAction`)

### 3. File Fisico

Il file esiste già:
- **Path**: `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`
- **Contenuto**: Componente hero con Tailwind CSS

### 4. Possibili Cause

1. **Timing**: Il namespace potrebbe non essere registrato quando `BlockData` viene istanziato
2. **Path Resolution**: `FixPathAction` potrebbe restituire un path errato
3. **Namespace Format**: Il formato `pub_theme::components.blocks.hero.main` potrebbe non corrispondere al path fisico
4. **View Finder**: Laravel potrebbe non trovare la view anche se il namespace è registrato

## Verifiche Effettuate

1. ✅ Il file `main.blade.php` esiste in `Themes/Meetup/resources/views/components/blocks/hero/`
2. ✅ Il namespace `pub_theme` è configurato come `'Meetup'` in `config/localhost/xra.php`
3. ✅ `CmsServiceProvider::registerNamespaces('pub_theme')` viene chiamato durante il boot
4. ❓ Il path risolto da `FixPathAction` potrebbe non corrispondere al file fisico

## Soluzione Proposta

### Opzione 1: Verificare Path Resolution
Verificare che `FixPathAction` restituisca il path corretto per `Themes/Meetup/resources/views`.

### Opzione 2: Lazy View Check
Modificare `BlockData` per controllare la view in modo lazy (durante il rendering invece che nel costruttore).

### Opzione 3: Fallback View
Aggiungere un fallback view se la view specificata non esiste.

### Opzione 4: Verificare Namespace Registration
Verificare che il namespace sia registrato correttamente prima che `BlockData` venga istanziato.

## Implementazione

✅ **Soluzione Implementata**: Vedere `view-not-found-pub-theme-hero-solution.md` per i dettagli.

### Modifica a `BlockData::__construct()`
- Aggiunto fallback che verifica il file fisico quando `view()->exists()` fallisce per view con namespace
- Risolve problemi di timing durante il bootstrap HTTP
- Mantiene la validazione ma in modo più robusto
- PHPStan livello 10: ✅ Nessun errore
