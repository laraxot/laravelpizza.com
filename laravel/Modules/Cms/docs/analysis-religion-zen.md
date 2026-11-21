---
title: "analysis religion zen"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "analysis religion zen"
issues: []
discussions: []
---

# Cms Module: Complete Analysis (Religion, Philosophy, Politics, Zen)

---

title: "analysis religion zen"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "analysis religion zen"
issues: []
discussions: []
## Analisi del modulo

Il modulo Cms è il cuore del content management del progetto Laraxot. Gestisce pagine, sezioni e blocchi di contenuto con un approccio headless: il CMS si occupa della struttura e dei dati, il tema della presentazione. Utilizza Filament per l'interfaccia admin, Folio per il routing front-end, e Volt per l'interattivita.

**Modelli principali**: Page, Section, PageContent, Block, Attachment, Menu, Conf
**Actions**: BuildPageSchemaAction, ResolveBlockQueryAction, GetViewThemeByViewAction, ResolvePageAction, ecc.
**Dipendenze**: Xot, UI, Tenant, Lang (tutte interne, zero pacchetti esterni)

---

## Religione

1. **Nessun dipendenza esterna** — Il Cms non richiede pacchetti Packagist. Tutto e costruito con classi interne e Filament nativo.
2. **Content is blocks** — Ogni contenuto e un array di blocchi, mai HTML inline nei dati.
3. **Separation of Concerns** — CMS gestisce struttura/dati, tema gestisce layout/CSS/JS.
4. **Schema-driven validation** — Ogni blocco definisce il proprio schema di validazione.
5. **JSON persistence** — I blocchi sono memorizzati come array JSON nel DB.
6. **Zero magic** — Niente nesting automatico, niente interpolazione segreta. Un blocco e un oggetto con type + data + view.
7. **Block registration via UI** — I blocchi sono scoperti dinamicamente dal modulo UI, non hardcoded nel CMS.
8. **XotBaseResource** — Mai estendere Filament direttamente.
9. **`declare(strict_types=1)`** — Obbligatorio.
10. **No Controllers FO** — Solo Filament + Folio + Volt.

---

## Filosofia

**"Content is blocks. Blocks are registered by UI. Cms orchestrates them."**

Il CMS non e un page builder visuale. E un sistema di composizione di contenuti basato su blocchi atomici. Ogni blocco ha:
- `type`: identificatore del tipo di blocco
- `data`: dati eterogenei (JSON)
- `view`: riferimento al componente Blade/Volt che lo renderizza
- `active`: flag di visibilita

La filosofia e **data-first**: i dati sono neutri, la presentazione e decisa dal tema. Questo permette:
- Cambiare tema senza toccare contenuto
- Cambiare implementazione blocco senza migrare dati
- Multi-tenancy con stesso modello CMS

---

## Politica

- **Nessun draft/publish nativo** — Tutti i record DB sono considerati live. Usa policy Filament per controllare chi puo editare.
- **Middleware a livello di pagina** — Non per singolo blocco.
- **Niente HTML nei dati** — Solo dati strutturati, mai markup.
- **Query resolution per data fetching** — Non per business logic.
- **Traduzioni via Spatie Translatable** — Un record, molte lingue, non duplicati.
- **Niente media library integrata** — URL immagini come stringhe, gestito dal tema.
- **Niente WYSIWYG** — Admin usa form strutturati Filament, non editor visuale.

---

## Scopo

Abilitare la gestione dei contenuti per il FixCity platform e per tutti i comuni del progetto Design Comuni. Risolve:
- Non hardcodare 50+ pagine comunali in Blade
- Permettere a non-sviluppatori di editare contenuti via Filament
- Separare CSS/layout (tema) da struttura contenuto (CMS)
- Routing per homepage, FAQ, pagine servizi senza controller statici

---

## Perché [perché]

**Perché non usare Fabricator?**
Fabricator e un page builder a blocchi per Filament che gestisce PageResource e routing front-end. Il Cms ha scelto di NON usarlo perche:
1. **Controllo totale** — Custom PageContentBuilder wrapper offre schema-driven validation per blocco
2. **Registrazione dinamica** — I blocchi sono scoperti via UI::GetAllBlocksAction, non registrati staticamente
3. **Persistenza JSON** — I blocchi vivono come array JSON, non come tabelle separate
4. **Separation of Concerns** — CMS non sa nulla del rendering; il tema decide come ogni blocco viene visualizzato
5. **Zero dipendenze esterne** — Nessun package di terze parti da mantenere/aggiornare
6. **Flessibilita** — Ogni blocco puo avere schema diverso, validazione propria, query resolution custom

