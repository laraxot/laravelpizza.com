---
title: "Notify: bonifica docs .md (duplicati, nomi, frontmatter qmd)"
type: story
status: review
module: Notify
epic: docs-second-brain
story_id: notify-docs-zen-conventions
created: 2026-11-25
updated: 2026-11-25
qmd: "notify docs bonifica duplicati md5 kebab-case nomi datati frontmatter qmd yaml chiavi duplicate template fabbricati alias superseded _integration -integration"
related:
  - ../../../../Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md
---
# Notify: bonifica docs `.md`

## Context and Problem Statement

`Modules/Notify/docs` era la cartella docs piu' inquinata del progetto (3855 `.md`): copie esatte,
coppie `snake_case`/`kebab-case` dello stesso documento, stub "rinominato in" autoreferenziali,
alias superseded, nomi `-.md.md` generati da una vecchia rimozione date, template di prodotto
generici. Rumore che degrada QMD e confonde gli agenti.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

Lane A della story ombrello `Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md`.

## Perche'

`Modules/Notify/docs` era la cartella docs piu' inquinata del progetto (3855 `.md`): copie esatte,
coppie `snake_case`/`kebab-case` dello stesso documento, stub "rinominato in" autoreferenziali,
alias superseded, nomi `-.md.md` generati da una vecchia rimozione date, template di prodotto
generici. Rumore che degrada QMD e confonde gli agenti.

## Prima / Dopo

| Metrica | Prima | Dopo |
|---|---:|---:|
| file `.md` | 3855 | 2896 |
| copie esatte (md5) oltre la prima | 319 | 5 (solo story protette + 1 index) |
| nomi con data | 14 | 0 |
| nomi non kebab (escl. README/CHANGELOG/00-INDEX/story) | 871 | 0 |
| senza frontmatter | 31 | 0 |
| senza `qmd` | 39 | 0 |
| frontmatter con chiavi duplicate (YAML non valido) | ~537 | 0 |

## Cosa e' stato fatto

- **18 template generici eliminati** (`product_roadmap`, `product-strategy`, `product_launch_plan`,
  `user_research`, `sprint_planning*`, `launch-plan`, `confidence_guidelines`, `duplicate_methods_report*`):
  nessun identificatore reale del modulo (verifica `grep` su `app/ config/ database/ routes/`).
- **~345 copie esatte eliminate** (2 passate: la seconda dopo la normalizzazione frontmatter ha fatto
  emergere 13 nuove copie). Canonico scelto per: fuori da `_da-riconciliare`, non `.divergenza`,
  nome kebab, senza suffisso `-N`, piu' referenziato, piu' superficiale.
- **20 alias `type: alias` + `superseded_by`** eliminati, link reindirizzati al canonico.
- **Rinomina kebab/no-data**: 33 rinomine pure; 596 collisioni risolte per sussunzione
  (244 sussunti, 12 stub sorgente scartati), sostituzione (3 + 7 stub "rinominato in" sostituiti dal
  contenuto reale `-.md.md`), fusione (309 righe uniche appese, 21 corpo intero appeso sotto
  `## Contenuto fuso da \`<vecchio nome>\``).
- `-integration/` fuso in `_integration/` (cartella rimossa); `.md` senza nome →
  `laravel-notifications-with-database.md`; `CHANGELOG.MD` → `CHANGELOG.md`.
- **Link**: 1496 riferimenti riscritti (risoluzione relativa + path `Modules/Notify/docs/...`) in
  ~460 file, di cui 14 fuori da Notify (Lang, User, Media, Ptv, Progressioni, Themes/Zero, `docs/`).
  7 voci d'indice verso template eliminati rimosse.
- **Frontmatter**: 30 aggiunti, 8 `qmd` aggiunti, 6 title/qmd vuoti riempiti, 435 chiavi duplicate
  rimosse (tenuta la prima, la piu' recente); placeholder `{{date}}` dei `wiki/_templates` quotati.
  `qmd` derivato da titolo + heading H2/H3 + cartella.

## Casi lasciati in dubbio

- Story identiche non toccate (regola: mai eliminare story): `stories/continuation{,-,-11}.story.md`,
  `stories/4.31.phpstan-swarm{,-15}-already-clean.story.md`, `bmad/stories/cleanup-notify{,-22}.story.md`
  (e altre story con suffisso `-`/`-NN`): candidate a `status: superseded`.
- `theme/sixteen/analysis/` e `wiki/theme/sixteen/analysis/`: alberi paralleli, solo `index.md` identico.
- `wiki/integrations/_da-riconciliare/` (757 file) e quasi-duplicati numerati (`analisi-dettagliata-1..8`,
  `analisiettagliata-*`, `analysis-dettagliata-*`): non identici, richiedono riconciliazione semantica.
- Cartelle non kebab non rinominate: `project_docs/`, `_integration/`, `_templates/`, `_da-riconciliare/`, `.schema/`.
- Doc di prodotto non nella lista template (`prd.md`, `roadmap/vision.md`, `inbound-marketing-strategy.md`,
  `release-marketing-standard.md`): lasciati.
- Molti file contengono una seconda copia del frontmatter nel corpo (bug di un generatore): non rimossa.

## Gate

Solo file `.md` in `docs/`: PHPStan/Pint/Pest non applicabili (skip documentato); PHPStan gia' 0.
Verifica: misure ripetute con lo stesso script, `yaml.safe_load` su tutti i frontmatter = 0 errori,
rilancio link-rewriter sulle mappe = 0 riferimenti residui ai vecchi path.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
