---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget tech spec"
issues: []
discussions: []
title: "Tech spec — Geo"
type: tech-spec
module: Geo
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
  - ../stories/12.1.retire-geo-test-livewire.story.md
---

# Tech spec Geo

Dettagli e citazioni: [livewire-inventory.md](./livewire-inventory.md).

Ritiro 12.1 (`Test.php` + `livewire/test.blade.php` + copie `.test` + voce `_components.json`): verificato orfano repo-wide. **Drift osservato in audit**: file di nuovo su disco; `_components.json` contiene solo `test`. Pest `HttpLivewireTestRetiredTest` già presente in `tests/Unit`.

`FormSearchAddressCategories`: non convertire (FR-G003). Note di audit: unico mount in `components/form_search_address_categories.blade.php:6` via wrapper `<x-geo::form-search-address-categories>` mai incluso; `render()` punta a `geo::livewire.form-search-address-categories` (assente — disco `form_search_address_categories`); alias fuori dalla cache corrente. Map widgets FQCN intatti.
