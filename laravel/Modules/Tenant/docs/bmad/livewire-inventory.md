---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Http/Livewire → Filament widget: Tenant"
type: inventory
module: Tenant
status: approved
track: campaign
related:
  - ./livewire-widget-architecture.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ../../../User/docs/bmad/livewire-inventory.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
---

# Inventario: Livewire HTTP → Filament: modulo Tenant

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Tenant per la campagna di conversione Livewire → Filament widget. Formato e metodo ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../../Cms/docs/bmad/livewire-inventory.md).

## Metodo (codice, non assunzione)

```bash
find Modules/Tenant/app/Http/Livewire Modules/Tenant/app/Livewire -type f -name '*.php'
find Modules/Tenant -iname '*livewire*' -not -path '*/vendor/*'
find Modules/Tenant -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
grep -rn "@livewire" Modules/Tenant/resources/views
grep -rln "<livewire:" Modules/Tenant/resources/views
find Modules/Tenant/app/Filament/Widgets -type f
ls Modules/Tenant/resources/views/pages
```

## Classi Livewire trovate: zero

`Modules/Tenant/app/Http/Livewire/` contiene solo `_components.json` con contenuto `[]`. `app/Livewire/` non esiste. Il grep `extends.*(Component|Livewire)` su tutti i `.php` del modulo non restituisce file. **Il modulo Tenant non possiede alcun componente Livewire.**

## Superficie Filament esistente: solo Resource/Page, zero widget

`find Modules/Tenant/app/Filament -type f` mostra `Resources/DomainResource.php` (con Pages/Schemas/Tables) e `Pages/Dashboard.php`. `Modules/Tenant/app/Filament/Widgets/` **non esiste**: il `discoverWidgets` di `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php:134-137` punta a un path assente.

## Verifica del montaggio

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `@livewire(...)` nelle viste del modulo | `grep -rn "@livewire" Modules/Tenant/resources/views` | Zero hit |
| `<livewire:` nelle viste | `grep -rln "<livewire:" Modules/Tenant/resources/views` | Zero hit |
| Render hook nel provider | `Modules/Tenant/app/Providers/Filament/AdminPanelProvider.php` (20 righe) | `panel()` fa solo `return parent::panel($panel)` (riga 18): nessun hook, nessun widget |
| Rotte | `Modules/Tenant/routes/web.php` (19 righe) | Tutto commentato: nessuna rotta reale |
| Folio/Volt | `ls Modules/Tenant/resources/views/pages` | Cartella assente |

## Nota di confine: il team switcher NON è di Tenant

Il widget di cambio team nel chrome è `Modules\User\Filament\Widgets\Team\TeamChangeWidget`, montato da `Modules/User/app/Providers/Filament/AdminPanelProvider.php:49-52` via render hook `USER_MENU_BEFORE`. È codice del modulo User (Epic 10.1): Tenant non deve duplicarlo né assorbirlo in questa campagna.

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
|: |: |: |: | Nessuna classe `Http\Livewire` nel modulo: niente da classificare |

**Cluster A: zero candidati.** **Cluster B: zero candidati.** **Cluster C: zero componenti.**

## Verdetto

Nessuna story di implementazione: zero candidati reali. Tenant resta Resource/Page Filament (`DomainResource`, `Dashboard`); il team-switcher resta di User.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (0 classi `Http\Livewire`, verificato con find + grep)
- [x] Verifica montaggio in tutto il modulo (provider, blade, rotte, Folio)
- [x] `Filament/Widgets` assente confermato; confine col `TeamChangeWidget` di User documentato
- [x] Nessuna story di conversione creata (zero candidati reali)
