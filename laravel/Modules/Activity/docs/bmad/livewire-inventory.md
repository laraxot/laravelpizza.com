---
title: "Inventario Http/Livewire → Filament widget: Activity"
type: inventory
module: Activity
status: approved
track: campaign
related:
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ./livewire-widget-prd.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
  - ../../../Cms/docs/bmad/livewire-inventory.md
updated: 2026-10-15
tags: [docs, activity, bmad]
qmd: "inventario: livewire http → filament   modulo activity activity"
---

# Inventario: Livewire HTTP → Filament: modulo Activity

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Activity per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../../Cms/docs/bmad/livewire-inventory.md), con la differenza che qui non esiste nemmeno una classe da classificare: il risultato verificato è **zero componenti Livewire**.

## Metodo (codice, non assunzione)

```bash
find Modules/Activity -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
find Modules/Activity -iname '*livewire*' -not -path '*/vendor/*'
ls Modules/Activity/app/Http/Livewire/ Modules/Activity/app/Livewire/
grep -rn "@livewire" Modules/Activity --include="*.blade.php"
grep -rn "<livewire:" Modules/Activity --include="*.blade.php"
find Modules/Activity/app/Filament -iname '*widget*'
ls Modules/Activity/resources/views/pages
```

## Classi Livewire trovate: zero

Il primo comando (`extends Component|Livewire` su tutti i `.php` del modulo, vendor escluso) non restituisce alcun file. In dettaglio:

| Posizione | Esito |
|---|---|
| `Modules/Activity/app/Http/Livewire/` | La directory esiste ma contiene solo `_components.json` (contenuto: `[]`, cioè zero alias registrati) e `.gitkeep`: nessun `.php` |
| `Modules/Activity/app/Livewire/` | Non esiste |
| `find -iname '*livewire*'` | Unici hit: i file di questa campagna in `docs/bmad/` e la directory vuota `app/Http/Livewire`. Nessuna classe, nessuna vista `livewire/` |

Conclusione verificata: il modulo **non possiede** alcun componente Livewire, né classico (`Http/Livewire`) né nel layout Livewire 3/4 (`app/Livewire`).

## Verifica del montaggio: zero hit nelle viste del modulo

Il modulo può comunque *montare* componenti altrui senza possederne. Verificato su tutti i 9 file `.blade.php` di `Modules/Activity/resources/views/`:

| Meccanismo | Comando | Esito |
|---|---|---|
| `@livewire(...)` | `grep -rn "@livewire" Modules/Activity --include="*.blade.php"` | **0 hit** |
| `<livewire:... />` | `grep -rn "<livewire:" Modules/Activity --include="*.blade.php"` | **0 hit** |
| Pagina Folio/Volt | `ls Modules/Activity/resources/views/pages` + lettura del file | Esiste `pages/api/log-download.blade.php` (36 righe): pagina Folio con `render()` closure che streama un file di log via `DownloadLogFileAction` (riga 31). Non è un componente Volt, non monta Livewire: è una risposta binaria |
| Render hook / widget in provider Filament | `find Modules/Activity/app/Filament -iname '*widget*'` | **0 hit**: sotto `app/Filament/` esistono solo `Actions, Forms, Pages, Resources`: nessuna directory `Widgets` |

Conclusione verificata: Activity non monta nessun componente Livewire, proprio o altrui. Il suo contributo HTTP è una pagina Folio di download log: forma "endpoint", non frammento di chrome.

## Widget Filament esistenti nel modulo Activity: nessuno

`find Modules/Activity/app/Filament -iname '*widget*'` non restituisce nulla e la directory `app/Filament/Widgets/` non esiste. Il punto in cui `XotBasePanelProvider` cerca automaticamente i widget di un modulo è `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php` (`discoverWidgets(base_path('Modules/'.$this->module.'/app/Filament/Widgets'), ...)`): per Activity quel path è assente, quindi nessun widget del modulo viene auto-scoperto.

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
|: |: |: |: | Tabella vuota: zero classi da classificare |

**Cluster A: zero candidati.** Non esistono componenti Livewire in Activity, quindi nessuno può essere montato nel chrome di un panel Filament.

**Cluster B: zero candidati.** Il modulo non ha alcun Filament Widget esistente, quindi non c'è nulla che duplichi un ipotetico componente.

**Cluster C: zero candidati.** Non c'è alcuna pagina/componente instradato da escludere: l'unica pagina Folio (`api/log-download`) è un endpoint di download, non una pagina a tutto schermo "esclusa perché fuori scope".

## Verdetto

**Nessun candidato, nessuna story di implementazione.** Audit log e activity feed del modulo restano dove sono (Resource/Actions Filament), non vanno "convertiti" inventando widget KPI. Questo file resta come gate anti-scope-creep: chiunque proponga un widget Activity deve prima creare o individuare il componente reale e rieseguire questo inventario.

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

- [x] Inventario completo del modulo (0 classi trovate, `extends Component|Livewire` su tutti i `.php`)
- [x] Verifica montaggio nelle viste del modulo (`@livewire`, `<livewire:`, Folio `pages/`)
- [x] Verifica widget gemelli (`app/Filament/Widgets` assente)
- [x] Nessun widget nuovo proposto senza prima verificare l'esistenza di un componente
- [x] Nessuna story di conversione creata (zero candidati reali)
