---
title: audit ridondanza temi (one zero three)
module: One
type: audit
status: draft
tags: [redundancy, theme, blade, layout]
created: "2026-05-27"
updated: "2026-05-27"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/162"
related:
  - ../code-redundancy-audit.md
  - ../../../Modules/Ptv/docs/wiki/redundancy-audit.md
  - ../../../Modules/Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md
  - ../../../Modules/Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md
---

# Audit ridondanza temi

## Visione e religione (zen)

- **Minimalismo**: un tema contiene solo ciò che lo rende esteticamente unico.
- **Zen**: la bellezza non sta nel duplicare il codice, ma nel riutilizzare l’anima (logic) cambiandone il vestito (style).
- **Filosofia**: One, Zero e Three dovrebbero condividere la maggior parte della logica di interazione e differire soprattutto in Blade/CSS.

## Analisi ridondanze

- **Auth views**: `login.blade.php` duplicato tra temi con variazioni minime.
- **Assets**: JS/CSS duplicati come copie di vendor non centralizzati.
- **Layouts**: `app.blade.php` quasi identico → candidato estrazione in layer UI agnostico.

## Politica di consolidamento

- [ ] Preferire componenti Blade anonimi (`<x-... />`) centralizzati in `Modules/UI`.
- [ ] Evitare cartelle “shared” sotto `Themes/` che diventano un modulo travestito: se è shared, è modulo UI.
- [ ] Documentare differenza “filosofica” tra One/Zero/Three come **presentazione**, non business logic.

## Dubbi e perplessità

- Perché `Themes/One` e `Themes/Three` se lo stack applicativo è lo stesso?
- `Three` è target futuro o esperimento parallelo?

## Piano di azione

1. [ ] Confrontare `login.blade.php` tra One/Zero/Three.
2. [ ] Estrarre componenti form in `Modules/UI`.
3. [ ] Aprire/aggiornare issue “Theme Consolidation” (repo tema `origin` quando esiste; altrimenti monorepo).
