---
title: FieldRefreshAction ricalcola davvero (logica persa il 2026-09-02)
status: review
module: Xot
created: 2026-11-05
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Progressioni/docs/stories/progressioni-assenze-tab-esperienza.story.md
---

# FieldRefreshAction ricalcola davvero

## Fase BMAD

Bugfix, in review. Pest non eseguito: 10.100.200.15 e' produzione.

## Problema

Il bottone di ricalcolo accanto ai campi delle schede (`Xot/app/Filament/Actions/Form/FieldRefreshAction.php`) mostrava
"Valore ricalcolato" senza ricalcolare nulla. Trovato il 2026-11-05 lavorando sull'edit scheda Progressioni.

## Causa (git log -S, repo Xot)

- `fb62210ee8` (2026-08-31): versione funzionante, chiama `get{Campo}()` e `$set($name, $value)`.
- `c254b66aa1` (2026-09-02, messaggio "."): logica rimossa, resta solo la notifica.
- Il test `Xot/tests/Unit/XotFieldRefreshQueryExportCoverageTest.php` invoca i metodi per riflessione dentro
  `try/catch` che ingoiano tutto: copertura senza verifica, non poteva accorgersene.

## Correzione

- Logica ripristinata in avanti: gemello puro `get{Studly(campo)}()` (regola accessor + gemello), valore messo nel form,
  nessun salvataggio (lo fa l'utente).
- `hasPublicGetter()`: `is_callable()` e' sempre true sui model Eloquent (`__call`), quindi un gemello mancante
  (es. `getLastEsperienzaAt`) finiva in BadMethodCallException; ora `method_exists` + `ReflectionMethod::isPublic()`.
- Test vero: `Xot/tests/Unit/Filament/FieldRefreshActionTest.php` (nome del gemello, valore scritto nel form, gemello
  mancante/protected non chiamato).
- Verifica sola lettura: sulla scheda 11123 tutti i campi del form con bottone di ricalcolo hanno il gemello public.
- Pint e PHPStan ok.
