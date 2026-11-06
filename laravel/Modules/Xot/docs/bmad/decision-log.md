---
title: "Decision log: Xot"
type: decision-log
module: Xot
status: active
created: 2026-10-16
updated: 2026-10-27
tags: [bmad, decision-log, xot, no-services, boy-scout]
qmd: "decision log xot"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log: Xot

## 2026-10-27: `docs/archive/` vietata e ignorata in ogni modulo/tema

- **Decisione:** ogni `.gitignore` alla root di `laravel/Modules/<Modulo>` e
  `laravel/Themes/<Tema>` dichiara esplicitamente `docs/archive/`.
- **Perche':** la policy Second Brain vieta alberi archivio paralleli: creano una
  seconda tassonomia, duplicano la fonte di verita' e sottraggono documenti alla
  ricerca QMD/wiki. La storia rimane nella cronologia Git; conoscenza attiva in
  `docs/wiki/`, fonti grezze in `docs/raw/`, e l'archivio wiki canonico in
  `docs/wiki/_archive/`.
- **Ambito:** il pattern previene nuove aggiunte non tracciate e rende uniforme il
  confine dei repo annidati; non rimuove file gia' versionati o dal working tree.
- **Filament:** nessun impatto su Resource, Widget o pannelli; il blueprint resta
  owner del contratto Filament e rimanda qui per la sola governance documentale.
- **Canon:** [no-docs-archive](../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md),
  [memoria Second Brain](../../../../../bashscripts/ai/wiki/memories/no-docs-archive-folders.md),
  [blueprint Filament](./filament-blueprint.md).

## 2026-10-22: Deep audit Support (Bag + Infrastructure)

- **Decisione:** rinominare Blog `Theme*Support` → `Theme*Bag`; spostare `GeoDataValidationRules` in `Infrastructure\Validation`; docs canoniche AI/Media/Cms aggiornate; debito `ShieldUtilsAction` registrato.
- **Artefatto:** [support-deep-audit.md](./support-deep-audit.md).
- **Perche':** user «controlla meglio e piu' a fondo»: zero cartelle non basta se restano faux-Action e naming Support.

## 2026-10-22: Wave Support: zero `app/Support` + niente faux-Action

- **Decisione:** nessuna cartella `Support` sotto `Modules/*/app` o `Themes/*/app|src`. Use-case → QueueableAction; registry → `Adapters`; costanti URL/cache → `Infrastructure\Config`. Vietato Action con `execute()` vuoto.
- **Esempi wave:** Geo `Infrastructure\Config\{GeoApiEndpoints,GeoDataConfig}`; AI `Adapters\AiActionHandlerRegistry`; Blog Article* → Actions + `ArticlePresentationAdapter`; Media path/exporter → Actions; Fixcity seeders → `Demo/`.
- **Perche':** user: Support devono sparire / diventare Spatie Queueable Actions (con ruoli semantici, non fingere la coda).
- **Gate:** `NoServicesTest` (Support dir + namespace); process [no-app-support-queueable-actions](../../../../../docs/second-brain/process/no-app-support-queueable-actions.md).
- **Track:** BMAD + second brain + filament blueprint Services→Actions.

## 2026-10-20: Planning BMAD zero-folders Services (chiusura maintain)

- **Decisione:** wave Services→Actions = **done/maintain**; piano sticky in [planning-services-to-actions-zero-folders](./planning-services-to-actions-zero-folders.md). Nessuna conversione di massa: disco gia' a 0 dirs / 0 import prod / ~770 Actions / `NoServicesTest` PASS.
- **Perche':** user standing order: cartelle `app/Services` non devono esistere; use-case = Spatie QueueableAction; Filament solo Actions.
- **Track:** [brainstorming-services-to-actions-wave](./brainstorming-services-to-actions-wave.md), [services-to-actions-global-wave.story](../stories/services-to-actions-global-wave.story.md) status `done`.

## 2026-10-20: Cartella `app/Services` assente (ratchet)

- **Decisione:** `Modules/*/app/Services` resta **0** directory e **0** PHP; ogni use-case = Spatie QueueableAction.
- **Perche':** evitare contenitori senza confini e riesumazioni merge; Filament invoca solo Actions.
- **Artefatti:** [census](./services-to-queueable-actions-census.md), [brainstorming](./services-to-queueable-actions-brainstorming.md), [filament-blueprint](./services-to-queueable-actions-filament-blueprint.md), `NoServicesTest`.
- **Track:** bmad-method + second brain

## 2026-10-20: Gate PHPStan Modules zero; Filament blueprint SSoT UI admin

- **Decisione:** `analyse Modules` resta `[OK] No errors`; ogni tocco Resource/widget BO segue [filament-blueprint](./filament-blueprint.md) (XotBase, Lang, fix alla sorgente prima di zittire).
- **Track:** [phpstan-modules-zero-standing-order](../wiki/memories/phpstan-modules-zero-standing-order.md), [NeverExtendFilamentDirectlyTest.php](../../tests/Unit/Filament/NeverExtendFilamentDirectlyTest.php).

## 2026-10-20: Snapshot sera: zero Services confermato (census BMAD)

- **Misura:** `find Modules -type d -path '*/app/Services'` = **0**; `find Modules -path '*/app/Services/*.php'` = **0**; Actions ≈ **770**; campione moduli su `laraxot/dev` (Xot, Fixcity, Notify, User, Geo, Tenant) = **0** file in `app/Services/`.
- **Non-layer:** modelli Sixteen `MunicipalService` / `Service` = dominio; residuo Blade TwentyOne (`PredictService`, modulo assente) → props/orchestratore, non reintroduzione Services.
- **Track:** [services-to-queueable-actions-census](./services-to-queueable-actions-census.md) (addendum sera prevale), [services-to-queueable-actions-brainstorming](./services-to-queueable-actions-brainstorming.md).

