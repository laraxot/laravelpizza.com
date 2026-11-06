---
title: "cms root md file limit audit.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "cms root md file limit audit.story"
issues: []
discussions: []
name: cms-root-md-file-limit-audit
description: Enforce the module-root max-6-.md / zero-.txt hygiene rule on Modules/Cms
metadata:
  status: done
  created: 2026-09-07
  owner: Cms
  rule: bashscripts/ai/wiki/rules/module-theme-root-md-files-limit.md
---

# Cms root .md file limit audit

## Fase BMAD

Dev (esecuzione diretta di una regola di igiene gia' definita, nessuna nuova feature).

## Contesto

Regola canonica: `bashscripts/ai/wiki/rules/module-theme-root-md-files-limit.md` — root di
`laravel/Modules/<Nome>/` deve avere **0** `.txt` e **max 6** `.md`. Verificato con
`find laravel/Modules/Cms -maxdepth 1 -iname '*.md' | wc -l` = **16** file (soglia superata di 10),
`.txt` = 0 (gia' conforme).

I 16 file .md in root erano quasi tutti relitti di una precedente sincronizzazione automatica
(commit `a77095a7 cms: sync docs + fix after agent AI work`, 2026-09-06) che aveva importato file
di skeleton del package pubblico `laraxot/module_cms_fila5` (`.github/workflows`, `CHANGELOG.md`,
`license.md`, ecc.) insieme a report/appunti generati da agenti AI, senza poi ripulire la root.

**Scoperta chiave**: per 15 dei 16 file, esisteva gia' una copia byte-identica archiviata sotto
`docs/root-md-files/<stesso-nome>.md` (creata dalla stessa sincronizzazione), verificata con
`diff -q` prima di ogni rimozione. Un file (`.docs-directory-violation-reminder.md` e varianti)
conteneva addirittura contenuto di un progetto estraneo (`base_saluteora`), confermando la natura
di scarto della sincronizzazione. Il contenuto non e' quindi mai andato perso: era gia' duplicato
in `docs/root-md-files/` prima ancora di iniziare questo audit.

## Precedente di modulo (riferimento)

`Modules/Notify` e `Modules/Gdpr` (gia' standardizzati, vedi memoria
`project_module_doc_consolidation_audit.md`) mantengono in root esattamente:
`ARCHITECTURE.md`, `CHANGELOG.md`, `CONTRIBUTING.md`, `GETTING_STARTED.md`/`TESTING.md`,
`README.md` = 6 file. Cms non ha (ancora) `ARCHITECTURE.md`/`CONTRIBUTING.md`/`TESTING.md`
in root: non li ho inventati (fuori scope, nessun contenuto nuovo va creato in un task di
riorganizzazione). Ho mantenuto solo i due file realmente canonici e con contenuto sostanziale
gia' presenti.

## File rimasti in root (2, sotto la soglia di 6)

| File | Motivo |
|------|--------|
| `README.md` | Entry point del modulo, badge, indice docs — obbligatorio |
| `CHANGELOG.md` | Changelog reale con storia architetturale sostanziale (fix BaseModel 15/10/2025), coerente con il pattern degli altri moduli gia' puliti (Notify/Gdpr/User/Activity mantengono tutti un CHANGELOG.md in root) |

## File rimossi dalla root (14) — contenuto gia' preservato in `docs/root-md-files/`

Verifica `diff -q <root>/<file> docs/root-md-files/<file>` = identico per tutti, eseguita
subito prima della rimozione (nessuna perdita di contenuto: il file esisteva gia', committato,
sotto `docs/root-md-files/`).

| File rimosso da root | Gia' archiviato in |
|---|---|
| `business-logic-report.md` | `docs/root-md-files/business-logic-report.md` |
| `business_logic_report.md` | `docs/root-md-files/business_logic_report.md` |
| `changelog.md` (duplicato case di `CHANGELOG.md`, vietato dalla regola) | `docs/root-md-files/changelog.md` (+ `docs/_archive/root-md-files/CHANGELOG.md`) |
| `.docs-directory-violation-reminder.md` (contenuto estraneo, progetto `base_saluteora`) | `docs/root-md-files/.docs-directory-violation-reminder.md` |
| `.docs_directory_violation_reminder.md` | `docs/root-md-files/.docs_directory_violation_reminder.md` |
| `docs-directory-violation-reminder.md` | `docs/root-md-files/docs-directory-violation-reminder.md` |
| `license.md` (MIT boilerplate non configurato, placeholder `:vendor_name`) | `docs/root-md-files/license.md` |
| `license-renamed.md` (duplicato esatto di `license.md`) | `docs/root-md-files/license-renamed.md` |
| `modular-architecture-update-summary.md` | `docs/root-md-files/modular-architecture-update-summary.md` |
| `modular_architecture_update_summary.md` | `docs/root-md-files/modular_architecture_update_summary.md` |
| `modular-architecture-update-sumy.md` (refuso di battitura nel nome) | `docs/root-md-files/modular-architecture-update-sumy.md` |
| `phpstan-fixes-plan.md` (piano storico, 30 errori PHPStan gia' probabilmente risolti da campagne successive) | `docs/root-md-files/phpstan-fixes-plan.md` |
| `testing-business-behavior-update-summary.md` | `docs/root-md-files/testing-business-behavior-update-summary.md` |
| `testing_business_behavior_update_summary.md` | `docs/root-md-files/testing_business_behavior_update_summary.md` |

Nessuna fusione di contenuto necessaria: nessuno dei file rimossi duplicava (quasi-verbatim)
un documento gia' esistente altrove sotto `docs/` con contenuto diverso da preservare — erano
copie esatte di se stessi gia' archiviate.

## Verifica finale

```bash
find laravel/Modules/Cms -maxdepth 1 -iname '*.md' | wc -l   # 2 (era 16)
find laravel/Modules/Cms -maxdepth 1 -iname '*.txt' | wc -l  # 0 (invariato)
```

Root Cms ora: `CHANGELOG.md`, `README.md`.

## Note

- `laravel/phpstan.neon` non toccato.
- Nessun `@phpstan-ignore` introdotto.
- Nessun modulo/tema creato per la documentazione.
- Operazione eseguita con lock (`bashscripts/lock/{check,lock,unlock}.sh`) su ogni file
  rimosso, task id `cms-md-root-hygiene`.
- `docs/root-md-files/` e `docs/root-txt-files/` (contenenti fixture di test `test*.md/.txt`)
  non sono stati toccati: fuori scope per questo audit (riguardano l'archivio gia' esistente,
  non la root).
