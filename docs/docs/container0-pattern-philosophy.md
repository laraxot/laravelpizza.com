# Filosofia Architetturale: Pattern [container0] Generico

## 🎯 Principio Fondamentale: DRY + CMS-Driven + Scalabilità

Il pattern `[container0]` rappresenta la **filosofia architetturale** di LaravelPizza: **un sistema generico, scalabile e CMS-driven** che evita la creazione di directory specifiche per ogni tipo di contenuto.

## 🏛️ Filosofia: Genericità vs Specificità

### ❌ Approccio Tradizionale (Anti-Pattern)

```
pages/
├── events/
│   ├── index.blade.php
│   └── [slug].blade.php
├── articles/
│   ├── index.blade.php
│   └── [slug].blade.php
├── products/
│   ├── index.blade.php
│   └── [slug].blade.php
└── ...
```

**Problemi**:
- ❌ Duplicazione di codice: ogni directory ripete la stessa logica
- ❌ Rigidità: ogni nuovo tipo di contenuto richiede nuova directory
- ❌ Manutenzione: modifiche devono essere replicate in ogni directory
- ❌ Violazione DRY: codice ripetuto invece di pattern riusabile

### ✅ Approccio LaravelPizza (Pattern [container0])

```
pages/
├── [slug].blade.php              → /{slug} (CMS catch-all)
└── [container0]/
    ├── index.blade.php           → /{container} (CMS: events.json, articles.json, etc.)
    └── [slug].blade.php          → /{container}/{slug} (CMS: events.laravel-11.json)
```

**Vantaggi**:
- ✅ **DRY**: Un solo file gestisce tutti i contenuti nested
- ✅ **Scalabilità**: Nuovi tipi di contenuto senza modificare struttura file
- ✅ **CMS-Driven**: Contenuti definiti in JSON, non nella struttura directory
- ✅ **Manutenibilità**: Modifiche in un solo punto
- ✅ **Flessibilità**: Pattern generico adattabile a qualsiasi contenuto

## 📜 Religione: Il Contenuto è Re, la Struttura è Serva

### Principio: Separazione Contenuto/Struttura

**Il contenuto NON deve determinare la struttura dei file.**

- **Contenuto**: Definito in JSON (`config/local/laravelpizza/database/content/pages/`)
- **Struttura**: Pattern generico `[container0]/[slug0]/index.blade.php` gestisce tutto
- **Rendering**: Componente `<x-page>` carica il JSON corrispondente

### Esempio: `/it/events/laravel-beginners-pizza-night`

**Flusso Completo**:

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Folio Route: [container0]/[slug0]/index.blade.php
   ↓
3. Route Name: container0.view (Folio name)
   ↓
4. Volt Component: container0.view
   ↓
5. Variables: $container0 = 'events', $slug0 = 'laravel-beginners-pizza-night'
   ↓
6. Resolve: Se esiste modello 'Event' con slug 'laravel-beginners-pizza-night'
   ↓
7. Render: pub_theme::components.blocks.events.detail
```

**Nessuna directory `events/` necessaria!**

## 🧠 Logica: Pattern Generico = Massima Flessibilità

### Costruzione Slug Nested

```php
// [container0]/[slug0]/index.blade.php
// La pagina Folio è COMPLETAMENTE AGONISTICA
// - Estrae parametri dalla route
// - Li passa al content-resolver
// - NON contiene alcuna logica di business!
```

### Principio: Pagina Folio Agnostics

**La pagina Folio DEVE essere solo un router**, non un controller:

```
❌ SBAGLIATO: [container0]/[slug0]/index.blade.php contiene:
   - Event::where('slug', $slug)->first()
   - loadDynamicModel()
   - resolveContent()

✅ CORRETTO: [container0]/[slug0]/index.blade.php contiene SOLO:
   - Estrazione parametri ($container0, $slug0)
   - Passaggio a <x-page> con slug "container0.view"

✅ CORRETTO: Il JSON (events_view.json) definisce:
   - Quale componente renderizzare
   - I dati da passare al componente
