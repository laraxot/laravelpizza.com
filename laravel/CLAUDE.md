# Regole Critiche per Laravel Pizza Meetups

## 🎯 MISSIONE DEL PROGETTO

**QUESTO PROGETTO È UNA CONVERSIONE MIGLIORATA DI https://laravelpizza.com/**

Non è una semplice replica - è una versione:
- ✨ PIÙ COOL - Design moderno e accattivante
- 🚀 PIÙ CLICKBAIT - Headlines e CTA che convertono
- 💥 PIÙ ENGAGING - Interazioni e animazioni wow-factor
- 🔥 PIÙ VIRALE - Progettato per essere condiviso

**Obiettivo**: Prendere laravelpizza.com e renderlo MIGLIORE in ogni aspetto.

---

## ⚠️ REGOLE FONDAMENTALI - LEGGERE SEMPRE

### 1. NAMESPACE TEMI (CRITICAL!)

**USA SEMPRE `pub_theme::` - MAI il nome del tema in minuscolo!**

```blade
✅ @include('pub_theme::components.ui.particles')
✅ <x-pub_theme::components.layouts.main>
❌ @include('meetup::components.ui.particles')
❌ <x-meetup::ui.particles>
```

Il tema attivo è configurato in `config('xra.pub_theme')` (es. `'Meetup'`), ma il namespace Blade è SEMPRE `pub_theme::` - mai usare il nome del tema direttamente.

---

### 2. ARCHITETTURA FRONTEND (CRITICAL!)

**NO Controller. NO Routes in web.php. NO Routes in api.php.**

**USARE SOLO:**
- ✅ **Laravel Folio** - File-based routing
- ✅ **Livewire Volt** - Single-file components
- ✅ **Filament** - Admin panel
- ✅ **CMS-Driven Pages** - File JSON per contenuti

**USARE SOLO:**
- ✅ **Laravel Folio** - File-based routing
- ✅ **Livewire Volt** - Single-file components
- ✅ **Filament** - Admin panel
- ✅ **CMS-Driven Pages** - File JSON per contenuti

**Struttura Corretta:**
```
# PAGINE PUBBLICHE (FRONTOFFICE) = SOLO FILE JSON
config/local/laravelpizza/database/content/pages/
├── home.json                    → route('/')
├── events.json                  → route('events.index')
├── contact.json                 → route('contact')
└── [slug].json                  → route('{slug}')

# FOLIO ROUTING (CATCH-ALL)
Themes/Meetup/resources/views/pages/
└── [slug].blade.php             → Gestisce TUTTE le pagine dinamiche

# COMPONENTI BLOCK
Themes/Meetup/resources/views/components/blocks/
├── hero/
├── features/
├── events/
├── contact/
└── [type]/
```

**Esempio Pagina JSON (CMS-Driven):**
```json
// File: config/local/laravelpizza/database/content/pages/contact.json
{
    "id": "1",
    "title": {"it": "Contact Us - Laravel Pizza Meetups"},
    "slug": "contact",
    "middleware": null,
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "contact-hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Get in Touch",
                    "subtitle": "Have questions? Reach out to us."
                }
            },
            {
                "type": "contact",
                "slug": "contact-form",
                "data": {
                    "view": "pub_theme::components.blocks.contact.form",
                    "title": "Send us a message"
                }
            }
        ]
    },
    "sidebar_blocks": {"it": []},
    "footer_blocks": {"it": []}
}
```

**Esempio Componente Block:**
```blade
{{-- File: Themes/Meetup/resources/views/components/blocks/contact/form.blade.php --}}
<div class="contact-form">
    <h2>{{ $title }}</h2>
    <form wire:submit="submit">
        <input type="text" wire:model="name" placeholder="Your name">
        <input type="email" wire:model="email" placeholder="Your email">
        <textarea wire:model="message" placeholder="Your message"></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>
```

**❌ MAI FARE:**
```php
// ❌ NO Controller
class EventController extends Controller { }

// ❌ NO Routes in web.php
Route::get('/events', [EventController::class, 'index']);

// ❌ NO Routes in api.php
Route::apiResource('events', EventApiController::class);

// ❌ NO Blade files per pagine dinamiche
{{-- File: Themes/Meetup/resources/views/pages/contact.blade.php --}}
// ❌ SBAGLIATO! Le pagine vanno create come JSON, non come Blade
```

### 3. PRINCIPI ARCHITETTURALI (SEMPRE!)

