---
type: overview
module: UI
sources:
  - ../../../docs/module-ui.md
  - ../../../docs/philosophy.md
  - ../../../docs/design-system.md
  - ../../../docs/table-components.md
confidence: high
updated: 2026-04-15
---

# UI Module — Overview

> **Ruolo**: Layer di presentazione centralizzato — componenti Blade/Filament riutilizzabili, design system, governance UI per tutti i moduli.

## Responsabilità del Modulo

Il modulo UI è il **fornitore di componenti UI** per l'intera applicazione:

- Registra e scopre componenti Blade e Livewire riutilizzabili via `GetModulePathByGeneratorAction`
- Fornisce il design system condiviso (tipografia, colori, spaziatura)
- Gestisce il pannello Filament Admin (`AdminPanelProvider`)
- Separa la logica di presentazione dalla business logic dei moduli
- Dipende da: **User, Tenant, Xot**

## Philosophy

> _"Zen": un'interfaccia armoniosa dove gli utenti interagiscono senza sforzo, e i developer costruiscono con fiducia su componenti consistenti._

Principi guida:
- **Component-driven**: ogni elemento UI è un componente riutilizzabile e indipendente
- **Separation of concerns**: logica UI separata dalla business logic
- **Xot alignment**: estende `XotBaseServiceProvider`, eredita i pattern fondamentali
- **UI standardization**: governa e impone consistenza visiva in tutti i moduli

## Componenti Blade Principali

### Layout e Struttura

```blade
<x-ui.button variant="primary">Azione Primaria</x-ui.button>
<x-ui.button variant="secondary">Azione Secondaria</x-ui.button>

<x-ui.card>
    <x-slot name="header">Titolo Card</x-slot>
    Contenuto
</x-ui.card>
```

### Form Components

```blade
<x-ui.form.input type="text" name="name" label="Nome" />
<x-ui.form.select name="type" label="Tipo" :options="$types" />
```

### Table Components

```blade
<x-ui::datatable
    :columns="[['name' => 'id', 'label' => 'ID', 'sortable' => true]]"
    :data="$items"
    :per-page="10"
    :searchable="true"
    :sortable="true"
    :filterable="true"
    :exportable="true"
/>

<x-ui::status-badge
    :status="$model->status"
    :options="['active' => ['label' => 'Attivo', 'color' => 'success']]"
/>
```

## Design System

### Tokens Tipografici

| Token | Valore | Uso |
|-------|--------|-----|
| `--app-font-sans` | Inter | Body, UI |
| `--app-font-serif` | Merriweather | Contenuto editoriale |
| `--app-font-mono` | JetBrains Mono | Codice |

### Colori Brand

| Token | Valore | Significato |
|-------|--------|-------------|
| `--app-primary` | `#0EA5E9` | Azione principale |
| `--app-secondary` | `#6366F1` | Azione secondaria |
| `--app-accent` | `#EC4899` | Evidenziazione |
| `--app-success` | `#22C55E` | Stato positivo |
| `--app-warning` | `#F59E0B` | Stato attenzione |
| `--app-error` | `#EF4444` | Stato errore |

### Spaziatura

| Token | Valore |
|-------|--------|
| `--so-spacing-xs` | 0.5rem |
| `--so-spacing-sm` | 0.75rem |
| `--so-spacing-md` | 1rem |
| `--so-spacing-lg` | 1.5rem |
| `--so-spacing-xl` | 2rem |

## Service Providers

| Provider | Scopo |
|----------|-------|
| `UIServiceProvider` | Registrazione componenti, view, assets |
| `AdminPanelProvider` | Filament Admin panel configuration |

## Struttura Directory

```
app/
├── Filament/       # Componenti Filament (Resources, Pages, Widgets)
├── Http/           # Controllers e Middleware
├── Models/         # Modelli UI (settings, preferences)
├── Providers/      # Service Providers
└── Services/       # Servizi UI
resources/views/
├── components/     # Blade components (x-ui::*)
└── pages/          # Folio pages
```

## Regole Operative

1. Ogni componente UI **deve** stare nel modulo UI — non duplicare in altri moduli
2. Usare `x-ui::component-name` (namespace UI) per richiamare i componenti
3. Non hardcodare SVG nei Blade — usare il sistema icone (Font Awesome via `owenvoke/blade-fontawesome`)
4. I design token CSS vivono in UI — i temi li sovrascrivono, non li ridefiniscono
5. PHPStan Level 10 obbligatorio — type hinting completo su tutti i metodi pubblici

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBaseServiceProvider base
- [[../../../../../../laravel/Modules/Cms/docs/wiki/overviews/cms-module|Cms Module]] — usa blocchi UI per il rendering frontend
- [[../../../../../../laravel/Themes/Sixteen/docs/wiki/index|Sixteen Theme]] — override Design Comuni dei token UI
- [[../../../../../../laravel/Themes/TwentyOne/docs/wiki/index|TwentyOne Theme]] — override cinematografico dei token UI

## Raw Sources Prioritari

- `docs/module-ui.md` — panoramica, dipendenze, struttura
- `docs/philosophy.md` — filosofia, zen, principi progettuali
- `docs/design-system.md` — token tipografia, colori, spaziatura, componenti base
- `docs/table-components.md` — DataTable, StatusBadge, ActionButtons
- `docs/architecture-rules.md` — regole architetturali strict
- `docs/filament-5x-compatibility.md` — note aggiornamento Filament 5
- `docs/no-svg-hardcoded-in-blade.md` — regola icone
