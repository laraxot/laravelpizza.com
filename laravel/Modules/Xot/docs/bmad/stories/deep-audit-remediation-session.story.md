---
title: "Audit estremamente approfondito PTVX — remediation sessione"
type: story
status: in-progress
module: Xot
qmd: "deep audit PTVX remediation Progressioni Activity Folio layout PHPStan"
related:
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
  - ../../../../Progressioni/docs/bmad/progressioni-audit-improvement-plan.md
  - ./module-portfolio-topology-no-cms-in-ptvx.story.md
  - ./folio-owner-foliovolt-not-app-provider.story.md
---

# Audit estremamente approfondito PTVX — remediation

## Scope e metodo

Source-first su `laravel/Modules/*` + bootstrap + `public_html`, con religione
portfolio: **Cms assente in PTVX**; pattern imparati dai sibling FO.

## Finding chiusi in sessione

| Sev | Finding | Esito |
|-----|---------|-------|
| P0 | LogViewer download via Folio `/api/log-download` senza FolioVolt | **fix**: Action Filament + `DownloadLogFileAction` |
| P0 | Cms introdotto per errore | **fix**: rimosso; Pest assenza Cms |
| P0 | App Folio come surrogato | **fix**: non registrato; stub annotato; Pest |
| P0 | Activity `Folio::path` | **fix**: rimosso; Pest |
| P1 | Layout Filament Styles/Scripts | **ok** UI/User; notifications nudo User |
| P1 | Progressioni P0 A–E | **già chiusi** (policy, Compila, SQL bind, CedDiff, Ricalcola) |
| P2 | `whereRaw` concat in Scheda | **dead comment** — live bind in trait |

## Aperti (priorità)

1. ~~Dual model Scheda/Progressioni~~ — **ADR** [dual-model](../../../Progressioni/docs/bmad/dual-model-scheda-progressioni-decision.md): tenere entrambi; canon=`Scheda`; no merge
2. Inverse deps Ptv/Sigma → Progressioni — **parziale**: Ptv Scheda/`getClassName` + CriteriPrecedenzaService via config; residuo Factory/AssenzaPolicy + Sigma — [inverse-deps](../../../Progressioni/docs/bmad/inverse-deps-ptv-sigma-decision.md)
3. SoftDeletes Progressioni — **parziale**: claim massivo **smentito** (solo `coeff_progressione` ha `deleted_at` live); `Coeff` SoftDeletes; altri gated — [softdeletes](../../../Progressioni/docs/bmad/softdeletes-schema-first-decision.md)
4. Feature Pest gap Progressioni + DB testing
5. ~~PHPStan Media/UI~~ — **STALE** (Modules gate 0, 2026-11-24b)
6. ~~ZipSchedaBulkAction / ExportXls authorize~~ — **chiusi** (pdfZip + xlsExport deny-default)
7. ~~Cms residual Mailable + Zero Folio~~ — **chiusi 2026-11-24c** (import Cms off mail; LettIMail PdfData; Zero `[container0]` → `pages_cms_quarantine/`; UI helper no `use Cms`)



## Follow-up post-swarm (2026-11-16)

Da audit paralleli ([Progressioni residuali](4f800c8b-3a7e-49ca-a666-5538f2555410),
[security boundary](ad54c847-697d-4f17-9cb8-c73d0e5e5b08),
[PHPStan Media/UI](28830ff8-dfa4-41d8-9158-70509dbc6ef6)):

| Sev | Finding | Esito follow-up |
|-----|---------|-----------------|
| P0 | Media stream guest bypass | **fix** auth obbligatoria + ownership |
| P0 | `canAccessPanel('access')` open-door | **fix** no bypass; richiede ruoli / no deleted |
| P0 | Sigma `ImportJsonAction` SQL concat | **fix** prepared + colonne whitelist |
| P1 | ZipScheda senza authorize | **fix** `pdfZip` Gate + policy deny default |
| P1 | ExportXls senza authorize | **fix** `xlsExport` + Gate; ProgressioniPolicy deny-default |
| P0 | Ptv SendMailBulk su lista Schede (operator) | **fix** `schedaMassMail` |
| P0 | ExportPdf lista Schede | **fix** `graduatoriaPdf` + Gate |
| P1 | SchedaPolicy model obbligatorio su bulk | **fix** `?Scheda $model = null` + pdfZip/xlsExport |
| P1 | ProgressioniPolicy batch `return true` | **fix** deny-default; admin via before() |
| P1 | filtro `ha_diritto` `false==null` | **fix** `=== null` / `array_key_exists` |
| P1 | App FolioServiceProvider boot live | **fix** boot no-op |
| P1 | Cms phantom imports User FO pages | **aperto** |
| P1 | Pdnd SSL verify off / secrets | **aperto** |
| P1 | Sigma write-on-read accessors | **fix** getter sola lettura + PersistDerivedAttributeAction; twin ImportJsonRefactored eliminato |
| P1 | Giomo accessor fuori sede Attribute | **aperto** (gap materializzazione) |




