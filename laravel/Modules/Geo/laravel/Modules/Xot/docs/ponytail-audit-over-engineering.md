# Ponytail audit — Xot (over-engineering)

**Ultimo run:** 2026-07-01  

## Remediation run #4 (2026-07-01 — swarm parallelo)

| # | Azione | Stato |
|---|--------|-------|
| X1 | `ArtisanService` stack + `app/Services/Artisan/` | ✅ già assenti (run precedenti) |
| X2 | `RouteDynService` | ✅ già assente |
| X3 | `Actions/Array/*` duplicato | ✅ rimosso; `ArrayToRawJsAction` → `Actions/Arr/` |
| X12 | `ModelWith*Contract` (zero `implements`) | ✅ rimossi 4 contratti |
| X13 | `GetViewByClassAction` root duplicato | ✅ rimosso; SSoT `Actions/View/` |
| X20 | API morta in `helpers/Helper.php` | ✅ shrink ~200 righe (hex2rgba, getModelByName, profile, …) |
| — | PHPStan `Modules` | da verificare post-run |

## Remediation run #3 (swarm 2026-07-01)

| # | Azione | Stato |
|---|--------|-------|
| X1 | `ArtisanService` stack | ✅ già assente |
| X2 | `RouteDynService` | ✅ già assente |
| X3 | `Actions/Array/` → consolidato in `Actions/Arr/` | ✅ |
| X10 | 4 contratti `ModelWith*Contract` orfani | ✅ rimossi |
| X13 | `GetViewByClassAction` root duplicato | ✅ rimosso |
| — | `Helpers/Helper.php` duplicato (uppercase) | ✅ rimosso; canonico `helpers/Helper.php` |
| — | `TypedHasRecursiveRelationships` trait morto | ✅ rimosso |
| — | PHPStan Modules | ✅ 0 errori |
**Modulo:** cuore Laraxot.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Vincoli — non toccare in audit «DTO/yagni»

| Artefatto | Motivo |
|-----------|--------|
| `MetatagData` | Config runtime SEO/brand, Wireable — non DTO passivo |
| `XotData` | Facade tenant/tema/moduli — non DTO passivo |
| `spatie/laravel-permission` | RBAC team-based voluto (`composer.json`) |
| `helpers/Helper.php` (minuscolo) | Path autoload `files` canonico |

**Nota `.bak`:** cartelle `Datas.bak`, `Filament.bak`, `Helpers.bak`, `Services.bak`, `View.bak` **non sono più su disco** (archivio già bonificato).

## Findings ranked

| # | Tag | Cosa | Sostituzione | Path | Righe ~ |
|---|-----|------|--------------|------|---------|
| X1 | `delete` | Stack `ArtisanService` + 9 handler (prod usa `ExecuteArtisanCommandAction`) | `Artisan::call()` / action esistente | `app/Services/ArtisanService.php`, `app/Services/Artisan/` | ✅ rimosso |
| X2 | `delete` | `RouteDynService` (zero caller fuori definizione) | Route Laravel/Folio | `app/Services/RouteDynService.php` | ✅ rimosso |
| X3 | `delete` | Duplicato `Actions/Array/*` (prod usa `Actions/Arr/*`) | Solo `Actions/Arr/` | `app/Actions/Array/` | ✅ rimosso |
| X4 | `delete` | Doppio `XotBaseManageRelatedRecords` (zero `extends`) | Una base in `XotBaseResource/Pages/` | `app/Filament/Resources/Pages/`, `XotBaseResource/Pages/` | ~311 |
| X5 | `shrink` | API morta in `MetatagData` (`getIcons`, `getOpenGraph`, … — 0 caller) | Esporre solo metodi usati dai blade | `app/Datas/MetatagData.php` | ~120 |
| X6 | `shrink` | Thin-wrapper tema in `MetatagData` → `XotData` | `XotData::make()` nei template | `app/Datas/MetatagData.php` L637+ | ~25 |
| X7 | `delete` | `ContextCompressor`, translator stub, trend adapter locale | `Str::limit` / niente | `app/Services/ContextCompressor.php`, `Translators/`, `Trend/` | ~350 |
| X8 | `delete` | Mirror `app/Routes/` (vivo: `routes/`) | Solo `routes/` | `app/Routes/` | ~40 |
| X9 | `delete` | `Http/Livewire/XotBaseComponent` (zero extends) | Filament/Volt | `app/Http/Livewire/XotBaseComponent.php` | ~61 |
| X10 | `delete` | Contratti mai implementati (subset) | Trait su modello base | `app/Contracts/` (subset) | ~207 |
| X11 | `yagni` | `GetFactoryAction` (~191 righe, adozione cross-modulo) | `Model::factory()` graduale | `app/Actions/Factory/GetFactoryAction.php` | ~191 |
| X19 | `delete` | `app/Services/composer.json` legacy (assetic, lessphp, …, 0 ref) | deps nel composer modulo | `app/Services/composer.json` | ~32 |
| X20 | `stdlib` | API morta in `helpers/Helper.php` | `Str::` / caller diretti | `helpers/Helper.php` | ✅ parziale run #4 |
| X12 | `yagni` | Marker `ModelWith*Contract` (zero `implements`) | PHPStan generics / trait | `app/Contracts/ModelWith*.php` | ✅ rimossi |
| X13 | `delete` | `GetViewByClassAction` root (duplicato View/) | `Actions/View/GetViewByClassAction` | `app/Actions/GetViewByClassAction.php` | ✅ rimosso |
| X14 | `delete` | `ProfileTest`, `XotService`, `TestWidget` | `XotData` / niente | `app/Services/ProfileTest.php`, … | ~78 |

## Wave 5 applicata (2026-07-01)

| Finding | Stato |
|---------|-------|
| X1 Artisan stack | ✅ `.bak` + test archiviato |
| X2 RouteDynService | ✅ `.bak` |
| X7 ContextCompressor, ArrayService, UrlService | ✅ `.bak` |
| X14 ProfileTest, ThemeService | ✅ `.bak` |
| Filament ColumnBuilder/FilterBuilder | ✅ `.bak` |
| Duplicato `Helpers/Helper.php` (maiuscolo) | ✅ `.bak`; canonico `helpers/Helper.php` |
| Script | `bashscripts/tools/ponytail-wave5-archive.sh` |

| X15 | `native` | `symfony/dom-crawler` (0 use in `app/`) | `DOMDocument` se serve | `composer.json` | -1 dep |
| X16 | `shrink` | `XotData::save()` stub `dddx('wip')` | Rimuovere o persistenza reale | `app/Datas/XotData.php` | ~4 |
| X17 | `shrink` | `helpers/Helper.php` monolite (~581 righe) | Split graduale / Actions | `helpers/Helper.php` | fase 2 |
| X18 | `yagni` | Doppio `MetatagData` Xot vs Seo | Un tipo canonico o facade | `Modules/Seo/app/Data/MetatagData.php` | discussione |

**net:** ~-2.800 righe, -1 dep possibile (`symfony/dom-crawler`).

## Collegamenti

- [wiki/reference/xotdata-metatagdata-not-simple-dto.md](./wiki/reference/xotdata-metatagdata-not-simple-dto.md)
- [critical-no-services-rule.md](./critical-no-services-rule.md)