**Perche non altri page builder?**
- Statamic: monolitico, non modulare Laravel
- WordPress/Gutenberg: UI-first, non data-first
- Strapi: servizio standalone, non embedded Laravel

---

## Zen

**"Semplicita sposata a potenza."**

Il CMS raggiunge lo zen attraverso:
1. **Single Source of Truth** — JSON (dev) o DB (prod). Niente dual-sync.
2. **Composability Without Constraint** — I blocchi sono oggetti. Nessun widget registry, nessuna validazione a livello DB.
3. **Separation of Concerns** — CMS struttura, tema bellezza. Mai mescolati.
4. **Reversibility** — JSON blocks leggibili/modificabili senza perdita di intento.
5. **Clarity** — Una pagina e una lista di blocchi + metadata. Niente magia.

**Lo zen si rompe quando**:
- I blocchi sono accoppiati ai view (type string + view reference = fragile)
- Middleware complessa cresce senza per-blocco guards
- Query resolution e usata per business logic invece che data fetching

---

## Competitors

| Competitor | Approccio | Differenza | Perche noi no |
|---|---|---|---|
| **z3d0x/filament-fabricator** | Block-based page builder skeleton con PageResource & frontend routing | Usa tabelle separate per blocchi, registro statico | Noi: JSON storage, dynamic block discovery via UI module |
| **statamic/laravel** | Flat-file CMS con field-driven forms | Monolitico, non modulare | Noi: modulare all'interno di Laravel |
| **oakmont/laravel-cms** | CMS generico Laravel | Piuttosto basico, poco estensibile | Noi: sistema a blocchi composabili |
| **orchid/platform** | Admin dashboard + CMS | Piuttosto un admin dashboard che CMS | Noi: focus puro su content management |
| **strapi** | Headless CMS standalone | Servizio separato, non embedded | Noi: embedded in Laravel, stesso deployment |
| **wordpress + gutenberg** | Block-based editing UI-first | UI-first vs data-first | Noi: data-first, piu prevedibile |
| **sanity.io** | Headless CMS cloud | Cloud service vs self-hosted | Noi: on-premise, privacy, controllo |
| **prismic** | Headless CMS con API | Sempre cloud-based | Noi: dati locali, nessun lock-in |
| **directus** | Headless CMS open source | Richiede DB separate + setup | Noi: usa stesso DB dell'app |
| **tina-cloud** | Git-based CMS | Git ops vs DB | Noi: DB per content editing workflow |
| **payload-cms** | Headless CMS Node.js | Tech stack diverso | Noi: Laravel-native |
| **keystone** | Headless CMS GraphQL | Node.js, diverso ecosistema | Noi: PHP/Laravel |
| **nova** | Admin UI Laravel (paid) | Ecessivamente opinionato | Noi: open source, Filament-based |

---

## Dove ispirarsi

| Ispirazione | Cosa prendere |
|---|---|
| **filament-fabricator** | Concetto di blocchi riutilizzabili, PageResource con routing, frontend rendering blocks |
| **statamic** | Philosophy: flat-file content, field-driven forms, tag syntax |
| **gutenberg (WP)** | Nested blocks concept (valutare per future versioni), block variation system |
| **sanity.io** | Schema-as-code, portable text model, API-first |
| **strapi** | Permission matrix (field-level, user-role), admin UX |
| **filament builder component** | Filament\Forms\Components\Builder come base per composizione blocchi |
| **spatie/laravel-translatable** | I18n approach per contenuti multilingua |
| **spatie/laravel-data** | DTOs per type-safe transfer objects (BlockData) |
| **laravel/folio** | Routing basato su filesystem per pagine front-end |
| **laravel/volt** | Single-file components per interactivity nei blocchi |
| **headless-cms pattern** | Separazione content/presentation, API-first approach |
| **atomic design** | Blocchi atomici (atomi/molecole/organismi) per composizione |
| **design-comuni** | Template comuni per comuni italiani, CMS come governance tool |

