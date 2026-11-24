---
title: "Audit qualita' modulo Activity"
type: story
status: in-review
module: Activity
created: 2026-11-19
updated: 2026-11-19
issues: ["laraxot/base_techplanner_fila5#64"]
tags: [audit, qualita, docs, phpstan, pest]
qmd: "audit qualita story activity"
---

# Audit qualita' — modulo Activity

Story BMAD dell'audit di qualita' coordinato nella issue
[#64](https://github.com/laraxot/base_techplanner_fila5/issues/64).
Ambito: solo `Modules/Activity` (documentazione e `app/`).

## Baseline e risultato

| Verifica | Prima | Dopo |
|---|---|---|
| PHPStan max (`Modules/Activity`) | 0 errori | 0 errori |
| Pest (`Modules/Activity/tests`) | 12 falliti / 458 passati / 16 skipped | 11 falliti / 459 passati / 16 skipped |
| Occorrenze `mixed` in `app/` | 36 | 29 |

## Documentazione

- File `.md` con data/timestamp nel nome: 0 rinominati, 11 uniti al file canonico
  omonimo (contenuto unico conservato sotto "Contenuto unito da ..."), 7 rimossi perche' vuoti
  o gia' contenuti nel canonico. La data originale e' ora nel frontmatter `created:`.
- Duplicati esatti (contenuto identico) rimossi: 15; tenuta la copia meglio collocata
  (no `archive/`, `raw/`, suffissi `-1`/`_1`, maiuscole o underscore) e link interni aggiornati.
- `docs/index.md` (indice canonico): aggiunta la sezione "Mappa delle cartelle" con link relativi
  a tutte le aree; link rotti agli altri moduli corretti dove la destinazione era determinabile.

## Codice (`app/`)

- `Filament/Pages/ListLogActivities.php`: 4 conversioni duplicate del risultato di `__()` sostituite dall'unico helper `stringifyTranslationValue()` (DRY), rimosso l'import `Safe\json_encode` non piu' usato
- `Listeners/LogoutListener.php`: rimossi `@var mixed`/`@var Carbon` superflui (il tipo e' gia' inferito)
- Rimosso `Models/Contracts/ActivityRecorderContract.php`, copia identica senza riferimenti di `Contracts/ActivityRecorderContract.php`
- Rimossi i placeholder datati vuoti di `docs/raw/root-import/` e aggiornata la sezione naming di `docs/index.md`

## Scoperte da gestire (non risolte in questo audit)

- Coesistono `Actions/ActivityLogger` e `Adapters/ActivityLogger`, entrambi usati: valutare l'unificazione
- `README.md` del modulo punta a `docs/configuration.md` inesistente (link preesistente)
- Nell'indice restano link rotti verso file mai esistiti o di altri progetti: da rivedere a mano.
- `docs/` contiene ancora `INDEX.md`, `README.md` e `index.md` affiancati (collisione su filesystem
  case-insensitive): da consolidare in un solo indice con decisione condivisa.

## Criteri di accettazione

- [x] PHPStan max a 0 errori senza ignore/baseline
- [x] Nessun `.md` con data nel nome
- [x] Nessun duplicato esatto in `docs/`
- [x] Test Pest non peggiorati
- [ ] Punti aperti sopra risolti
