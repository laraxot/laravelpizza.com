---
title: "Ponytail audit — report over-engineering (codebase)"
type: architecture
tags: [ponytail, audit, yagni, over-engineering, planning]
created: 2026-06-30
updated: 2026-07-01
qmd: "ponytail audit report over-engineering riduzione codice vincoli predis compoships"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/173"
discussions:
  - "https://github.com/provtv/base_ptv_fila5_mono/discussions/174"
related:
  - "./ponytail-audit-plan.md"
  - "./wiki/how-to/module-docs-audit.md"
  - "./wiki/sources/code-redundancy-audit.md"
---

# Ponytail audit — report

Audit repo-wide (modalità ponytail-audit): solo over-engineering e complessità evitabile. **Fuori scope:** correttezza, sicurezza, performance.

**Pianificazione discussione:** [ponytail-audit-plan.md](./ponytail-audit-plan.md)

## Scope e vincoli (decisioni maintainer)

| Voce | Decisione |
|------|-----------|
| Moduli **Pdnd**, **Incentivi** | Esclusi dall'audit operativo |
| `predis/predis` | **Mantenere** — Redis non funziona senza |
| `awobaz/compoships` | **Mantenere** — adozione da mappare sui modelli con chiavi composite |
| `.env` storici (`laravel/.env*`) | **Mantenere** — storico operativo, non bloat |
| `.gitignore` per modulo | **Mantenere** — ogni modulo è repo git separata |
| Post-edit su ogni `.php` | PHPStan L10, PHPMD (`./tools/phpmd.sh`), PHP Insights (`./tools/phpinsights.sh`), Pest se assente |
| Docs | Aggiornare `docs` modulo/tema + ingest QMD dopo ogni modifica documentale |

## Findings codice (refresh 2026-07-01 — ranked)

Validazione grep: voci Tier A ancora presenti; `.bak` monolith agent ridotto a `bashscripts/ai/AGENTS.bmad-generated.FULL.md.bak` (~5.3k righe); `Services/` = 59 file / ~5.2k LOC (esclusi Pdnd/Incentivi); `compoships` ancora zero uso PHP.

### Output ponytail (ranked, biggest first)

1. `yagni` Layer `app/Services/` legacy vs religione `QueueableAction`. Migrazione al tocco feature, non big-bang. [`laravel/Modules/*/app/Services/`]
2. `delete` Backup regole agente BMAD. Git history. [`bashscripts/ai/AGENTS.bmad-generated.FULL.md.bak`]
3. `shrink` Tre `Safe*CastAction` core (~915 LOC). Una action + discriminante sorgente. [`laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php` + Attribute + Object]
4. `yagni` `CriteriPrecedenzaService` Ptv ≈ Progressioni (solo namespace). Un Action in Progressioni (owner modello). [`Ptv` + `Progressioni` Services]
5. `yagni` `CriteriValutazioneService` Performance ≈ Progressioni. Stesso pattern. [`Performance` + `Progressioni` Services]
6. `shrink` `GetFactoryAction` (~191 LOC). `Model::factory()` via `HasFactory` / trait snello. [`laravel/Modules/Xot/app/Actions/Factory/GetFactoryAction.php`]
7. `delete` `GetAllModuleTranslationAction` — zero caller, clone di `GetAllTranslationAction`. Tenere `GetAllTranslationAction`. [`laravel/Modules/Lang/app/Actions/GetAllModuleTranslationAction.php`]
8. `delete` `ProfileTest` stub (`echo 'ciao'`), zero caller. Niente. [`laravel/Modules/Xot/app/Services/ProfileTest.php`]
9. `delete` Gerarchia `Translators/*` — classi vuote, zero import. API Lang quando serve. [`laravel/Modules/Xot/app/Services/Translators/`]
10. `delete` Test `CriteriEsclusioneService` — classe assente. Rimuovi test. [`laravel/Modules/Performance/tests/`]
11. `delete` `StabiDirigenteContract` in `Models/Contracts/` — mai importato; canonico `Ptv\Contracts`. [`laravel/Modules/Ptv/app/Models/Contracts/StabiDirigenteContract.php`]
12. `delete` `composer.json` stack Assetic/Less/Twig orfano. Niente. [`laravel/Modules/Xot/app/Services/composer.json`]
13. `delete` Doppio test Pest `GetAllTranslationActionTest` (path `tests/unit` vs `tests/Unit`). Un file. [`laravel/Modules/Lang/tests/`]
14. `yagni` `SaveOwnershipRelationUseCaseContract` + `GetAllOwnersRelationshipUseCaseContract` — zero impl. Action dirette o delete. [`laravel/Modules/User/app/Application/UseCases/Owners/`]
15. `yagni` Stack mappa UI: contratti + `NullMapService`/`NullGeocodingService` senza binding in provider. Registra null object o elimina stub. [`laravel/Modules/UI/app/Services/Map/`]
16. `delete` `composer.json` tema sotto `User/resources/views/`. Path `Themes/One/`. [`laravel/Modules/User/resources/views/composer.json`]
17. `shrink` 16× `phpstan_constants.php` per modulo. Un bootstrap Xot. [`laravel/Modules/*/phpstan_constants.php`]
18. `native` `awobaz/compoships` in deps, zero modelli — **adozione** su relazioni multi-FK (non rimuovere). Doc pilot Sigma/Ptv. [`laravel/Modules/Xot/composer.json`]
19. `yagni` `sentry/sentry-laravel` root + `aws/aws-sdk-php` Notify — verificare uso CI/staging prima di taglio. [`laravel/composer.json`, `Modules/Notify/composer.json`]
20. `delete` `phpstan-modules-random.sh` — wrapper deprecato verso gate. Solo aggiornare doc che lo citano. [`bashscripts/tools/phpstan-modules-random.sh`]