---

## Librerie da installare

### Gia incluse (interne)
- **Spatie Translatable** — I18n per campi modello
- **Spatie Data** — DTO type-safe (BlockData, ResolvePageData)
- **Spatie QueueableAction** — Per operazioni lunghe (import massivo)
- **Sushi** — In-memory models da closures (modello Conf virtuale)
- **Filament** — Admin panel per gestione Cms

### Consigliate da installare (mancanti)

**1. laravel/head — ALTA PRIORITA**
```bash
composer require laravel/head
```
**Perche**: Il CMS genera pagine HTML. laravel/head fornisce API fluente per gestire `<title>`, meta tags, Open Graph, canonical URLs, robots directives, structured data. Essenziale per:
- SEO per pagine comunali (municipio, servizi, contatti)
- Open Graph per condivisione social
- Canonical URLs per evitare duplicate content
- Robots meta per indicizzazione search engine

**Uso nel Cms**: In ogni blade template che renderizza una pagina, aggiungere:
```blade
@php
    Head::title($page->seo_title ?? $page->title);
    Head::description($page->seo_description);
    Head::canonical(route('page', ['container' => $page->container, 'slug' => $page->slug]));
    Head::og('title', $page->title);
    Head::og('description', $page->description);
    Head::og('type', 'article');
    Head::twitter('card', 'summary_large_image');
@endphp
```

**2. spatie/laravel-sitemap**
```bash
composer require spatie/laravel-sitemap
```
**Perche**: Generazione automatica sitemap XML per tutte le pagine CMS. Critico per SEO municipal sites.

**3. spatie/laravel-feed**
```bash
composer require spatie/laravel-feed
```
**Perche**: RSS feed per pagine di tipo news/eventi. Utile per comuni che pubblicano bandi, avvisi, news.

**4. spatie/laravel-medialibrary** (valutare)
```bash
composer require spatie/laravel-medialibrary
```
**Perche**: Gestione immagini/documenti allegati a pagine e blocchi. CDN proxying, resizing. Piu complesso del necessario per immagini statiche del tema, ma da valutare per blocchi content-driven.

**5. spatie/laravel-schemaless-attributes** (già in Xot, usare)
**Perche**: Per meta dati extra per pagina senza migrazione.

**6. spatie/laravel-searchable** (valutare)
```bash
composer require spatie/laravel-searchable
```
**Perche**: Full-text search across pages e sections. Alternativa a Scout/Meilisearch/Algolia per semplicita.

**7. meilisearch/meilisearch-php** o **algolia/algoliasearch-client-php**
```bash
composer require meilisearch/meilisearch-php
# oppure
composer require algolia/algoliasearch-client-php
```
**Perche**: Ricerca full-text performante su pagine CMS. Critico per siti comunali con molte pagine.

**8. laravel/scout** (se non gia presente)
```bash
composer require laravel/scout
```
**Perche**: Driver per Meilisearch/Algolia. Integrazione con Eloquent.

**9. livewire/flux** (già in Xot, usare)
**Perche**: Componenti UI per form Filament.

**10. filament/forms** (già in Xot, usare)
**Perche**: Builder component per schema blocchi.

### Da evitare (false amici)
- **TinyMCE/Markdown editor in Filament** — Non serve. Blocchi sono dati strutturati, non WYSIWYG.
- **WordPress Gutenberg approach** — Troppo complesso per uso headless. No nesting profondi.
- **Page builder visuale drag-and-drop** — Non necessario per municipal sites. Contenuto strutturato > libero.

---

## Future implementazioni

