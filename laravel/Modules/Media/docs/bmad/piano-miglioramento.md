---
title: "Piano di miglioramento — Media"
type: plan
status: review
updated: 2026-11-16
module: Media
<<<<<<< HEAD
<<<<<<< HEAD
qmd: "piano miglioramento Media P0 P1 P2 BMAD guard diagnostica prunable cast id cancellazione logica codice morto sequenza criteri"
=======
=======
=======
<<<<<<< HEAD
qmd: "piano miglioramento Media P0 P1 P2 BMAD guard diagnostica prunable cast id cancellazione logica codice morto sequenza criteri"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_mg11wH
qmd: "piano miglioramento Media P1 P2 guard diagnostica prunable cast id cancellazione logica codice morto sequenza criteri"
=======
qmd: "piano miglioramento Media P0 P1 P2 BMAD guard diagnostica prunable cast id cancellazione logica codice morto sequenza criteri"
>>>>>>> .merge_file_ZcDMPy
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
related:
  - ./audits/media-audit.md
  - ./epics.md
  - ./decision-log.md
---

# Piano di miglioramento — Media

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_mg11wH
Derivato dall'[audit](./audits/media-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 2) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 47 test / 127 app PHP).
3. Allineare Filament (resources=3) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2

1. Deduplicare docs BMAD/ECC storici; frontmatter YAML + `qmd` su ogni `.md` attivo.
2. Rimuovere legacy views/admin_test se dead.
3. Profiling N+1 e i18n (zero label hardcoded).

## Sequenza

1. Story P0 disgiunte + lock.
2. PHPStan modulo verde (già ok a livello `Modules`).
3. Pest mirato o skip documentato.
4. Aggiornare ECC checklist e QMD.

## Criteri di completamento

- [ ] P0 chiusi con Pest di regressione
- [ ] PHPStan `Modules/Media` = 0
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con esiti
=======
>>>>>>> .merge_file_ZcDMPy
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
Derivato dall'[audit profondo](./audits/media-audit.md). Epic e AC: [epics.md](./epics.md). Nessun P0 dimostrato.

## P1 (ordine consigliato)

1. **E1** — `SuperAdminOnlyTrait` su `AwsTest`/`S3Test` (D-4): chiude la superficie più esposta con una riga per pagina.
2. **E2** — `TemporaryUpload::prunable()` (D-1): oggi `model:prune` solleva eccezione.
3. **E3** — `Media::id` coerente con lo schema (D-2): sblocca i 14 test pending.
4. **E4** — allegati-prova non cancellabili (D-3): serve decisione del committente.
5. **E5** — `StreamVideoAction`/`ConvertController`/Request S3: cancellare o cablare con policy (D-5).
6. Docs: gap-fill fatto (architecture, decision-log, epics, purpose); restano 31 `.md` con nome non conforme.

## P2

1. Stringhe letterali in `AwsTest` e `ConvertAction` → `lang/it`.
2. 2 `@phpstan-ignore` → correggere il tipo.
3. Junk: `BaseModel.php.backup-…`, `SvgExistsAction.to_xot`, `Commands/_components.json`; `print_r` in `ConvertVideoCommand`.
4. `TemporaryUpload::$guarded = []` → `$fillable` esplicito.
5. Action senza caller: `ConvertVideoAction`, `ConvertVideoByConvertDataAction`, `AttachMediaAction`.
6. 5 file «coverage» e 2 `->todo()` → test di comportamento.
7. Docs BMAD/ECC storici: deduplicare; frontmatter YAML + `qmd` su ogni `.md` attivo.
8. Profiling N+1 sulle tabelle Filament; i18n con zero label hardcoded.

## Sequenza e gate

1. Story disgiunte + lock (`bashscripts/lock/`).
2. PHPStan `Modules/Media` = 0.
3. Pest mirato su scratch DB: nessun `migrate:fresh`/`RefreshDatabase`/`--force`.
4. Aggiornare [ECC](../ecc/00-index.md) e `qmd update`.

## Criteri di completamento

- [ ] Utente senza ruolo → 403 su `AwsTest`/`S3Test` (Pest)
- [ ] `model:prune --pretend --model=TemporaryUpload` senza eccezioni
- [ ] `Modules/Media/tests/Unit/Models` → 0 fail
- [ ] D-3 decisa e attuata
- [ ] PHPStan `Modules/Media` = 0
<<<<<<< HEAD
<<<<<<< HEAD
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con gli esiti
=======
=======
=======
<<<<<<< HEAD
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con gli esiti
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_mg11wH
=======
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con gli esiti
>>>>>>> .merge_file_ZcDMPy
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
