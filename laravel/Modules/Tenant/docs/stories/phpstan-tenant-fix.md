---
title: "phpstan tenant fix"
type: note
tags: [documentation]
qmd: "phpstan tenant fix"
issues: []
discussions: []
id: phpstan-tenant-fix
slug: phpstan-tenant
scope: [module:Tenant, project:base_workorder_fila5]
status: Done
priority: High
created: 2026-09-06
updated: 2026-09-07
---

## Problema
PHPStan errors in Modules/Tenant

## Errori Stimati
~30 errori (stima iniziale; baseline coordinamento riportava 69, mai confermata da un run reale)

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Esito 2026-09-06 (sessione claude sonnet 5)

`./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules/Tenant
--no-progress` (rieseguito due volte, cache pulita) → **0 errori**, sia prima che dopo le
modifiche di questa sessione. La stima di 69 errori nel coordinamento
(`docs/chat/2026-09-06-sonnet5-pest-fixes-plus-unclaimed-modules-wave.md`) non era mai stata
verificata con un run reale su Tenant; la story precedente `tenant-mixed-type-reduction.story.md`
(2026-09-04) aveva gia' portato il modulo a 0 errori.

Nota: durante il primo tentativo di run, PHPStan ha fallito il bootstrap con un ParseError
("Unclosed '{' on line 215") durante la discovery dei pannelli Filament di AiAssistant: causa
piu' probabile: scrittura concorrente di un altro agente su un file autoloaded in quel momento
(torn read). `php -l` su tutti i file coinvolti non ha trovato errori di sintassi persistenti;
un secondo run e' bastato per completare senza errori. Segnalato per consapevolezza, nessuna
azione necessaria: sintomo tipico di sessioni multi-agente concorrenti su file condivisi.

Essendo gia' a 0 errori PHPStan, il lavoro di questa sessione si e' concentrato sulle regole
di progetto indipendenti dal conteggio errori (vedi anche
`bashscripts/ai/wiki/rules/no-services-rule.md`-adjacent: preferire UserContract/ProfileContract
via XotData invece del model concreto):

- 7 model (`Tenant`, `Domain`, `TenantDomain`, `TenantSubscription`, `DatabaseConfig`,
  `TestSushiModel`, `TenantSetting`) avevano `@property-read User|null $creator/$updater`
  stray nel docblock: nessuna relazione `creator()`/`updater()` e' mai definita in questi
  model (ne' via trait `Updater`, ne' a mano), quindi l'annotazione era morta/errata e in
  conflitto con la dichiarazione corretta gia' presente su `BaseModel`
  (`@property ProfileContract|null $creator/$updater`). Rimossa in tutti e 7 i file, con
  il relativo `use Modules\User\Models\User;` diventato non necessario.
- `Tenant::users(): HasMany` usava `User::class` concreto; allineato al pattern gia'
  presente in `Modules/User/app/Models/BaseTeam.php` (`XotData::make()->getUserClass()`,
  return type `HasMany<Model&UserContract, $this>`).
- `TenantSetting::$value` era documentato come `mixed`; la migration
  (`create_tenant_settings_table`) dichiara la colonna come `text()` senza cast: ristretto a
  `string|null`.
- Verificati (non modificati) i 4 usi nativi di `mixed` residui segnalati come follow-up in
  `tenant-mixed-type-reduction.story.md` (`SushiToCsv::resolveRowIdKey/csvValue`,
  `SushiToJson::intValue`, `ResolveTenantConfigValueAction::assertValidConfigValue`): tutti e
  quattro ricevono un valore da un'API framework che a sua volta dichiara `mixed` senza cast
  nativo (`Model::getKey()`, `Model::getAttribute()`, `config()`), e lo restringono subito con
  guardie a runtime (`is_int`/`is_string`/`Assert::scalar`/`is_numeric`). Restringere il
  parametro sarebbe stato un narrowing disonesto rispetto al contratto reale del chiamante -
  confermata la conclusione della story precedente, nessun cambio.

Verifica: PHPStan 0/0, PHPMD (`./tools/phpmd.sh Modules/Tenant/app text phpmd.xml`) nessuna
violazione nei file toccati (uniche 4 violazioni pre-esistenti, non toccate, in
`Providers/{RouteServiceProvider,TenantServiceProvider}.php`, naming `module_dir`/`module_ns`
ereditato dal template XotBase). Pest: vedi `coverage.md`.

## Esito 2026-09-07 (sessione claude sonnet 5: campagna "PHPStan zero", riverifica)

Il modulo era tornato a **3 errori reali** (non regressione di questa sessione: un altro
agente aveva un WIP non committato: coerente col fix repo-wide gia' chiuso in
`Modules/Xot/docs/stories/18.19.xotbaseresource-final-getformschema-table-illegal-override-repo-wide-fix.story.md` -
che rimuoveva l'override inline morto `DomainResource::getFormSchema()` e convertiva
`DomainForm::getFormSchema()`/`DomainInfolist::getInfolistSchema()` da `static` a metodo di
istanza, coerente col parent astratto, ma senza aggiornare i 3 chiamanti nei test che li
invocavano ancora staticamente: errore PHPStan `method.staticCall`).

**Causa radice**: `XotBaseResourceForm::getFormSchema()` / `XotBaseResourceInfolist::getInfolistSchema()`
sono `abstract public function` (istanza, mai `static`); chiamarli con `Class::metodo()` e'
un `Error` PHP 8 **fatale a runtime**, non solo un problema di tipizzazione: verificato
isolando i 2 file di test con `git stash` mirato e ri-eseguendo le sole righe incriminate.

**Fix**: nei 3 call-site nei test, sostituita la chiamata statica con la risoluzione
dall'IoC container (`app(DomainForm::class)->getFormSchema()`,
`app(DomainInfolist::class)->getInfolistSchema()`), stesso pattern gia' documentato in
`bashscripts/ai/wiki/memories/geo-addressform-schema-reuse-static-call-bug.md`. Riscritto
anche il test che verificava lo schema sulla `DomainResource` (bridge morto, ritorna sempre
`[]`) per verificarlo invece su `DomainForm`, dove lo schema vive realmente. Rimossi gli
import diventati orfani (`RichEditor`/`TextInput` su `DomainResource.php`, `DomainResource`
su `TenantStatementCoverageTest.php`).

File toccati: `tests/Unit/TenantCoverageBoostTest.php`, `tests/Unit/TenantStatementCoverageTest.php`,
piu' cleanup import su `app/Filament/Resources/DomainResource.php` (il resto delle modifiche
su `DomainResource.php`/`DomainForm.php`/`DomainInfolist.php` era gia' WIP di un altro agente,
non toccato nel merito).

Verifica completa: PHPStan 3→0 errori (cache pulita), PHPMD invariato (stesse 4 violazioni
pre-esistenti), PHPInsights bloccato da `ComposerNotFound` (bug tooling noto, non imputabile),
Pest 120 passed/21 failed/32 skipped (i 21 failed sono pre-esistenti, verificato che nessuno
riferisce i file toccati). Dettaglio completo in `../coverage.md`.
