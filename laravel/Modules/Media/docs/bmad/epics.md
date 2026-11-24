---
title: "Epics — Media"
type: epics
status: active
tags: [media, docs]
created: 2026-10-06
updated: 2026-11-16
bmad: true
module: Media
qmd: "epics Media guard AwsTest S3Test prunable TemporaryUpload cast id cancellazione logica codice morto test coverage story acceptance"
related:
  - ./audits/media-audit.md
  - ./decision-log.md
  - ./piano-miglioramento.md
---

# Epics — Media

Sostituisce il template. Ogni epic nasce da un finding dell'[audit](./audits/media-audit.md); formato: obiettivo, Acceptance (AC), task.

## E1 — Guard sulle pagine di diagnostica (P1-1, D-4)

- AC1: `AwsTest` e `S3Test` usano `SuperAdminOnlyTrait` (o il cluster).
- AC2: Pest `actingAs` utente senza ruolo → 403/non accessibile; `super-admin` → accessibile.

## E2 — Pulizia dei caricamenti temporanei (P1-2, D-1)

- AC1: `TemporaryUpload::prunable()` implementato (scadenza dichiarata, scope `old()` corretto).
- AC2: `php artisan model:prune --pretend --model='Modules\Media\Models\TemporaryUpload'` non solleva eccezioni; Pest sul prune.
- AC3: conteggio dei record rimossi registrato (log).

## E3 — `Media::id` coerente con lo schema (P1-3, D-2)

- AC1: decisione D-2 presa; cast e test allineati.
- AC2: `Modules/Media/tests/Unit/Models` → 0 fail.

## E4 — Allegati-prova non cancellabili (P1-4, D-3)

- AC1: D-3 decisa dal committente.
- AC2: Pest: la cancellazione fisica di un media «documentale» è negata; ammessa su un rigenerabile.

## E5 — Codice senza caller (P1-5, D-5)

- AC1: `StreamVideoAction`, `ConvertController`, Request S3 cancellati o cablati con policy.
- AC2: se cablato, Pest: utente non autenticato → 401/403 sullo streaming.

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_JVgku7
**Task:**
- [ ] Task 1
- [ ] Task 2
<<<<<<< .merge_file_MgvpTc
<<<<<<< .merge_file_E8imLa
=======
=======
>>>>>>> .merge_file_aJre6u
=======
>>>>>>> .merge_file_xsgdgO
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_MgvpTc
>>>>>>> .merge_file_k8XIHv
=======
>>>>>>> .merge_file_aJre6u
## E6 — Docs e debito (P1-6, P2)

- AC1: nessuna classe inesistente nelle docs (`rg 'UploadMediaAction|ProcessMediaAction|MediaCollections' docs/bmad` → solo nel decision-log/audit come «inesistenti»).
- AC2: stringhe letterali di `AwsTest`/`ConvertAction` in `lang/it`; 2 `@phpstan-ignore` risolti.
- AC3: junk rimosso (`BaseModel.php.backup-…`, `.to_xot`, `Commands/_components.json`); `print_r` tolto.
- AC4: 5 file «coverage» sostituiti da test di comportamento; 2 `->todo()` chiusi.