1. **Draft/Published States** — Aggiungere `status` column (draft, published, archived). Middleware filtra per published.
2. **Versioning** — Tabella `page_revisions` con snapshot JSON. Filament modal "View Changes" con diff.
3. **Scheduled Publishing** — Column `published_at` per publishing futuro.
4. **Rollback** — Version history enables revert.
5. **Block Revision History** — Tracciamento modifiche per singolo blocco.
6. **CDN Asset Pipeline** — Immagini blocchi su S3/Cloudinary. Resize via query params.
7. **Permission-Based Block Visibility** — Campo `visibility` (public, authenticated, role-based).
8. **A/B Testing Blocks** — Campo `variant_id`, `variant_percentage`. Traffic split hash-based.
9. **API Endpoints** — REST API per headless consumption (Filament API o Laravel API Resources).
10. **Full-Text Search** — Scout integration per cercare nelle pagine.
11. **Block Validation Schema** — JSON Schema validation per dati blocchi.
12. **Audit Trail UI** — Esporre created_by/updated_by in Filament.
13. **Media Library** — Media picker per blocchi con upload drag-and-drop.
14. **Nested Blocks** — Colonne > righe > blocchi. Valutare solo se serve.
15. **Block Templates** — Template predefiniti per tipi comuni di pagina.
16. **Multi-language blocks** — Traduzione a livello di blocco (non solo campo).
17. **Caching Strategy** — Cache per page rendering, invalidazione su edit.
18. **Preview Mode** — Anteprima prima di pubblicare.

---

## Cosa fare per renderlo perfetto

1. **Installare laravel/head** — Gestione meta tags per SEO. Senza questo, le pagine CMS non hanno title/meta corretti.
2. **Testare ogni tipo di blocco** — Pest tests per ogni blocco con vari configurazioni.
3. **PHPStan Level 10** su tutti i nuovi files.
4. **Coverage 85%+** con Pest per tutti i nuovi Action.
5. **Performance**: Profile block queries con DB::listen() nei test. Evitare N+1.
6. **SEO audit** — Verificare title, meta description, OG tags, canonical su tutte le pagine.
7. **Mobile-first** — Testare rendering blocchi su mobile.
8. **Accessibility** — Verificare WCAG 2.1 AA sui blocchi (alt immagini, heading hierarchy).
9. **Speed** — Lazy-load immagini, minimificare CSS/JS blocchi.
10. **Cache** — Implementare cache per page rendering (5-10 min TTL).
11. **Documentazione API** — Se si espone API headless, documentare con OpenAPI/Swagger.
12. **Tests end-to-end** — Folio render completo con pagina + blocchi + tema.

---

## Consigli, dubbi, perplessità

- **Nesting blocks**: Gutenberg usa nesting profondo (columns > rows > blocks). Noi usiamo array piatto. Da valutare se nesting e necessario per qualche use case (es. hero con colonne).
- **laravel/head integration**: Come si integra con Folio routing? Head tags sono per pagina, non per blocco. Serve un modo per impostare head a livello di pagina.
- **Block data validation**: Attualmente nessuna validazione schema per blocchi. Se un blocco ha `data: { heading: 123 }` (numero invece di stringa), non viene bloccato. Da aggiungere validazione.
- **SEO per pagine comunali**: Ogni comune ha SEO diverso. Come gestire title/meta per ogni comune? Current approach: template + variabili. Da migliorare con laravel/head.
- **Performance su molte pagine**: Se un comune ha 100+ pagine, il menu di navigazione diventa lento. Da implementare caching.
- **Multi-tenant**: Ogni tenant ha le proprie pagine? Current approach: sì, ma da verificare con test.
- **Versioning**: Quanto storage occupa una versione? Se le pagine hanno molti blocchi, le versioni possono diventare grandi.
- **Backup**: Come backup delle pagine? Esportazione JSON? Database backup standard?
- **Content staging**: Ambienti dev/staging/prod con pagine diverse. Come sincronizzare?
- **Editorial workflow**: Chi puo editare cosa? Workflow di approvazione?

---

## Best practices

1. **Nome slug consistente**: kebab-case, namespace `container.slug`. Es: `comuni.homepage`, `comuni.faq`, `events.detail`.
2. **Dati immutabili nei blocchi**: Preferisci `query` a copie statiche. Se un evento cambia data, fetch live.
3. **Schema block piccolo**: Una responsabilita per blocco. Hero blocco: heading, subheading, image, CTA. Non una pagina intera.
4. **Traduci a livello campo, non blocco**: Spatie Translatable gestisce i18n. Non duplicare blocchi per lingua.
5. **Volt per blocchi interattivi**: Se blocco ha stato (filtri, paginazione), usa Volt. Blade per rendering statico.
6. **Filament repeaters per array blocchi**: Admin crea 10 blocchi in un form; Filament serializza a JSON automaticamente.
7. **Test block resolution con factories**: Pest tests per pagine con vari configurazioni blocchi.
8. **Profile block queries**: DB::listen() nei test per evitare N+1.
9. **Versiona schema blocco**: Se cambi struttura dati blocco, documenta migrazione.
10. **Middleware con parsimonia**: Guarda pagine con auth, non singoli blocchi.
11. **Niente HTML in block data**: Solo dati strutturati. Markup nei componenti Blade/Volt.
12. **Niente logica in block data**: Query per data fetching, non business logic.
13. **Non duplicare contenuto tra lingue**: Un record, molte lingue via Spatie Translatable.
14. **Non hardcodare tipi blocco nel controller**: Delega a BlockData->view e dispatch Blade/Volt.
15. **Non mixare CMS content con theme variables**: CSS class nel contesto Blade, non nei dati.