**DRY** (Don't Repeat Yourself)
- Non duplicare codice
- Usa Actions, Services, Traits

**KISS** (Keep It Simple, Stupid)
- Soluzioni semplici > complesse
- Evita over-engineering

**SOLID**
- Single Responsibility
- Open/Closed
- Liskov Substitution
- Interface Segregation
- Dependency Inversion

**Robust**
- Gestione errori
- Validazione input
- Type safety (PHP 8.2+)
- PHPStan Level 10

**Laraxot Patterns**
- Modular architecture (nwidart/laravel-modules)
- Action pattern (Spatie)
- Base classes inheritance
- Event Sourcing
- **CMS-Driven Pages** - JSON content files
- **Block Components** - Reusable UI components
- **SushiToJsons** - Database from JSON files

### 4. NAMING CONVENTIONS FILES .md

**✅ CORRETTO:**
```
README.md                    ← Maiuscolo OK
CHANGELOG.md                 ← Maiuscolo OK
project-purpose.md           ← lowercase con trattini
complete-roadmap-2025.md     ← lowercase con trattini
api-endpoints.md             ← lowercase
```

**❌ SBAGLIATO:**
```
PROJECT-PURPOSE.md           ← NO maiuscole
ERROR-ANALYSIS.md            ← NO maiuscole
COMPLETE-ROADMAP-2025.md     ← NO maiuscole
API-Endpoints.md             ← NO CamelCase
```

**Eccezioni UNICHE:**
- `README.md` - Standard universale
- `CHANGELOG.md` - Standard universale

### 5. ORGANIZZAZIONE DOCUMENTAZIONE

**✅ File .md vanno SOLO in cartelle docs/ ESISTENTI:**
```
Modules/Meetup/docs/          ← Usa questa
Themes/Meetup/docs/           ← Usa questa
Modules/Cms/docs/             ← Documentazione CMS
Modules/User/docs/            ← Documentazione utenti
Modules/Xot/docs/             ← Documentazione Laraxot
```

**❌ NON creare nuove cartelle docs/:**
```
Modules/Meetup/docs/new-folder/  ← NO!
Modules/Meetup/documentation/    ← NO!
Themes/Meetup/documentation/     ← NO!
```

**✅ Documentazione esistente da consultare:**
- `Themes/Meetup/docs/folio-pages-json-only-rule.md` - Regola CRITICA pagine JSON
- `Modules/Meetup/docs/folio-pages-json-only-rule.md` - Regola CRITICA pagine JSON
- `Modules/Cms/docs/content-blocks-system.md` - Sistema blocchi contenuto

### 6. SCOPO PROGETTO (DA RICORDARE!)

**Laravel Pizza Meetups è:**
- ✅ Piattaforma community per sviluppatori Laravel
- ✅ Sistema gestione eventi/meetup tech
- ✅ Chat community + profili utente
- ✅ "Pizza" = metafora per meetup

**Laravel Pizza Meetups NON è:**
- ❌ Pizzeria online
- ❌ E-commerce food delivery
- ❌ Sito per ordinare pizza
- ❌ Menu digitale ristorante

**IMPORTANTE**: Se vedi codice che sembra un sistema di vendita pizza, è SBAGLIATO!

### 7. FOLIO + VOLT + CMS-DRIVEN PAGES

**Architettura CMS-Driven:**
- **Pagine pubbliche** = File JSON in `config/local/laravelpizza/database/content/pages/`
- **Folio routing** = `[slug].blade.php` come catch-all per TUTTE le pagine
- **Componenti block** = UI riutilizzabili in `Themes/Meetup/resources/views/components/blocks/`
- **SushiToJsons** = Trait che carica dati da file JSON nel database

**Flusso di Rendering:**
1. Folio route `/it/{slug}` → `[slug].blade.php`
2. Middleware `PageSlugMiddleware` estrae lo slug
3. Componente `<x-page side="content" :slug="$slug" />` cerca il record Page
4. Modello `Page` usa `SushiToJsons` per leggere `{slug}.json`
5. `content_blocks` dal JSON vengono renderizzati come componenti Blade

**Resources da studiare:**
- `Themes/Meetup/docs/folio-pages-json-only-rule.md` - Regola CRITICA
- `Modules/Cms/docs/content-blocks-system.md` - Sistema blocchi
- `Modules/Meetup/docs/architecture-reference.md` - Architettura

### 8. FILAMENT ADMIN (Backend Only!)

**✅ Filament è per ADMIN:**
```
app/Filament/
├── Resources/
│   ├── EventResource.php
│   └── UserResource.php
├── Widgets/
│   └── EventsOverview.php
└── Pages/
    └── Dashboard.php
```

**Frontend pubblico = FOLIO + VOLT**

### 9. DATABASE & MODELS

**Sempre:**
- Migrations con timestamps
- Soft deletes dove appropriato
- Foreign keys con cascade
- Indexes per performance
- UUIDs per public IDs

**Models:**
```php
use HasUuids, SoftDeletes, HasFactory;

protected $fillable = [...];
protected $casts = [...];
protected $hidden = ['password'];
protected $appends = ['full_name'];
```

### ⚠️ REGOLA CRITICA: MAI aggiungere connessioni database nei config tenant!

**ERRORE GRAVE (NON FARE MAI):**
```php
// ❌ SBAGLIATO in config/local/laravelpizza/database.php
'gdpr' => [
    'driver' => 'mysql',
    'database' => env('DB_DATABASE_GDPR', 'laravel_gdpr'),
    // ...
],
```

**CORRETTO:**
- Connessioni moduli vanno in `config/database.php` (main)
- TenantServiceProvider aggiunge dinamicamente le connessioni dei moduli
- File tenant (`config/local/*/database.php`) devono avere SOLO:
  - `mysql` (default)
  - `user` (tenant user)
  - `sqlite` (opzionale)

Il TenantServiceProvider legge automaticamente le variabili .env (DB_DATABASE_GDPR, etc.) e registra le connessioni. NON duplicare mai nei config tenant!

### 10. ACTIONS PATTERN

**Spatie Actions per business logic:**
```php
// app/Actions/Event/CreateEventAction.php
class CreateEventAction
{
    public function execute(array $data): Event
    {
        return DB::transaction(function () use ($data) {
            $event = Event::create($data);

            activity('event')
                ->performedOn($event)
                ->causedBy(auth()->user())
                ->log('Event created');

            return $event;
        });
    }
}

// Uso in Volt:
$createEvent = function() {
    $event = app(CreateEventAction::class)->execute($this->form);
    $this->redirect(route('events.show', $event));
};
```

### 11. TESTING

**Obbligatorio:**
- PHPStan Level 10
- Laravel Pint (PSR-12)
- Feature tests per user flows
- Unit tests per Actions
- Coverage > 70%

```bash
./vendor/bin/phpstan analyze
./vendor/bin/pint
php artisan test --parallel
```

### 12. MCP SERVERS (Claude Code Integration)

**Configurati in `.mcp.json`:**

**Filesystem Server** - Accesso file protetti:
- `.env` - Variabili d'ambiente
- `auth.json` - Credenziali Composer
- `CLAUDE.md`, `IFLOW.md` - Documentazione protetta

**Database Server** - Query SQLite:
- Analytics: "Quanti eventi questo mese?"
- Schema: "Struttura tabella events"
- Debug senza phpMyAdmin

**GitHub Server** - Automazione:
- Issues: "Crea issue per questo bug"
- PR: "Rivedi PR #123"
- Workflow automation

**Verifica setup:**
```bash
./scripts/verify-mcp-setup.sh
claude mcp list
```

**Documentazione completa:**
- `Modules/Meetup/docs/mcp-servers-setup.md`

---

## Quick Reference

**Quando creo una nuova pagina PUBBLICA:**
1. ✅ Crea file JSON in `config/local/laravelpizza/database/content/pages/{slug}.json`
2. ✅ Definisci `content_blocks` usando componenti esistenti
3. ✅ Verifica che i componenti Blade esistano in `Themes/Meetup/resources/views/components/blocks/`
4. ✅ Testa la pagina visitando `/it/{slug}`
5. ❌ NON creare file Blade in `Themes/Meetup/resources/views/pages/{slug}.blade.php`
6. ❌ NON creare Controller
7. ❌ NON aggiungere rotte in web.php

**Quando creo documentazione:**
1. ✅ Usa cartelle docs/ esistenti (Modules/*/docs/, Themes/*/docs/)
2. ✅ Nome file lowercase (tranne README.md, CHANGELOG.md)
3. ✅ Usa trattini, non underscore
4. ✅ Consulta documentazione esistente prima di creare
5. ❌ NON creare nuove cartelle docs/

**Quando scrivo codice:**
1. ✅ DRY + KISS + SOLID
2. ✅ Type hints ovunque
3. ✅ PHPStan Level 10 compliant
4. ✅ Action pattern per business logic
5. ✅ CMS-Driven pages per contenuti pubblici
6. ❌ NO query in views (usa computed)
7. ❌ NO Blade files per pagine dinamiche (usa JSON)

---

## 12. SERVICE PROVIDER PATTERN (CRITICAL!)

**REGOLA CRITICA: Provider MINIMALI**

### ✅ CORRETTO - Struttura Minima

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### ❌ SBAGLIATO - Troppo Complesso

```php
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    public function boot(): void
    {
        parent::boot(); // ❌ SBAGLIATO: chiama solo parent senza logica
        $this->registerViews(); // ❌ SBAGLIATO: già fatto dal parent!
    }

    public function register(): void
    {
        parent::register();
        $this->app->register(EventServiceProvider::class); // ❌ SBAGLIATO: già fatto dal parent!
    }
}
```

### Regole Provider

**NEVER:**
- ❌ Aggiungere `boot()` o `register()` che chiamano solo parent
- ❌ Duplicare metodi già in XotBase (registerViews, registerTranslations, ecc.)
- ❌ Dimenticare proprietà obbligatorie (`$module_dir`, `$module_ns`)
- ❌ Estendere classi sbagliate (BaseEventServiceProvider invece di XotBaseEventServiceProvider)

**ALWAYS:**
- ✅ Estendere classe XotBase corretta
- ✅ Includere TUTTE le proprietà obbligatorie
- ✅ Chiamare `parent::boot()` PRIMA se fai override
- ✅ Usare `#[Override]` quando override
- ✅ Struttura MINIMALE - lascia che XotBase faccia il lavoro

**Pattern per tutti i Provider:**

#### EventServiceProvider
```php
class EventServiceProvider extends XotBaseEventServiceProvider
{
    protected $listen = [];
    protected static $shouldDiscoverEvents = true;
}
```

#### RouteServiceProvider
```php
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Meetup';
    protected string $moduleNamespace = 'Modules\Meetup\Http\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

#### AdminPanelProvider
```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Meetup';

    #[Override]
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel);
    }
}
```

**Documentazione Completa:**
- `Modules/Xot/docs/serviceprovider-minimal-structure.md`
- `Modules/Meetup/docs/provider-errors-lessons-learned.md`

---

### 13. TRADUZIONI AUTOMATICHE - MAI ->label() (CRITICAL!)

**REGOLA D'ORO: MAI USARE ->label() NEI COMPONENTI**

```
// ❌ VIETATO ASSOLUTAMENTE
TextInput::make('email')->label('Email Address')
Checkbox::make('terms')->label('I accept the terms')