**net:** ~12.400 linee e ~0–2 dipendenze possibili se approvati tutti i tier; **fase 1 (Tier A #7–13):** ~350 linee, 0 dep critiche.

---

## Findings codice (sessione 2026-06-30 — tabella storica)

### Tier A — quick win, basso rischio

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `delete` | `GetAllModuleTranslationAction` duplicato byte-per-byte, zero caller | Tenere `GetAllTranslationAction` | `laravel/Modules/Lang/app/Actions/` |
| `delete` | `ProfileTest` stub in produzione (`echo 'ciao'`) | Niente | `laravel/Modules/Xot/app/Services/ProfileTest.php` |
| `delete` | Gerarchia `Translators/` vuota (Base + 5 sottoclassi) | Lang/API quando servono | `laravel/Modules/Xot/app/Services/Translators/` |
| `delete` | `composer.json` orfano stack Assetic/Less/Scss/Twig | Niente (non mergiato in root) | `laravel/Modules/Xot/app/Services/composer.json` |
| `delete` | `composer.json` tema One sotto `User/resources/views/` | Path canonico `Themes/One/` | `laravel/Modules/User/resources/views/composer.json` |
| `delete` | Test su `CriteriEsclusioneService` — classe assente | Rimuovi test o implementa servizio | `laravel/Modules/Performance/tests/` |
| `delete` | Regola Cursor duplicata `updateTimestamps` | Una sola `.mdc` | `.cursor/rules/migration-update*` |
| `yagni` | `UseCaseContract` senza implementazioni | Action dirette o rimuovi contratto | `laravel/Modules/User/app/Application/UseCases/Owners/` |
| `yagni` | Doppio `StabiDirigenteContract` | Un path canonico | `laravel/Modules/Ptv/app/Contracts/` vs `Models/Contracts/` |

### Tier B — duplicazione dominio (discutere prima)

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `yagni` | `CriteriPrecedenzaService` Ptv ↔ Progressioni (Ptv importa model Progressioni) | Un Action nel modulo owner | `Ptv` + `Progressioni` Services |
| `yagni` | `CriteriValutazioneService` Performance ↔ Progressioni | Stesso pattern del precedente | `Performance` + `Progressioni` |
| `shrink` | Tre `Safe*CastAction` quasi identiche (~915 LOC) | Una action + discriminante sorgente | `laravel/Modules/Xot/app/Actions/Cast/` |
| `shrink` | `GetFactoryAction` (~190 LOC) per `Model::factory()` | Convenzione Laravel + dump-autoload | `laravel/Modules/Xot/app/Actions/Factory/` |

### Tier C — strutturale / incrementale (non big-bang)

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `yagni` | Layer `Services/` legacy (~146 file, ~14k LOC) vs religione `QueueableAction` | Migrazione graduale al tocco feature | `laravel/Modules/*/app/Services/` |
| `delete` | Backup monolith regole agente (~126k righe `.bak`) | Git history | `laravel/*.embedded-rules.FULL.md.bak`, altri `.bak` |
| `native` | `NullMapService` / `NullGeocodingService` | Binding condizionale se Geo assente | `laravel/Modules/UI/app/Services/Map/` |

### Fuori scope (non proporre tagli)

- **Pdnd** — alberi modello ANPR per servizio (C003/C007/…)
- **Incentivi** — intero modulo
- **predis**, **compoships**, **.env** storici, **.gitignore** modulari — vedi tabella vincoli

## Findings infrastruttura (report precedente — da validare)

Punti del report storico ancora da discutere in [plan](./ponytail-audit-plan.md#punto-6-infrastruttura-e-tooling):

- PHPStan doc duplicati in `Modules/*/docs/phpstan*`
- `_ide_helper*.php` committati
- Config vuoti `laravel/config/*.php`
- Script bash duplicati in `bashscripts/`
- `php-cs-fixer*` vs `pint.json`
- `phpstan_constants.php` / `rector.php` / `grumphp.yml` replicati
- Dipendenze AWS/Sentry senza env (da verificare uso reale)
- `larastan`/`phpstan` in `require` vs `require-dev`

**Correzioni già applicate al report:** predis, compoships, `.env`, `.gitignore` moduli — non sono candidati eliminazione.

## Compoships — gap adozione (azione positiva)

`awobaz/compoships` è in `Modules/Xot/composer.json` ma **nessun model PHP usa ancora** `Compoships` / `HasCompositeKeys` (grep 2026-06-30).

Documentazione esistente: `laravel/Modules/Xot/docs/models.md`, `relationship.md`.

**Prossimo passo:** mappare relazioni multi-colonna (es. Sigma/Ptv/Performance) e proporre adozione — non rimozione dipendenza.

## Stima tagli (solo se approvati in planning)

| Tier | LOC indicative | Dipendenze |
|------|----------------|------------|
| A quick win | ~200–400 | ~0–1 (composer orfani) |
| B duplicazione | ~1.000–1.500 | 0 |
| C strutturale | ~14k+ (Services) + ~126k (.bak) | variabile |

**net realistico fase 1 (Tier A):** ~300 linee, 0 dep critiche.

---

*Audit one-shot — non applica modifiche. Esecuzione solo dopo OK in [plan](./ponytail-audit-plan.md).*
