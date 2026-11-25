---
id: Tenant/module-bmad-audit-20260928
title: "Tenant — baseline BMAD e analisi completa"
status: ready-for-dev
module: Tenant
epic: module-governance
priority: P1
created: 2026-09-28
references:
  - ../architecture/module-boundary.md
  - ../brainstorming/module-opportunities.md
  - ../epics/module-roadmap.md
qmd: "bmad audit 20260928 story tenant baseline"
---
# Story — Tenant: baseline BMAD

Come manutentore del modulo Tenant, voglio una baseline BMAD verificabile, così da poter pianificare lavoro senza confondere ipotesi, WIP e comportamento osservato.

## Acceptance criteria

- [ ] Confermare API pubblica e confini con riferimenti a codice reale.
- [ ] Inventariare i flussi critici e collegarli a test Pest.
- [ ] Misurare PHPStan/Pest nel contesto stabile del modulo.
- [ ] Registrare dipendenze, rischi e decisioni nel modulo.
- [ ] Aggiornare lo stato reale in `docs/sprint-status.yaml`.

## Task

- [ ] Revisione architettura.
- [ ] Brainstorming con stakeholder.
- [ ] Decomposizione epic in story più piccole.
- [ ] Quality gate e second-brain write-back.

## Audit 2026-11-16

Audit statico completo del modulo Tenant (codice reale in `app/`, `database/`, `lang/`, `tests/`, `routes/`). PHPStan level max: **0 errori**.

### Conteggi

- Modelli Eloquent reali: ~8 (`Tenant`, `Domain`, `TenantDomain`, `TenantSetting`, `TenantSubscription`, `DatabaseConfig` + `BaseModel*`); `app/Models` contiene 19 file PHP inclusi `Contracts/`, `Policies/`, `Traits/`.
- Actions: 19 file in `app/Actions`.
- Filament: 9 file (1 Resource `DomainResource` + Pages/Schemas/Tables, `Dashboard`, `SettingPage`).
- Migrazioni: 3. Routes: `api.php`, `web.php`.
- Test: 65 file, ~254 test Pest (`test(`/`it(`); 1 TestCase PHPUnit di supporto.
- Lang: `it` 7 file, `en` 3 file.
- `docs/bmad/`: 73 file.

### Findings

1. **[Docs] Nome file con data**: questa story è `module-bmad-baseline-audit.story.md` — viola la regola "nessuna data/timestamp nel nome .md". Raccomandata rinomina in `module-bmad-audit.story.md` (verificare riferimenti incrociati prima).
2. **[Docs] Indice duplicato**: `docs/bmad/00-INDEX.md` e `docs/bmad/00-index.md` sono byte-identici (4974 byte). Su filesystem case-sensitive sono due file distinti → rischio divergenza. Consolidare in uno solo.
3. **[Code] Model di test in produzione**: `app/Models/TestSushiModel.php` è referenziato solo da test e fixture (`tests/Fixtures/`). Candidato a spostamento in `tests/` o marcatura esplicita.
4. **[Quality] `mixed` diffuso**: 22 file in `app/` contengono `mixed`; 3 `@phpstan-ignore trait.unused` sui trait `SushiToCsv`/`SushiToPhpArray` (ignore accettabili ma da rivalutare).
5. **[i18n] Copertura EN parziale**: 3 file lang `en` vs 7 `it`; verificare chiavi mancanti per `domain*` e `admin_panel_provider`.
6. **[Filament] Compliance OK**: nessun `->label()`, `->placeholder()`, `->helperText()` hardcoded; 8 classi estendono base Xot; nessun `Filament\Forms\Form` legacy; nessun merge marker `<<<<<<<` nel modulo.

### Rischi

- Basso: modulo piccolo e pulito; rischio principale è la frammentazione docs (73 file bmad, nomi non sempre kebab-case, es. `arr-first-vs-collect-first-ision.md`).

### Next steps (priorizzati)

1. Rinominare la story in `module-bmad-audit.story.md` e consolidare `00-INDEX.md`/`00-index.md`.
2. Spostare `TestSushiModel` fuori da `app/Models` o documentarne lo scope.
3. Allineare lang `en` a `it` (almeno file `domain*`, `admin_panel_provider`).
4. Ridurre i `mixed` nelle Actions più calde (export Sushi/CSV).