// ✅ CORRETTO SEMPRE
TextInput::make('email')           // Gestito da AutoLabelAction
Checkbox::make('terms')           // Gestito da AutoLabelAction
```

**Come Funziona il Sistema:**
1. **AutoLabelAction** intercetta tutti i componenti Filament
2. **GetTransKeyAction** analizza il backtrace
3. **Genera chiavi automatiche**: `module::resource.field.attribute`
4. **Salva traduzioni automaticamente** nel file PHP appropriato

**SOLO messaggi manuali con `__('key')`:**
- Validation messages
- Helper text
- Testi speciali non-componente

### 14. ARCHITETTURA MODULI - DEPENDENCY CORRECT

**Regola di Dependency Inversion:**
```
// ❌ SBAGLIATO - User dipende da GDPR
Modules\User\Filament\Widgets\Auth\RegisterWidget
// → User non può funzionare senza GDPR!

// ✅ CORRETTO - GDPR dipende da User  
Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget
// → User esiste senza problemi, GDPR aggiunge funzionalità
```

**Principio:**
- **Moduli core** (User, Auth) devono funzionare indipendentemente
- **Moduli estensione** (GDPR, Lang) dipendono dai core
- **Nessun dipendenza circolare** possibile

### 15. FORM DESIGN - WCAG 2.2 AAA 2025 (ACCESSIBILITY)

**Requisiti Minimi Assoluti:**
- ✅ **Click targets**: Minimo 44×44px per mobile
- ✅ **Contrast**: Ratio 4.5:1 minimo (7:1 per testo)
- ✅ **Screen reader**: Aria-label, ARIA-live regions
- ✅ **Keyboard navigation**: Tab order logico, focus indicators
- ✅ **Mobile-first**: Responsive design fluid
- ✅ **Error handling**: aria-live per messaggi errore
- ✅ **Font sizing**: Scalabile fino al 200% senza breaking

### 16. GDPR 2025 - COMPLIANCE ENTERPRISE GRADE

**Standards Implementati:**
- ✅ **Consent separation**: Required vs Optional sections
- ✅ **Granular consent**: Ogni scopo ha checkbox dedicato
- ✅ **Privacy by design**: Default settings privacy-protective
- ✅ **Easy withdrawal**: Facilità pari a concessione
- ✅ **Audit trail**: IP, User Agent, Timestamp completi
- ✅ **Legal basis**: Art. 6(1)(b) GDPR references
- ✅ **Data minimization**: Solo dati strettamente necessari

### 17. MULTILINGUA COMPLETO - 6 LINGUE OBBLIGATORIE

**Standard Multilingua:**
```php
// Sempre creare traduzioni per:
- Italiano (it/)    - Lingua primaria
- Inglese (en/)     - Internazionale  
- Spagnolo (es/)     - Mercato LATAM
- Tedesco (de/)      - Mercato EU/Germania
- Francese (fr/)     - Mercato EU/Francia
- Russo (ru/)        - Mercato CIS/Est Europa
```

