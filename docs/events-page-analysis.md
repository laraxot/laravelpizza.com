# Events Page Analysis

## Current Implementation

La pagina `/it/events` attualmente:
1. Usa Folio route `[slug].blade.php`
2. Legge content da `config/local/laravelpizza/database/content/pages/events.json`
3. Renderizza content blocks tramite `<x-page>` component
4. Usa layout pubblico (`<x-layouts.app>` → `<x-layouts.public>`)

## Content Blocks da JSON

Attualmente `events.json` contiene:

### 1. Hero Section
- View: `pub_theme::components.blocks.hero.main`
- Title: "Laravel Developers. Pizza. Community."
- Subtitle: "Join fellow Laravel, Filament..."
- CTAs: "Join the Community", "View Events"

### 2. Features Grid
- View: `pub_theme::components.blocks.features.grid`
- Title: "Why Join Our Community?"
- 4 Features:
  - Regular Meetups (calendar icon)
  - Growing Community (users icon)
  - Multiple Locations (map-pin icon)
  - Real-time Chat (chat icon)

### 3. Stats Section
- View: `pub_theme::components.blocks.stats.overview`
- 4 Stats:
  - 150+ Active Members
  - 25+ Cities
  - 500+ Pizzas Shared
  - 100% Laravel Love

### 4. CTA Banner
- View: `pub_theme::components.blocks.cta.banner`
- Title: "Ready to Join?"
- CTAs: "Sign Up Now", "Browse Events"

## Osservazioni

### Problema Potenziale: Content Duplicato
Il file `events.json` ha lo STESSO contenuto della homepage. Questo potrebbe essere:
1. **Intenzionale** - template di base
2. **Da aggiornare** - dovrebbe avere contenuto specifico per events

### Per una vera pagina Events, dovrebbe avere:
1. **Hero diverso** - "Upcoming Laravel Pizza Events"
2. **Lista di eventi** - non solo features statiche
3. **Event cards** con:
   - Data evento
   - Location
   - Numero partecipanti
   - Link iscrizione
4. **Filtri** - per città, data, tipo evento
5. **Calendario** - view calendario degli eventi

## Confronto con Homepage

| Elemento | Homepage | Events Page (dovrebbe) |
|----------|----------|------------------------|
| Hero | "Laravel Developers. Pizza." | "Upcoming Events" |
| Content | Why join community | Lista eventi reali |
| CTAs | Join / View Events | Register for Event |
| Focus | Community overview | Specific events |

## Possibili Implementazioni

### Option 1: Content Block per Eventi
Creare un nuovo block type: `event-list`
```json
{
    "type": "event-list",
    "view": "pub_theme::components.blocks.events.list",
    "data": {
        "title": "Upcoming Events",
        "events": [...]
    }
}
```

### Option 2: Livewire Component
Per eventi dinamici da database:
```blade
<livewire:events.calendar />
```

### Option 3: API Integration
Fetch eventi da API esterna (Meetup.com, eventi database)

## Next Steps

1. ⏳ Verificare se laravelpizza.com/events ha struttura diversa
2. ⏳ Decidere se events.json deve avere contenuto specifico
3. ⏳ Implementare event list component se necessario
4. ⏳ Considerare integrazione con database eventi
5. ⏳ Aggiungere filtri e calendario se richiesto

## Status Attuale

✅ Pagina events renderizza correttamente
✅ Layout pubblico funziona
✅ Content blocks da JSON funzionano
⚠️ Contenuto potrebbe essere placeholder generico
⚠️ Manca lista eventi reali (se richiesta)

## Domande da Risolvere

1. Il contenuto di events.json è intenzionale o placeholder?
2. Gli eventi devono venire da database o da JSON statico?
3. Serve un calendario interattivo?
4. Servono filtri per eventi?
5. Come gestire registrazioni agli eventi?
