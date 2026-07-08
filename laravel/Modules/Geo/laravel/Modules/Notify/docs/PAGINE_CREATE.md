# Pagine Create - FixCity Sixteen Theme

## Data: {{ date('Y-m-d') }}

## Metodologia Utilizzata

- **GSD**: Pianificazione strutturata del lavoro
- **Ralph Loop**: Esecuzione iterativa con verifica continua
- **BMAD**: Standard di qualità e documentazione
- **OpenVikings**: Context database per AI agents
- **NotebookLM**: Research e pattern recognition

## Pagine Create

### 1. Pagine Istituzionali (8 pagine)

| Pagina | Route | File | Stato |
|--------|-------|------|-------|
| Cultura | `/it/cultura` | `pages/cultura/index.blade.php` | ✅ |
| Sport | `/it/sport` | `pages/sport/index.blade.php` | ✅ |
| Famiglia | `/it/famiglia` | `pages/famiglia/index.blade.php` | ✅ |
| Lavoro | `/it/lavoro` | `pages/lavoro/index.blade.php` | ✅ |
| Ambiente | `/it/ambiente` | `pages/ambiente/index.blade.php` | ✅ |
| Mobilità | `/it/mobilita` | `pages/mobilita/index.blade.php` | ✅ |
| Turismo | `/it/turismo` | `pages/turismo/index.blade.php` | ✅ |
| Salute | `/it/salute` | `pages/salute/index.blade.php` | ✅ |

### 2. Pagine Eventi e Amministrazione (2 pagine)

| Pagina | Route | File | Stato |
|--------|-------|------|-------|
| Eventi | `/it/eventi` | `pages/eventi/index.blade.php` | ✅ |
| Organi di Governo | `/it/amministrazione/organi` | `pages/administration/organi.blade.php` | ✅ |

## Totale: 10 pagine create

## Pattern Utilizzato

Ogni pagina segue lo standard:

```php
<?php
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('{route.name}');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $pageSlug = '{slug}';
    public array $data = [];
};
?>

<x-layouts.app>
    @volt('{volt.name}')
    
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb">...</nav>
    
    {{-- Main Content --}}
    <main class="container py-8">
        {{-- Hero Section --}}
        <section>...</section>
        
        {{-- CMS Sections --}}
        <x-section slug="..." :data="$data" />
        
        {{-- Featured Content --}}
        <section>...</section>
    </main>
    
    @endvolt
</x-layouts.app>
```

## Standard di Qualità Applicati

✅ **Laravel Folio** - Routing file-based
✅ **Livewire Volt** - Componenti funzionali
✅ **PageSlugMiddleware** - Integrazione CMS
✅ **Breadcrumb** - Navigazione gerarchica
✅ **SEO-ready** - Meta tags e struttura semantica
✅ **Responsive** - Mobile-first con Tailwind CSS
✅ **Accessibilità** - ARIA labels e HTML semantico
✅ **CMS-driven** - Sezioni dinamiche con `<x-section>`
✅ **Icone UI** - `ui-brands.*` per i social

## Icone Utilizzate

Le icone social usano il nuovo set `ui-brands`:

- `ui-brands.facebook`
- `ui-brands.twitter`
- `ui-brands.instagram`
- `ui-brands.youtube`
- `ui-brands.linkedin`

Configurate in `config/blade-icons.php`:
```php
'ui-brands' => [
    'path' => base_path('Modules/UI/resources/svg/brands'),
    'prefix' => 'ui-brands',
],
```

## CMS Integration

Ogni pagina supporta sezioni CMS dinamiche:
- `{tema}-hero`: Hero section personalizzata
- `{tema}-content`: Contenuto principale
- `{tema}-services`: Servizi correlati
- `{tema}-news`: Ultime notizie
- `{tema}-events`: Eventi correlati

## Prossimi Passi

### Pagine da Creare (Backlog)
- [ ] `/it/novita/[slug]` - Dettaglio notizia
- [ ] `/it/eventi/[slug]` - Dettaglio evento
- [ ] `/it/servizi/[categoria]` - Servizi per categoria
- [ ] `/it/amministrazione/aree` - Aree amministrative
- [ ] `/it/amministrazione/uffici` - Uffici comunali

### Miglioramenti
- [ ] Aggiungere filtri per eventi (per data, categoria)
- [ ] Integrare calendario eventi interattivo
- [ ] Aggiungere mappa per luoghi turistici
- [ ] Implementare ricerca avanzata

## File di Configurazione

- `config/blade-icons.php` - Configurazione icone SVG
- `Modules/UI/resources/svg/brands/` - Icone social SVG
- `Themes/Sixteen/resources/views/components/social/social-links.blade.php` - Componente social

## Note Tecniche

1. **Namespace**: Tutte le pagine usano `pub_theme::` per le viste
2. **Localizzazione**: Pagine in `/it/` per supporto multi-lingua
3. **Volt Components**: Logica incapsulata in `@volt()`
4. **CMS Sections**: Contenuti dinamici gestiti dal modulo Cms

## Riferimenti

- [Documentazione Icone UI](Modules/UI/docs/BRANDS_ICONS.md)
- [GSD Workflow](.cursor/get-shit-done/)
- [Ralph Loop](.qwen/skills/ralph-loop/)
- [Laravel Folio](https://laravel.com/docs/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/volt)

## Aggiornamento: Pagine Dettaglio e Servizi

### Pagine Dettaglio (2)
- [x] `/it/novita/[slug]` - Dettaglio notizia con share social
- [x] `/it/eventi/[slug]` - Dettaglio evento con info e prenotazione

### Pagine Amministrazione (2)
- [x] `/it/amministrazione/aree` - Aree amministrative
- [x] `/it/amministrazione/uffici` - Uffici comunali con orari

### Pagine Servizi (1)
- [x] `/it/servizi/[categoria]` - Servizi per categoria

## Totale Complessivo: 15 pagine create

## Features Implementate

### Novità Dettaglio
- ✅ Header con data e categoria
- ✅ Featured image con didascalia
- ✅ Content prose-style
- ✅ Share buttons (Facebook, Twitter, Instagram)
- ✅ Notizie correlate

### Eventi Dettaglio
- ✅ Hero con info evento (data, ora, luogo)
- ✅ Info box con dettagli
- ✅ Programma dell'evento
- ✅ CTA per prenotazione
- ✅ Condividi evento

### Amministrazione
- ✅ Elenco aree con responsabili
- ✅ Tabella uffici con orari
- ✅ Mappa edificio interattiva
- ✅ Contatti diretti (email, telefono)

### Servizi
- ✅ Lista servizi per categoria
- ✅ Card navigabili
- ✅ CTA per accesso servizio


## Correzione Applicata

### File Eliminati (ERRATI)
- ❌ `pages/tests/amministrazione.blade.php`
- ❌ `pages/tests/documenti-dati.blade.php`
- ❌ `pages/tests/novita-dettaglio.blade.php`
- ❌ `pages/tests/segnalazione-area-personale.blade.php`
- ❌ `pages/tests/segnalazioni-elenco.blade.php`

### File Corretti
- ✅ `pages/tests/homepage.blade.php` - Ricreata seguendo Bootstrap Italia
- ✅ `pages/tests/[slug].blade.php` - Gestisce tutte le pagine dinamiche tests/*

### Design Bootstrap Italia
La homepage ora segue il design ufficiale:
- ✅ Hero section "Contenuti in Evidenza"
- ✅ Governance section (Sindaco, Giunta, Consiglio)
- ✅ Calendario eventi
- ✅ Argomenti in evidenza
- ✅ Footer completo a 4 colonne

Riferimento: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
