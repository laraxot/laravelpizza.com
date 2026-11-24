---
title: "Audit BMAD — Lang"
type: audit
status: review
updated: 2026-11-16
module: Lang
qmd: "audit BMAD Lang sintesi gate tracker chiavi mancanti non cablato test coverage schema user_id Post fuori scope config morta"
related:
  - ./audits/lang-audit.md
  - ./piano-miglioramento.md
  - ../ecc/lang-ecc-audit.md
---

# Audit BMAD — Lang

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/lang-audit.md](./audits/lang-audit.md).

<<<<<<< .merge_file_FFk0sO
**Scopo in una frase:** Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua ([purpose.md](./purpose.md)).
=======
<<<<<<< HEAD
**Scopo in una frase:** Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua ([purpose.md](./purpose.md)).
=======
<<<<<<< .merge_file_RTGPLE
**Scopo in una frase:** Lang tiene fuori dal codice ogni parola che un utente legge ([purpose.md](./purpose.md)).
=======
**Scopo in una frase:** Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua ([purpose.md](./purpose.md)).
>>>>>>> .merge_file_mrLFNn
>>>>>>> laraxot/dev
>>>>>>> .merge_file_n7vxIv

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
<<<<<<< .merge_file_FFk0sO
| PHP `app/` / test PHP / `*Test.php` | 72 / 51 / 29 (ricontato 2026-11-19: 72 / 53 / 29) |
=======
<<<<<<< HEAD
| PHP `app/` / test PHP / `*Test.php` | 72 / 51 / 29 (ricontato 2026-11-19: 72 / 53 / 29) |
=======
<<<<<<< .merge_file_RTGPLE
| PHP `app/` | 72 |
| Test | 51 |
| Resources | 2 |
| Actions | 17 |
| Services | 0 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua.**

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
| PHP `app/` / test PHP / `*Test.php` | 72 / 51 / 29 |
=======
| PHP `app/` / test PHP / `*Test.php` | 72 / 51 / 29 (ricontato 2026-11-19: 72 / 53 / 29) |
>>>>>>> .merge_file_mrLFNn
>>>>>>> laraxot/dev
>>>>>>> .merge_file_n7vxIv
| Models / Policy / Resource / Widget | 7 / 4 / 2 / 1 |
| Actions / Services / Migration / Lang IT | 17 / 0 / 11 / 33 |
| Marker conflitto / `RefreshDatabase` / `dd()` | 0 / 0 / 0 |
| Policy `return true` | 2, solo in `LangBasePolicy::before()` (bypass `super-admin` / `lang::admin`) |
| `.md` in `docs/` | 955 (1 senza frontmatter, 111 nome non conforme) |

## Finding principali

| # | Sev | Finding |
|---|---|---|
| 1 | P1 | Tracker DB «chiavi mancanti» non cablato: `registerTranslator()` commentato (`LangServiceProvider.php:43`), trait usato solo da una sonda PHPStan; `translations` senza scrittore in produzione |
| 2 | P1 | Docs contraddicono il codice: architettura con `ValidateTranslationsAction`, `LangResource`, `lang_table` inesistenti; decision-log fittizio (gap-fill fatto) |
| 3 | P1 | Test: 4 file «coverage» da 2.248 righe; `tests/Feature` 10 pass / 13 fail su scratch DB (`user_id` bigint vs UUID) |
| 4 | P2 | `LocaleSwitcherRefresh.php:34,45` con stringhe letterali in un modulo che le vieta |
| 5 | P2 | `config/lang.php` mai letto; `Post` (CMS) senza consumatori fuori da Lang; `Write/ReadTranslationFileAction` morte |

Nessun P0: policy corrette (`LangBasePolicy::before()` con bypass `super-admin`/`lang::admin`, deny-by-default sul resto).

## Gate

- PHPStan `Modules/Lang`: **0 errori**.
- Pest: **parziale** — `tests/Feature` 10 pass / 13 fail (schema `user_id`, [P1-3](./audits/lang-audit.md#p1-3--test-copertura-inseguita-e-suite-non-verde-su-scratch-db)); `tests/Unit` non eseguito (macchina con load ≈ 50).
- Gap-fill BMAD: [purpose](./purpose.md), [architecture](./architecture.md), [decision-log](./decision-log.md), [epics](./epics.md), [brainstorming](./brainstorming.md).

## Riferimenti

[Piano](./piano-miglioramento.md) · [Epics](./epics.md) · [Decision log](./decision-log.md) · [ECC](../ecc/lang-ecc-audit.md) · [Story](./stories/module-bmad-audit.story.md)