---

## Bad practices

1. **Memorizzare logica in block data** ❌
   ```json
   { "type": "filter", "data": { "query_builder_code": "...PHP..." } }
   ```
   ✅ `{ "type": "filter", "data": { "query": { "model": "Event", "method": "upcoming" } } }`

2. **Duplicare contenuto tra lingue nel DB** ❌
   Creare record Page separati per lingua.
   ✅ Spatie Translatable JSON columns (un record, molte lingue).

3. **Hardcodare tipi blocco nel controller** ❌
   `if ($block['type'] === 'hero') { ... }`
   ✅ Delegare a `BlockData->view` e dispatch Blade/Volt.

4. **Memorizzare HTML in block data** ❌
   `{ "data": { "content": "<p>Escaped HTML...</p>" } }`
   ✅ `{ "data": { "content": "Plain text o Markdown", "view": "..." } }`

5. **Ignorare N+1 queries in block resolution** ❌
   `foreach ($blocks as $block) { $block->query(); }` (10 queries per pagina)
   ✅ Batch-load via eager loading o single query con limit.

6. **Mixare CMS content con theme variables** ❌
   Passare `$tailwind_classes` da block data a Blade.
   ✅ CSS classes in contesto Blade/componente, non nei dati.

7. **Creare "god blocks" che fanno tutto** ❌
   Un singolo blocco tipo per hero, features, testimonials.
   ✅ Un blocco per tipo UI pattern.

8. **Non validare block data nelle factories** ❌
   Creare factory records con `view` reference invalidi.
   ✅ Assert view esiste in factory e tests.

9. **Nesting profondo senza ragione** ❌
   Colonne > righe > blocchi > coloni > ...
   ✅ Array piatto. Aggiungere nesting solo se clear use case.

10. **Per-block middleware** ❌
    ```json
    { "type": "...", "middleware": ["verified"] }
    ```
    ✅ Gate a livello di pagina, non blocco.

---

## False friends

- **Fabricator e Cms**: Fabricator e un page builder a blocchi con tabelle separate. Cms usa JSON storage e discovery dinamico. Non sono intercambiabili.
- **Page e Section**: Page ha routing, Section no. Page e la pagina stessa, Section e un contenitore riutilizzabile.
- **Block e Widget**: Block e contenuto (data + view), Widget e UI component (interattivita). Non confonderli.
- **JSON storage e SQL storage**: Fabricator usa SQL per blocchi (tabelle separate). Noi usiamo JSON column. Trade-off: flessibilita vs query flexibility.
- **Static content e Dynamic content**: Block con `query` e per data fetching, non per business logic. Non confondere con blocchi statici.
- **Headless CMS e Traditional CMS**: Headless (noi) separa content da presentation. Traditional (WP) li mescola. Non usare approach WP in Cms.
- **Gutenberg e Noi**: Gutenberg ha nesting profondo e UI drag-drop. Noi abbiamo array piatto e form Filament. Non replicare Gutenberg.
- **WYSIWYG e Structured content**: WYSIWYG (TinyMCE) e per markup libero. Noi e per contenuto strutturato. Non usare WYSIWYG nei blocchi.
- **Spatie Translatable e Translation files**: Translatable e per campi DB, lang files sono per UI strings. Non confonderli.
- **Filament Builder e Custom Builder**: Filament Builder e generico. Il nostro PageContentBuilder e specifico per CMS. Non usare Builder direttamente.

---

## Come usare il modulo

