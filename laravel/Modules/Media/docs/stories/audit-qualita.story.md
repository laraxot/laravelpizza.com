---
title: "Audit qualita' modulo Media"
type: story
status: in-review
module: Media
created: 2026-11-19
updated: 2026-11-19
issues: ["laraxot/base_techplanner_fila5#64"]
tags: [audit, qualita, docs, phpstan, pest]
qmd: "audit qualita story media"
---

# Audit qualita' — modulo Media

Story BMAD dell'audit di qualita' coordinato nella issue
[#64](https://github.com/laraxot/base_techplanner_fila5/issues/64).
Ambito: solo `Modules/Media` (documentazione e `app/`).

## Baseline e risultato

| Verifica | Prima | Dopo |
|---|---|---|
| PHPStan max (`Modules/Media`) | 0 errori | 0 errori |
| Pest (`Modules/Media/tests`) | 14 falliti / 286 passati / 5 skipped / 2 todo | 14 falliti / 286 passati / 5 skipped / 2 todo |
| Occorrenze `mixed` in `app/` | 60 | 58 |

## Documentazione

- File `.md` con data/timestamp nel nome: 6 rinominati, 2 uniti al file canonico
  omonimo (contenuto unico conservato sotto "Contenuto unito da ..."), 2 rimossi perche' vuoti
  o gia' contenuti nel canonico. La data originale e' ora nel frontmatter `created:`.
- Duplicati esatti (contenuto identico) rimossi: 35; tenuta la copia meglio collocata
  (no `archive/`, `raw/`, suffissi `-1`/`_1`, maiuscole o underscore) e link interni aggiornati.
- `docs/index.md` (indice canonico): aggiunta la sezione "Mappa delle cartelle" con link relativi
  a tutte le aree; link rotti agli altri moduli corretti dove la destinazione era determinabile.

## Codice (`app/`)

- `Actions/Diagnostic/S3/TestCloudFrontConnectionAction.php`: `incompleteConfiguration(mixed, mixed, mixed)` sostituito da `incompleteConfiguration(list<string> $missing)` con array shape di ritorno; il calcolo delle chiavi mancanti e' fatto una sola volta
- Rimosso `Actions/Image/SvgExistsAction.to_xot` (file morto, la versione attiva e' `SvgExistsAction.php`; Xot ha la sua)

## Scoperte da gestire (non risolte in questo audit)

- Le azioni `Diagnostic/S3/*` restituiscono `array<string, mixed>`: introdurre una Data `DiagnosticResultData` (title/status/data) per tiparle
- Due `AddAttachmentAction` e due `MediaRelationManager` (Filament/ e HasMediaResource/) entrambi referenziati: da unificare
- Nell'indice restano link rotti verso file mai esistiti o di altri progetti: da rivedere a mano.
- `docs/` contiene ancora `INDEX.md`, `README.md` e `index.md` affiancati (collisione su filesystem
  case-insensitive): da consolidare in un solo indice con decisione condivisa.

## Criteri di accettazione

- [x] PHPStan max a 0 errori senza ignore/baseline
- [x] Nessun `.md` con data nel nome
- [x] Nessun duplicato esatto in `docs/`
- [x] Test Pest non peggiorati
- [ ] Punti aperti sopra risolti
