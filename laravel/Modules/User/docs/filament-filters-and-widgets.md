---
title: "Filament 4: filtri pagina e widget (lezioni apprese)"
type: concept
tags: [filament, filters, widgets]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-filters-and-widgets filament 4: filtri pagina e widget (lezioni apprese)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Filament 4: filtri pagina e widget (lezioni apprese)

- Pagina: usare `HasFiltersForm` e renderizzare lo schema in Blade con `{{ $this->getFiltersForm() }}`.
- Widget: usare `InteractsWithPageFilters` e impostare `protected static ?bool $isLazyLoaded = false` (Filament 5.11; prima `$isLazy`, ora deprecata).
- Proprietà `$view` del Widget: NON statica in Filament 4 (il parent ha `$view` non static).
- In Blade del widget leggere i valori con `data_get($this->pageFilters, 'startDate')` e `data_get($this->pageFilters, 'endDate')`.
- Evitare `HasFiltersSchema` in questo caso (serve ai chart widget), e niente `->label()` / `->helperText()`.

Esempi minimi

Pagina (estratto):
- `use HasFiltersForm;` definire `filtersForm(Schema $schema)` con `DatePicker` startDate/endDate e `columns(2)`.
- In view: includere `{{ $this->getFiltersForm() }}` dentro una `<x-filament::section>`.

Widget (estratto):
- `class UserWidget extends Widget { use InteractsWithPageFilters; protected static ?bool $isLazyLoaded = false; protected string $view = 'user::filament.resources.user.widgets.user-widget'; }`
- In Blade widget: mostrare `{{ data_get($this->pageFilters, 'startDate') }}` e `{{ data_get($this->pageFilters, 'endDate') }}`.

Errori riscontrati e soluzioni
- `$view` static: causava fatal error. Soluzione: `$view` non static.
- Widget non aggiornato: causato dal lazy di default. Soluzione: `$isLazyLoaded = false`.
- Variabili Blade non definite: usare `$this->pageFilters` o accessor reattivi.
