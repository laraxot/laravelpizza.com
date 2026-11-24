---
title: "Audit BMAD — Media"
type: audit
status: review
updated: 2026-11-16
module: Media
<<<<<<< .merge_file_jYo7V0
<<<<<<< .merge_file_arOS2s
qmd: "audit BMAD Media source-first qualità sintesi gate AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione fisica codice morto"
=======
=======
>>>>>>> .merge_file_A3Svlj
<<<<<<< HEAD
<<<<<<< HEAD
qmd: "audit BMAD Media source-first qualità sintesi gate AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione fisica codice morto"
=======
=======
=======
<<<<<<< HEAD
qmd: "audit BMAD Media source-first qualità sintesi gate AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione fisica codice morto"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_lb7wee
qmd: "audit BMAD Media sintesi gate AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione fisica codice morto"
=======
qmd: "audit BMAD Media source-first qualità sintesi gate AwsTest S3Test guard TemporaryUpload prunable Media id cast cancellazione fisica codice morto"
>>>>>>> .merge_file_RKyJsP
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_jYo7V0
>>>>>>> .merge_file_KbhPOY
=======
>>>>>>> .merge_file_A3Svlj
related:
  - ./audits/media-audit.md
  - ./piano-miglioramento.md
  - ../ecc/media-ecc-audit.md
---

# Audit BMAD — Media

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/media-audit.md](./audits/media-audit.md).

<<<<<<< .merge_file_jYo7V0
<<<<<<< .merge_file_arOS2s
**Scopo in una frase:** Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono, senza che il dominio sappia nulla di dischi e conversioni ([purpose.md](./purpose.md)).
=======
=======
>>>>>>> .merge_file_A3Svlj
<<<<<<< HEAD
<<<<<<< HEAD
**Scopo in una frase:** Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono, senza che il dominio sappia nulla di dischi e conversioni ([purpose.md](./purpose.md)).
=======
=======
=======
<<<<<<< HEAD
**Scopo in una frase:** Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono, senza che il dominio sappia nulla di dischi e conversioni ([purpose.md](./purpose.md)).
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_lb7wee
**Scopo in una frase:** Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono ([purpose.md](./purpose.md)).
=======
**Scopo in una frase:** Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono, senza che il dominio sappia nulla di dischi e conversioni ([purpose.md](./purpose.md)).
>>>>>>> .merge_file_RKyJsP
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_jYo7V0
>>>>>>> .merge_file_KbhPOY
=======
>>>>>>> .merge_file_A3Svlj

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
<<<<<<< .merge_file_jYo7V0
<<<<<<< .merge_file_arOS2s
=======
=======
>>>>>>> .merge_file_A3Svlj
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_lb7wee
| PHP `app/` | 127 |
| Test | 47 |
| Resources | 3 |
| Actions | 51 |
| Services | 0 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
=======
>>>>>>> .merge_file_RKyJsP
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_jYo7V0
>>>>>>> .merge_file_KbhPOY
=======
>>>>>>> .merge_file_A3Svlj
| PHP `app/` / test PHP / `*Test.php` | 127 / 47 / 41 |
| Models / Policy / Resource / Widget | 4 / 4 / 3 / 1 |
| Actions / Services / Migration / Lang IT | 51 / 0 / 5 / 24 |
| Marker conflitto / `RefreshDatabase` / `@phpstan-ignore` | 0 / 0 / 2 |
| Policy `return true` | 2 (`before()`) |
| `.md` in `docs/` | 512 (16 senza frontmatter, 31 nome non conforme) |

## Finding principali

| # | Sev | Finding |
|---|---|---|
| 1 | P1 | `AwsTest`/`S3Test`: `putObject`/`deleteObject` sul bucket e dettagli di config, senza `canAccess` (`AwsTest.php:345,360`) — non provato a runtime |
| 2 | P1 | `TemporaryUpload` usa `MassPrunable` ma `prunable()` è commentato (`:241-244`): `model:prune --model=…` → `LogicException` (verificato) |
| 3 | P1 | `Media::id` cast `string` su PK bigint (`Media.php:144`); `MediaTest.php:369` fallisce (49 pass / 1 fail) |
| 4 | P1 | Cancellazione fisica degli allegati (`MediaTable.php:90`, nessun `SoftDeletes`) contro lo scopo «prova» |
| 5 | P1 | Senza caller e insicuri se cablati: `StreamVideoAction` (controllo aggirabile, `:71`), `ConvertController` (variabile `$id` mai passata, route vuote), Request S3 |
| 6 | P1 | Docs: architecture con 6 classi inesistenti (gap-fill fatto) |

Nessun P0 dimostrato. Policy corrette (`MediaBasePolicy::before()` con bypass `super-admin`/`media::admin`, deny-by-default sul resto).

## Gate

- PHPStan `Modules/Media`: **0 errori**.
- Pest: **parziale** — `tests/Unit/Models` 49 pass / 1 fail (`MediaTest.php:369`, P1-3), 14 pending dopo lo stop; resto non eseguito (macchina con load ≈ 50); da completare in ambiente testing non produttivo.
- Security/runtime: story figlie sui finding P1 ([epics](./epics.md)).
- Gap-fill BMAD: [architecture](./architecture.md), [decision-log](./decision-log.md), [epics](./epics.md), [brainstorming](./brainstorming.md), [purpose](./purpose.md).

## Riferimenti

[Piano](./piano-miglioramento.md) · [Epics](./epics.md) · [Decision log](./decision-log.md) · [ECC](../ecc/media-ecc-audit.md) · [Story](./stories/module-bmad-audit.story.md)