```

### Convenzione Nomi Parametri Folio

⚠️ **IMPORTANTE**: Quando si usano due parametri nella stessa cartella, devono avere lo **stesso nome**:

- ✅ `[container0]/[slug0]/index.blade.php` - Entrambi terminano con `0`
- ❌ `[container0]/[slug]/index.blade.php` - Nomi diversi - NON FUNZIONA!

Questo è un requisito di Folio: i parametri nella stessa directory devono usare lo stesso nome con lo stesso suffisso numerico.

### Convenzione JSON

```
config/local/laravelpizza/database/content/pages/
├── events.json                           → /it/events (lista)
├── events.laravel-beginners-pizza-night.json → /it/events/laravel-beginners-pizza-night
├── articles.json                         → /it/articles (lista)
└── articles.laravel-filament-guide.json → /it/articles/laravel-filament-guide
```

**Pattern**: `{container}.{slug}.json` per pagine nested

## 🎨 Politica: Governance Unificata

### Un Solo Punto di Controllo

**Tutti i contenuti nested** sono gestiti da:
- **Un solo file Blade**: `[container0]/[slug].blade.php`
- **Un solo componente**: `<x-page>`
- **Un solo pattern**: JSON files con naming `{container}.{slug}.json`

### Vantaggi Governance

1. **Consistenza**: Tutti i contenuti nested seguono lo stesso pattern
2. **Audit**: Facile tracciare dove vengono gestiti i contenuti
3. **Testing**: Un solo file da testare per tutti i contenuti nested
4. **Onboarding**: Nuovi sviluppatori capiscono subito il pattern

## ⚡ Performance: Zero Overhead

### Nessun Costo Aggiuntivo

- ✅ **Folio Routing**: Pattern generico non aggiunge overhead
- ✅ **JSON Loading**: SushiToJsons carica solo i JSON necessari
- ✅ **Caching**: Blade views compilate una volta, riutilizzate
- ✅ **Memory**: Nessuna struttura directory in memoria

## 🔄 Scalabilità: Crescita Organica

### Aggiungere Nuovo Tipo di Contenuto

**Prima** (approccio tradizionale):
1. Creare directory `products/`
2. Creare `products/index.blade.php`
3. Creare `products/[slug].blade.php`
4. Duplicare logica da `events/`
5. Testare nuova struttura

**Ora** (pattern [container0]):
1. Creare `products.json` → `/it/products` funziona automaticamente
2. Creare `products.{slug}.json` → `/it/products/{slug}` funziona automaticamente
3. ✅ **Fatto!** Nessuna modifica ai file Blade necessaria

## 📚 Architettura Completa

### Struttura File

```
pages/
├── index.blade.php                    → / (home)
├── [slug].blade.php                   → /{slug} (CMS: home.json, about.json, etc.)
└── [container0]/
    ├── index.blade.php                → /{container} (CMS: events.json, articles.json)
    └── [slug].blade.php               → /{container}/{slug} (CMS: events.{slug}.json)
```

### Struttura JSON

```
config/local/laravelpizza/database/content/pages/
├── home.json                          → /it/home
├── about.json                         → /it/about
├── events.json                        → /it/events
├── events.laravel-beginners-pizza-night.json → /it/events/laravel-beginners-pizza-night
├── articles.json                      → /it/articles
└── articles.laravel-filament-guide.json → /it/articles/laravel-filament-guide
```

## 🚫 Anti-Pattern: Directory Specifiche

### Quando NON Usare [container0]

**Eccezioni** (solo quando necessario):

1. **Model Binding Folio**: Se serve binding diretto a modello Eloquent
   ```
   pages/events/[.Modules.Meetup.Models.Event].blade.php
   ```
   → Folio risolve automaticamente il modello Event

2. **Logica Specifica**: Se serve logica completamente diversa per un tipo di contenuto
   ```
   pages/auth/login.blade.php  → Logica autenticazione specifica
   ```

**Regola**: Usa directory specifiche SOLO se c'è una ragione tecnica forte, non per organizzazione.

## ✅ Best Practices

1. **Sempre usare [container0]** per contenuti CMS-driven nested
2. **Naming JSON**: `{container}.{slug}.json` per pagine nested
3. **Slug Construction**: `$container0 . '.' . $slug` nel Blade
4. **Model Detail Pattern**: Per il rendering dei dettagli dei modelli (es. Eventi), si usa lo slug `[container0].view` (es. `events.view`). Questo JSON definisce quali blocchi usare per visualizzare il modello risolto.
5. **Evitare directory specifiche** a meno di necessità tecniche
5. **Documentare eccezioni** quando si usa directory specifica
6. **Mai importare modelli** nel file routing (`[container0]/[slug0]/index.blade.php`)
7. **Mai fare query** nel file routing
8. **Mai decidere quale componente renderizzare** nel routing - lasciare che il JSON lo definisca

Vedi: [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)

## 🔗 Riferimenti

- [Folio Container Routing Priority](folio-container-routing-priority.md)
- [Folio Routing](folio-routing.md)
- [System Architecture Complete](system-architecture-complete.md)
- [CMS JSON Content System](../../modules/cms/docs/json-content-system-architecture.md)
