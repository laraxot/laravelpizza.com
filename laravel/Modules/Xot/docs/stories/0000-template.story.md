---
title: "STORY — <!-- problema + soluzione in una riga -->"
type: story
status: proposed            # proposed | in-progress | review | done | cancelled
date: YYYY-MM-DD
module: <!-- NomeModulo -->
decision-makers:
qmd: "bmad story MADR template Context Drivers Options Outcome Confirmation"
related: []
---

<!-- File: docs/bmad/stories/<slug>.story.md (o docs/stories/).
     Formato obbligatorio: MADR breve (stesso scheletro del harness ADR).
     SSoT template: Modules/Xot/docs/bmad/stories/0000-template.story.md
     Gate: Modules/Xot/tests/Unit/Docs/BmadStoriesAreMadrFormatTest.php -->

# <!-- Titolo: il problema risolto e la soluzione scelta -->

## Context and Problem Statement

<!-- 2-3 frasi. Chiudi con la domanda a cui la story risponde. -->

## Decision Drivers

- <!-- forza, vincolo, reclamo utente, invariante di dominio -->

## Considered Options

- <!-- status quo / non fare -->
- <!-- opzione scelta -->

## Decision Outcome

Scelta: **<!-- opzione -->**, perché <!-- driver -->.

### Consequences

- Buono, perché <!-- … -->
- Cattivo, perché <!-- … -->

### Confirmation

<!-- Pest (exit code + conteggio), PHPStan, o skip documentato host 10.100.200.15. -->
