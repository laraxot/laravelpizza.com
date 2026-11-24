---
title: "Audit qualita' modulo UI"
type: story
status: in-review
module: UI
created: 2026-11-19
updated: 2026-11-19
issues: ["laraxot/base_techplanner_fila5#64"]
tags: [audit, qualita, docs, phpstan, pest]
qmd: "audit qualita story"
---

# Audit qualita' — modulo UI

Story BMAD dell'audit di qualita' coordinato nella issue
[#64](https://github.com/laraxot/base_techplanner_fila5/issues/64).
Ambito: solo `Modules/UI` (documentazione e `app/`).

## Baseline e risultato

| Verifica | Prima | Dopo |
|---|---|---|
| PHPStan max (`Modules/UI`) | 0 errori | 0 errori |
| Pest (`Modules/UI/tests`) | 11 falliti / 223 passati / 116 skipped | 11 falliti / 223 passati / 116 skipped |
| Occorrenze `mixed` in `app/` | 103 | 97 |

## Documentazione

- File `.md` con data/timestamp nel nome: 7 rinominati, 15 uniti al file canonico
  omonimo (contenuto unico conservato sotto "Contenuto unito da ..."), 14 rimossi perche' vuoti
  o gia' contenuti nel canonico. La data originale e' ora nel frontmatter `created:`.
- Duplicati esatti (contenuto identico) rimossi: 37; tenuta la copia meglio collocata
  (no `archive/`, `raw/`, suffissi `-1`/`_1`, maiuscole o underscore) e link interni aggiornati.
- `docs/index.md` (indice canonico): aggiunta la sezione "Mappa delle cartelle" con link relativi
  a tutte le aree; link rotti agli altri moduli corretti dove la destinazione era determinabile.

## Codice (`app/`)

- Rimossi file morti non caricati dall'autoloader: `Filament/Widgets/UserCalendarWidget.php.{fila3,disabled,disabled2}`, `Actions/Panel/ApplyCalendarToPanelAction.php.disabled`, `Http/Kernel.php.no`
- Rimossi duplicati senza riferimenti (grep dell'intero `laravel/`): `app/Data/UserData.php` (cartella `Data` vietata da `DatasFolderConventionTest`, resta `Datas/UserData`), `app/Forms/Components/RadioCardSelector.php` (resta `Filament/Forms/Components/RadioCardSelector`), `app/Contracts/HasTableLayout.php` (resta `Filament/Actions/Table/HasTableLayout`)

## Scoperte da gestire (non risolte in questo audit)

- Restano due `TableLayoutTrait` (`Traits/` e `Filament/Actions/Table/`) entrambi referenziati: unificarli richiede di toccare consumatori in altri moduli
- Le 11 failure Pest sono preesistenti e legate all'ambiente (non toccate)
- Nell'indice restano link rotti verso file mai esistiti o di altri progetti: da rivedere a mano.
- `docs/` contiene ancora `INDEX.md`, `README.md` e `index.md` affiancati (collisione su filesystem
  case-insensitive): da consolidare in un solo indice con decisione condivisa.

## Criteri di accettazione

- [x] PHPStan max a 0 errori senza ignore/baseline
- [x] Nessun `.md` con data nel nome
- [x] Nessun duplicato esatto in `docs/`
- [x] Test Pest non peggiorati
- [ ] Punti aperti sopra risolti
