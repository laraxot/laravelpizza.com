---
title: "Blueprint piattaforma: Livewire HTTP a Filament Widgets"
type: bmad-blueprint
status: active
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, second-brain, filament, widgets, livewire, architecture]
qmd: "livewire http filament widget migration why planning inventory"
related:
  - ./filament-blueprint.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-parallelization-plan.md
  - ../../../User/docs/bmad/livewire-widget-consolidation-inventory.md
---

# Decisione architetturale

## Perché

Nel progetto il pannello amministrativo è già costruito attorno a Filament,
alle basi `XotBase*`, alle policy e al contesto tenant. Un componente custom in
`app/Http/Livewire` introduce invece un secondo punto di registrazione, un
secondo contratto di layout e spesso una copia della stessa logica già presente
in una Resource, Page o Action.

Un **Filament Widget** è quindi il confine corretto quando la UI appartiene al
panel: eredita lifecycle, autorizzazione, layout, responsive grid e discovery
del panel, mentre la logica resta nelle Actions. Questo riduce duplicazioni e
impedisce che un componente HTTP venga esposto globalmente senza che sia stato
montato in un flusso prodotto.

Questa regola non significa convertire ogni classe che usa Livewire. Un form
front-office, una pagina Folio, un flusso auth/password e un adapter Livewire
di una libreria non sono automaticamente widget. In quei casi il risultato
corretto è ritiro, Page/Resource, Blade/Folio o eccezione documentata.

## Inventario corrente

Sono presenti 27 file PHP sotto `Modules/*/app/Http/Livewire` e 143 widget
Filament. L'inventario per modulo è la fonte di verità: ogni entry deve avere
caller, superficie (BO/FO), Action usata, stato e decisione.

## Wave BMAD

### Wave 0: Ricerca e contratti

- verificare componenti PHP, alias `_components.json`, viste, route e mount;
- classificare ogni entry in `widget`, `page/resource`, `front-office`,
  `dead-code` o `external adapter`;
- congelare `XotBaseWidget`, policy, tenant, traduzioni e accessibilità;
- non modificare ancora PHP.

### Wave 1: Ritiro sicuro e sostituzioni già esistenti

Scope disgiunti: `Job`, `Geo`, `Lang`, `UI`, `Media`.

- ritirare componenti senza caller o con widget gemello già verificato;
- sostituire i mount con il widget/page già esistente;
- mantenere le Actions e rimuovere alias/view solo dopo ricerca a zero riferimenti.

### Wave 2: User e superfici del pannello

Convertire solo i flussi realmente montati nel panel: login, logout, team,
profilo e notifiche. Auth/password/legal restano Page/FO se non appartengono al
chrome Filament. Ogni widget deve rispettare policy, tenant e traduzioni.

### Wave 3: Cms, Quaeris e dashboard

Riconciliare Page/Show, Pulse e blocchi FO con Filament Pages/Widgets soltanto
quando il prodotto richiede una superficie panel. Non trasformare una pagina FO
in un KPI widget per ridurre il conteggio dei componenti.

### Wave 4: Registro e gate finali

- eliminare discovery HTTP e alias rimasti solo quando tutti i moduli foglia
  sono migrati o hanno un'eccezione registrata;
- aggiornare docs/bmad del modulo e del tema coinvolto;
- verificare `rg` su PHP, Blade, route, provider e configurazioni.

## Gate per ogni wave

```bash
cd laravel
vendor/bin/phpstan analyse Modules/<Modulo> --no-progress
vendor/bin/pest Modules/<Modulo>/tests --no-coverage
rg -n 'Http\\Livewire|<livewire:|@livewire\\(' Modules/<Modulo> Themes
```

Chiusura solo con caller verificati, test mirati, `git diff --check`, documenti
owner aggiornati e nessuna regressione di accessibilità, autorizzazione o
tenant isolation.

## Contratti operativi obbligatori

### Lifecycle

- `mount()` inizializza solo input e contesto; lo stato pubblico è tipizzato e
  serializzabile;
- hydration/update non devono introdurre query o side effect non necessari;
- loading, empty, error e polling hanno comportamento esplicito;
- il cambio tenant resetta stato, filtri e cache tenant-scoped;
- il cleanup e gli eventi emessi/ascoltati sono mappati prima del ritiro.

### Sicurezza e tenancy

- `canView`, policy, panel auth e tenant guard sono verificati nell'ordine
  corretto prima di query o Action;
- nessun widget usa query globali per dati tenant-aware;
- cache key e stato serializzato includono il tenant quando necessario;
- i test coprono accesso negato, tenant errato e cambio tenant nella stessa
  sessione.

### Layout, registrazione e accessibilità

- la variante `XotBase*` e il provider/panel owner sono dichiarati;
- `columnSpan`, breakpoint e navigation visibility sono espliciti;
- il mount embedded usa FQCN; alias e discovery sono ritirati solo dopo smoke
  test del caller;
- ogni view mantiene percorso da tastiera, focus visibile, heading/label
  semantici, contrasto, `aria-live` controllato per loading/error e supporto
  reduced-motion; il colore non è l'unico canale informativo.

### Rollback

Il vecchio caller resta disponibile fino al superamento di PHPStan, test e
smoke. In caso di regressione il ripristino segue l'ordine
`caller → route/view/alias → provider/discovery → componente`; la correzione e
la verifica post-rollback sono registrate nel decision log della lane.