### Step 1: Creare una pagina via Filament
1. Naviga in **Admin > CMS > Pages**
2. Click **Create Page**
3. Compila:
   - **Title** (translatable): "Richieste di Intervento"
   - **Slug**: `comuni.richieste`
   - **Description**: "Segnalate le problematiche della citta"
   - **Middleware** (JSON array): `["auth", "verified"]` (opzionale)
4. **Content Blocks** (repeater):
   - Add block 1: Type = `hero`, View = `pub_theme::components.blocks.hero`, Data = `{ "heading": "...", "subheading": "..." }`
   - Add block 2: Type = `cta`, View = `pub_theme::components.blocks.cta`, Data = `{ "text": "Inizia", "url": "/report" }`
5. **Sidebar Blocks** (repeater): (opzionale, stessa struttura)
6. **Footer Blocks** (repeater): (opzionale, stessa struttura)
7. Click **Save**

### Step 2: Creare un Block Component nel tema
In `Themes/Sixteen/resources/views/components/blocks/hero.blade.php`:
```blade
@props(['block'])
<section class="bg-gradient-to-r from-blue-600 to-blue-800 py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">
            {{ $block->data['heading'] ?? '' }}
        </h1>
        <p class="text-xl text-blue-100 mb-8">
            {{ $block->data['subheading'] ?? '' }}
        </p>
        @if(isset($block->data['cta']))
            <a href="{{ $block->data['cta']['url'] }}" class="btn btn-primary">
                {{ $block->data['cta']['text'] }}
            </a>
        @endif
    </div>
</section>
```

### Step 3: Renderizzare la pagina in Folio template
In `Themes/Sixteen/resources/views/pages/[container]/[slug].blade.php`:
```blade
<?php use function Laravel\Folio\{name, middleware};
use Modules\Cms\Actions\ResolvePageAction;
name('page');
middleware(\Modules\Cms\Http\Middleware\PageSlugMiddleware::class);
@endphp
<x-layouts.app>
    @php
        $page = app(ResolvePageAction::class)->execute(request()->route('container'), request()->route('slug'));
    @endphp
    @if ($page->renderMode === 'cms')
        <x-cms::page :slug="$page->pageSlug" />
    @else
        <!-- Handle model rendering -->
    @endif
</x-layouts.app>
```

### Step 4: Test rendering
Visita `/it/comuni/richieste` nel browser. Middleware guards applicati, blocchi risolti, tema renderizzato.

---

## Come installarlo

### Prerequisiti
- Laravel 13+ con struttura modulare Laraxot
- Filament 5+ installato
- Migrazioni DB eseguite
- Spatie packages gia installati (Translatable, Data)

### Installation Steps
```bash
# Il modulo e gia nel monorepo
# Non richiede installazione aggiuntiva

# Pubblicare config (se necessario)
php artisan vendor:publish --tag=cms-config

# Run migrations
php artisan migrate

# Publish Filament resources (auto-registered via service provider)
# Se non auto-registrato, aggiungere a config Filament:
# 'resources' => [Modules\Cms\Filament\Resources\PageResource::class, ...]

# Seed sample data (opzionale)
php artisan db:seed --class=Modules\\Cms\\Database\\Seeders\\CmsSeeder

# Create theme o usa esistente
# Assicurati che block components esistano in theme views
# Es: Themes/Sixteen/resources/views/components/blocks/hero.blade.php

# Set up Folio routes
# Crea Folio page template: Themes/Sixteen/resources/views/pages/[container]/[slug].blade.php
# Usa middleware: PageSlugMiddleware

# Test
php artisan tinker
>>> $page = \Modules\Cms\Models\Page::first();
>>> $page->getBlocks(); # Should return BlockData instances
```

### Configurazione
- **Multi-tenancy**: Se usi tenant, seed per-tenant pages in seeder o migrate con `--tenant` flag
- **Locales**: Configura primary language in `config('xot.primary_lang')` (default: 'it')
- **Asset URLs**: Aggiorna block view paths per matching struttura tema

---

## Meta

- **Generated**: 2026-09-06
- **Verified Against**: laravel/Modules/Cms/ full codebase review
- **Error Correction**: Aggiunto fabricator come competitor con confronto, laravel/head come pacchetto consigliato
- **Author**: Visionary analysis (corrected)
