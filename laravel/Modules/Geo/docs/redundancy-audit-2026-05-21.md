---
title: "Geo redundancy audit 2026-05-21"
type: audit
module: Geo
tags: [redundancy, casing, frontend-assets, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Geo redundancy audit 2026-05-21

High-risk findings:
- Large case-only duplicate set across docs: `PRODUCT_STRATEGY.md` vs `product_strategy.md`, `PRD.md` vs `prd.md`, `INDEX.md` vs `index.md`, and similar files.
- Case-only Vue/component/resource duplicates: `MapPane.vue` vs `mappane.vue`, `MapComponent.vue` vs `mapcomponent.vue`, `MyMap.vue` vs `mymap.vue`.
- Leaflet asset duplicates with case-only names: `MarkerCluster.css` vs `markercluster.css`, `L.Control.Locate.min.js` vs `l.control.locate.min.js`.
- Some map assets are duplicated under both `resources/js` and `resources/views/maps/...`.

Risk:
- Frontend builds and WSL sync can pick different files depending on case sensitivity.
- Duplicate map assets make bug fixes to Leaflet behavior non-local.

Suggested cleanup order:
1. Inventory actual imports from Vite/Blade before deleting any case variant.
2. Canonicalize frontend component names to one casing convention.
3. Keep external vendor map assets in one directory and reference them from views/build config.
4. Normalize docs to lowercase-kebab-case after code paths are stable.
