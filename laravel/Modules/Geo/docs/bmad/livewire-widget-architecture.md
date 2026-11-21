---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget architecture"
issues: []
discussions: []
title: "Architecture — Geo"
type: architecture
module: Geo
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Architecture Geo

SSoT e citazioni file:riga: [livewire-inventory.md](./livewire-inventory.md).

```
blocks/map*.blade.php → @livewire(FQCN LocationMapWidget/LocationMapTableWidget) — intatti

Http/Livewire/Test (Component, 32 righe, vista disallineata) → RITIRO (12.1)
Http/Livewire/FormSearchAddressCategories (form FO, 218 righe)
  → montato solo da <x-geo::form-search-address-categories>, mai incluso;
    render() risolverebbe geo::livewire.form-search-address-categories (vista assente:
    su disco underscore) → escluso, Cluster C
```

Nota drift: story 12.1 `done`, ma i file di `Test` sono presenti su disco — ritiro da ri-applicare.