## 2026-10-20: Boy scout post-zero: census `Modules/*/app/Services`

- **Audit:** `rg --files -g '*Service.php' Modules/*/app/Services` → **0 file**; nessuna directory `app/Services/` sotto `Modules/*/app` né `Themes/*/app|src`. Zero `use …\Services\…` in PHP di produzione (solo ratchet `NoServicesTest`).
- **Stato domini (campione):** Fixcity: ex `WorkflowService` / `NotificationService` / `TicketService` **assenti**; vivo = Actions (`TransitionTicketStatusAction`, notify Actions, CRUD ticket Actions). Seo: ex `MetatagService` **assente**; vivo = `MetatagFacadeAdapter` + `Get/Replace/MergeMetatagDataAction`. Geo: già chiuso in [Geo decision-log](../../../Geo/docs/bmad/decision-log.md).
- **Residuo merge:** `Modules/Seo/tests/Unit/Services/MetatagServiceExtendedTest.php.old` importava classe cancellata → **rimosso** (test orfano `.old`, non suite Pest).
- **Non fare ora:** migrazione massiva; eventuali riesumazioni da merge → delete-again + ratchet (vedi voce Services→Actions sotto).
- **Track:** [decisions/action-conversion.md](../decisions/action-conversion.md), [NoServicesTest.php](../../tests/Unit/Architecture/NoServicesTest.php).

## 2026-10-20: `graphify-out/` obbligatorio in ogni `.gitignore` modulo/tema

- **Decisione:** ogni `laravel/Modules/*` e `laravel/Themes/*` (oltre a root / aggregatori) dichiara `graphify-out/` nel `.gitignore`. Se la cartella esisteva in index → `git rm --cached -rf` (working tree ok). **Mai** Git LFS.
- **Perche:** artefatto generato (graphify AST/JSON), riscritto a ogni update; commit = churn e tentazione LFS vietata. Non e' superficie Filament ([filament-blueprint](./filament-blueprint.md)).
- **Track:** [graphify-out-gitignore.md](./graphify-out-gitignore.md) (anche da [index.md](./index.md)); regola [no-git-lfs](../../../../../bashscripts/ai/wiki/rules/no-git-lfs.md). Job/Lang: rimossi dall'indice path `docs/graphify/graphify-out/**` (story `*graphify-out*.story.md` restano tracciate).

## 2026-10-20: PHPStan `Modules` a zero senza conferma (ordine permanente)

- **Decisione:** ogni turn non banale con qualita' in scope esegue `cd laravel && ./vendor/bin/phpstan analyse Modules` verso zero **senza chiedere conferma**; fix alla sorgente (scopo → chiamanti → causa), poi catena swarm → BMAD → docs → prompt → boy scout.
- **Perche:** un solo misuratore (`laravel/phpstan.neon`, solo umano) vale per CI e swarm; fermarsi al primo "0" o chiedere "procedo?" lascia debito e falsifica lo stato tra sessioni parallele.
- **Track:** prompt [11-phpstan.md](../../../../../bashscripts/docs/prompts/11-phpstan.md), [00-start.md](../../../../../bashscripts/docs/prompts/00-start.md#ordine-permanente-dellutente); memoria [phpstan-modules-zero-standing-order](../wiki/memories/phpstan-modules-zero-standing-order.md); wave [phpstan-modules-zero-wave3](../stories/phpstan-modules-zero-wave3.story.md).

## 2026-10-20: Services → Queueable Actions (chiusura wave)

- **Decisione:** i `*Service` applicativi sotto `Modules/*/app` sono eliminati; la logica vive in Spatie QueueableAction (`execute()`). `ProfileTest.php` in Services e' **GONE**. `Translators/*` e `Trend/Adapters/*` sotto Services sono **zombie delete-again** (decisione DELETE di [xot-small](../stories/services-to-actions-xot-small.story.md) 2026-10-08): **mai relocate**; vivo = `Actions\Translation\*TranslateAction` + `BuildTrendCollectionAction`. Se un merge li riesuma → delete di nuovo.
- **Perche:** religione [no-services-rule](../../../../../bashscripts/ai/wiki/rules/no-services-rule.md): un use-case = una Action tipizzata/accodabile; i Service riesumati dal merge erano copie morte. Filament continua a chiamare solo Actions ([filament-blueprint](./filament-blueprint.md), [services-to-queueable-actions-filament-blueprint](./services-to-queueable-actions-filament-blueprint.md)).
- **Track:** story [services-to-actions-global-wave](../stories/services-to-actions-global-wave.story.md); boy scout [phpstan-modules-zero-wave3](../stories/phpstan-modules-zero-wave3.story.md); brainstorm [brainstorming-services-to-actions-wave](./brainstorming-services-to-actions-wave.md).
- **Prossimo:** ratchet anti-riesumazione; delete-again se Translators/Trend riappaiono.

## 2026-10-19: Il modello della migration sta nel nome file

- **Decisione:** su `*_create_{modello}_table.php` non si scrive `$model_class`.
  `XotBaseMigration::getModelClass()` prende il modello da `_create_` … `_table.php`
  e il modulo dal path (`Modules\{Modulo}\Models\{Modello}`).
- **Perche:** la riga esplicita duplica un contratto che il file ha gia'.
  `$model_class` resta solo quando il nome file non segue quel contratto.

## 2026-10-16: Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `bmad-method`
