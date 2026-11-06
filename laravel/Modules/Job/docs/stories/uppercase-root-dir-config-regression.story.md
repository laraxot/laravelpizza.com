---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "uppercase root dir config regression.story"
issues: []
discussions: []
id: story-uppercase-root-dir-config-regression
slug: uppercase-root-dir-config-regression
status: investigated
priority: medium
title: Regressione: Modules/Job/Config (maiuscolo) ricomparso nella root del modulo
created_at: 2026-09-22
updated_at: 2026-09-22
bmad_phase: analysis
module: Job
---

# Regressione naming: Modules/Job/Config

## Contesto

Audit trasversale (2026-09-22, swarm parallelo su tutti i Moduli/Temi) per la
regola "nessuna cartella con maiuscole nella root di un modulo": SSoT:
`Modules/Xot/docs/case-sensitivity-rules.md`. Trovata `Modules/Job/Config/`
(maiuscolo) nella root, accanto alla `Modules/Job/config/` (minuscolo) già
corretta.

## Storia pregressa (git log -S / --follow)

- `d2d396cd73` (2026-07-07, "Fix module directory naming convention: remove
  capitals from root") aveva già risolto il caso, spostando
  `Job/Config/{.gitkeep,config.php}` dentro `Job/config/Config/...`.
- `a54cefa9e0` (2026-08-18, "fix: remove case-insensitive duplicate paths
  with identical content") ha ulteriormente ripulito 318 coppie
  case-duplicate a livello repo.
- `4d7c57c209` (2026-09-15, "feat(ptv): fix getTableColumns final +
  quality-gates update + random-parallel-correction (swarm/bmad/second-brain)")
  ha **ri-creato** `Modules/Job/Config/.gitkeep` e
  `Modules/Job/Config/config.php` (contenuto `return [];`) come side-effect
  non intenzionale di un lavoro non correlato (verosimilmente uno swarm/agent
  che ha girato `php artisan module:make-config` o simile, che per default
  nwidart-modules genera lo stub in `Config/` PascalCase).

## Stato attuale

- `Modules/Job/config/config.php`: **canonico**, contenuto reale
  (`'name' => 'Job', 'icon' => 'job-icon'`), nessun riferimento rotto.
- `Modules/Job/Config/config.php`: **stub vuoto** (`return [];`), nessun
  riferimento nel codice (grep su `Modules/Job` e su `composer.json` /
  `module.json`: zero hit), quasi certamente scaffolding morto rigenerato per
  errore.

## Raccomandazione

Eliminare `Modules/Job/Config/` (intera directory, stub vuoto e non
referenziato). Nessun merge necessario: `config/config.php` è già completo e
canonico. Rischio: basso (nessuna referenza trovata), ma verificare con
`grep -r` post-fix + un `php artisan config:clear` / avvio smoke test del
modulo prima di committare, per escludere autoload cache stantio.

## Follow-up non in scope (annotato, non eseguito)

`Modules/Job/docs/` ha ~5 varianti quasi duplicate di indice
(`00-INDEX.md`, `00-index.md`, `INDEX.md`, `INDEX_GENERATED.md`,
`index-generated.md`, `index.md`, `index_generated.md`, `rules-index.md`):
candidato per una story di consolidamento dedicata (pattern già visto in
`docs-index-audit.story.md`, 2026-09-03).
