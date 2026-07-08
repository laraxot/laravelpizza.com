# Ponytail audit — refresh 2026-07-01

Audit repo-wide (modalità `/ponytail-audit`): solo over-engineering e complessità evitabile.

**Fuori scope:** correttezza, sicurezza, performance.

**Repo locale:** `provtv/base_ptv_fila5` (`git remote -v` → `origin git@github.com:provtv/base_ptv_fila5.git`)

**Documentazione correlata nel tree:**

- [ponytail-audit-plan.md](../ponytail-audit-plan.md)
- [ponytail-audit-report.md](../ponytail-audit-report.md)
- [ponytail-setup.md](../wiki/how-to/ponytail-setup.md)

---

## Scope e vincoli (non negoziabili)

| Voce | Decisione |
|------|-----------|
| Moduli **Pdnd**, **Incentivi** | Esclusi dall'audit operativo |
| `predis/predis` | **Mantenere** |
| `awobaz/compoships` | **Mantenere** — adozione da mappare, non rimozione |
| `.env` storici | **Mantenere** |
| `.gitignore` per modulo | **Mantenere** |

---

## Findings (ranked — taglio maggiore prima)

1. `yagni` Layer `app/Services/` legacy (~59 file, ~5.2k LOC) vs religione `QueueableAction`. Migrazione al tocco feature. `laravel/Modules/*/app/Services/`
2. `delete` Backup regole agente BMAD (~5.3k righe). Git history. `bashscripts/ai/AGENTS.bmad-generated.FULL.md.bak`
3. `shrink` Tre `Safe*CastAction` core (~915 LOC). Una action + discriminante. `laravel/Modules/Xot/app/Actions/Cast/`
4. `yagni` `CriteriPrecedenzaService` Ptv ≈ Progressioni (solo namespace). Un Action in Progressioni. `Ptv` + `Progressioni` Services
5. `yagni` `CriteriValutazioneService` Performance ≈ Progressioni. Stesso pattern. `Performance` + `Progressioni` Services
6. `shrink` `GetFactoryAction` (~191 LOC). `Model::factory()` / trait snello. `laravel/Modules/Xot/app/Actions/Factory/GetFactoryAction.php`
7. `delete` `GetAllModuleTranslationAction` — zero caller, clone di `GetAllTranslationAction`. `laravel/Modules/Lang/app/Actions/GetAllModuleTranslationAction.php`
8. `delete` `ProfileTest` stub (`echo 'ciao'`), zero caller. `laravel/Modules/Xot/app/Services/ProfileTest.php`
9. `delete` Gerarchia `Translators/*` — classi vuote, zero import. `laravel/Modules/Xot/app/Services/Translators/`
10. `delete` Test `CriteriEsclusioneService` — classe assente. Rimuovi test. `laravel/Modules/Performance/tests/`
11. `delete` `StabiDirigenteContract` in `Models/Contracts/` — mai importato. Canonico `Ptv\Contracts`. `laravel/Modules/Ptv/app/Models/Contracts/StabiDirigenteContract.php`
12. `delete` `composer.json` stack Assetic/Less/Twig orfano. `laravel/Modules/Xot/app/Services/composer.json`
13. `delete` Doppio `GetAllTranslationActionTest` (`tests/unit` = `tests/Unit`). `laravel/Modules/Lang/tests/`
14. `yagni` Due `UseCaseContract` User — zero implementazioni. `laravel/Modules/User/app/Application/UseCases/Owners/`
15. `yagni` Stack mappa UI: contratti + `NullMapService`/`NullGeocodingService` senza binding provider. `laravel/Modules/UI/app/Services/Map/`
16. `delete` `composer.json` tema sotto `User/resources/views/`. Path `Themes/One/`. `laravel/Modules/User/resources/views/composer.json`
17. `shrink` 16× `phpstan_constants.php`. Bootstrap centralizzato Xot. `laravel/Modules/*/phpstan_constants.php`
18. `native` `compoships` in deps, zero modelli PHP — **adozione** su multi-FK, non rimozione. `laravel/Modules/Xot/composer.json`
19. `yagni` `sentry/sentry-laravel` + `aws/aws-sdk-php` Notify — verificare uso CI/staging. `laravel/composer.json`, `Modules/Notify/composer.json`
20. `delete` `phpstan-modules-random.sh` deprecato (re-export gate). `bashscripts/tools/phpstan-modules-random.sh`

**net:** ~12.400 linee, ~0–2 dip possibili se tutto approvato · **Tier A (#7–13):** ~350 linee, 0 dep critiche

---

## Azione richiesta (maintainer)

Rispondere con approvazione punto per punto sul plan, es.:

- **OK 1.1–1.4** → PR minimale Tier A
- **solo 1.1** → solo `GetAllModuleTranslationAction`
- **skip N** → indica numeri da escludere

Nessun commit codice finché non allineiamo almeno **Punto 1** del plan.

---

— Auto (`composer-2.5-fast`)