## Wave P1 chiusa (post PHPStan 0)

| Sev | Finding | Esito |
|-----|---------|-------|
| P0 | PHPStan Media Stream / BaseUser / ImportJson / Zip | **fix** 0 errori |
| P1 | `.env.testing` tracked con secrets | **fix** untrack + `.env.testing.example` + gitignore |
| P1 | Cms phantom Folio User | **fix** pages rimosse + Pest NoCmsPhantom |
| P1 | Pdnd SSL hard-false in postApi | **fix** applySslOptions (verify default on) |
| P1 | Sigma write-on-read EnteMatr* | **fix** PersistDerivedAttributeAction; twin ImportJsonRefactored eliminato; Pest 24 |
| P1 | refreshed_at prima del job queue | **fix** timestamp in RefreshHaDirittoAction post-Check |
| P1 | Compila `canEdit` vs `compila` | **fix** solo `Gate::authorize('compila')` |
| P1 | Giomo Attribute accessor | **fix** getGgCatecoPosfunFuoriSedeAttribute |
| P2 | Dual Scheda/Progressioni + inverse deps | **ADR + fix parziale** (vedi aperti 1–3 aggiornati 2026-11-24) |


## Follow-up agent closure

- [User Cms phantom](0e9cf1b1-d911-48f2-8f10-3278c5a2a22d): pages Cms rimosse + Pest 3 passed
- [Progressioni P1](734b6574-a2e8-4133-b076-8cd95bfab0f1): Compila Gate-only + refreshed_at post-Check; Pest unit hang DB documentato
- [Pdnd TLS/secrets](2392acdb-5273-4e63-ac50-7de3dcc2b149): applySslOptions+PdndTls; secrets env; Pest TLS 5 passed; residuo rotazione credenziali già in git
- [Sigma write-on-read](d9033a6c-0c55-4899-b31c-63793008bf39): getter Ente* read-only; PersistDerivedAttributeAction; ImportJson twin eliminato; Pest 24 passed

## Gate

```bash
./vendor/bin/pest Modules/User/tests/Unit/NoCmsPhantomFolioImportsTest.php
# 2026-11-16: 3 passed (39 assertions)
php -d memory_limit=2G ./vendor/bin/phpstan analyse \
  Modules/Progressioni/app/Actions/RefreshByYearAction.php \
  Modules/Progressioni/app/Actions/RefreshHaDirittoAction.php \
  Modules/Ptv/app/Models/Traits/Mutators/SchedaMutator.php \
  Modules/Pdnd/app/Services/Client/PdndClient.php \
  Modules/User/app/Models/BaseUser.php
# 2026-11-16: OK 0 errors
# Progressioni Pest unit: hang bootstrap DB su questo host — skip documentato (non prod 10.100.200.15; Feature/DB unreachable)
```

## Pest gate

Unit policy aggiornato (deny-default). Esecuzione Pest su host con MySQL remoto
può hangare >45s senza output → **skip documentato**; gate statico = PHPStan 0
su Progressioni + ExportXlsAction.

### Wave P2 2026-11-24d

- PHPStan lane (Coeff + Ptv inverse-deps files): **0 errors**
- Pest `CoeffSoftDeletesTest`: **skip** — `TestDatabaseGuard` rifiuta
  `.env.testing` `DB_HOST=10.100.200.53` (non locale). Gate sostitutivo:
  `rg -n "use SoftDeletes" Modules/Progressioni/app/Models/Coeff.php` + ADR.
- ADR: dual-model / softdeletes-schema-first / inverse-deps in
  `Modules/Progressioni/docs/bmad/`.
