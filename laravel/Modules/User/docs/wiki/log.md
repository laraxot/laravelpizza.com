---
title: "User Wiki Log"
type: log
module: User
tags: [user, wiki, log, phpstan, boundary]
created: 2026-04-15
updated: 2026-06-18
qmd: "user module wiki log phpstan no comment dependency"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/102"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./concepts/no-comment-module-dependency.md
  - ./rules/can-comment-retired-wrong-placement.md
---

- 2026-06-18: PHPStan User 14→0 — ripristinato `Tenant\Models\Traits\SushiToPhpArray` (dipendenza `SocialProvider`), rimosso `hasRoleTest()` morto in `HasRoles`, `HasPasswordExpiry` via `getAttribute`/`setAttribute`, fixture `PasswordValidationRules*` usa il trait reale.
- 2026-06-18: rimosso coupling residuo User -> Comment: `BaseUser` non usa piu' `HasCommentatorRelations`, `UserContract` non espone metodi Comment, trait disattivata eliminata. Verifica: `bashscripts/tools/check-user-no-comment-dependency.sh`, `pest Modules/User/tests/Unit/NoCommentModuleDependencyTest.php`, PHPStan User/Progressioni.
- 2026-06-10: notifications-folio-page + notifications-folio-route — `route('notifications')`, vietato `area-personale.notifiche`
## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

# User Wiki Log

## [2026-06-05] arch | profiles schema — owner Fixcity, non User
- migrazioni `create_profiles_table` User archiviate in `database/migrations/_bak/*.merged`
- concept aggiornato: `concepts/profile-migration-uuid-contract.md` punta a migrazione Fixcity
- riferimento: `docs/wiki/bmad/architecture-one-migration-per-model.md`

## [2026-06-04] bugfix | profiles.uuid su connection fixcity (sqlite locale)
- errore: `table profiles has no column named uuid` in `XotData::getProfileModelByUserId()` dopo login/registrazione
- causa: tabella `profiles` legacy su `fixcity_data.sqlite` senza colonna `uuid`, mentre `BaseProfile::booted()` la valorizza in insert
- ~~fix operativo con `--path`~~ **storico — vietato oggi**; canonico: `php artisan migrate` ([dati sacri](../../../../docs/wiki/rules/data-sacred-no-destructive-db.md))
- verifica: `getProfileModelByUserId()` crea profilo con `uuid`; schema sqlite include indice `profiles_uuid_index`
- riferimento: `concepts/profile-migration-uuid-contract.md`

## [2026-05-21] docs | inventario Markdown legacy redundancy/phpstan-duplicati

- Nuova pagina [`concepts/ridondanze-docs-legacy-cluster.md`](concepts/ridondanze-docs-legacy-cluster.md): elenco file `redundancy-fixes*.md`, cluster `phpstan-dry-kiss-improvements*`, typo `redundancyes.md`; link verso hub Xot [`ridondanze-cross-cutting-codebase`](../../../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md).

## [2026-05-06] phpstan | widget property types e schema normalization
- risolti errori PHPStan mirati su `PassportDashboard`, `EditUserWidget` e `RegistrationWidget`.
- regola documentata: proprieta' Livewire tipizzate, `class-string` validati prima dell'assegnazione, nessun default stringa vuota per `class-string`.
- evitato override locale di `$view` nei widget quando `XotBaseWidget::resolveView()` puo' calcolare la vista.
- nuova pagina troubleshooting: `troubleshooting/phpstan-widget-property-types-2026-05-06.md`.

## [2026-04-28] fix | spatie permission team model config missing su route admin
- errore runtime gestito: `Spatie\Permission\Exceptions\TeamModelNotConfigured` su `/admin`.
- root cause: `teams => true` senza `models.team` in `permission.php`.
- fix applicato in tutti i profili config (`config/permission.php` + varianti `config/*/permission.php`) con:
  `models.team => Modules\User\Models\Team::class`.
- verifica runtime eseguita con `php artisan tinker --execute="dump(config('permission.models.team'));"`.
- nuova pagina troubleshooting: `troubleshooting/spatie-permission-team-model-not-configured.md`.

## [2026-04-28] docs | hardening migrazioni MariaDB create/alter boundary
- aggiunta pagina `concepts/mariadb-create-table-after-rule.md`.
- formalizzata regola DRY+KISS: `after()` vietato in `tableCreate()`, ammesso solo in `tableUpdate()`.
- aggiunte sezioni operative: best practices, bad practices, false friends, checklist e link ufficiali verificati.
- aggiornato `index.md` con il nuovo concetto.
- ingest eseguito in QMD index `fixcity` (collection `wiki` aggiornata).

## [2026-04-28] bugfix | profiles create migration MariaDB `after()` syntax error
- errore osservato in migration `2026_04_28_120000_create_profiles_table`:
  SQL syntax error vicino a `after id` in `CREATE TABLE`.
- root cause: `->after('id')` usato nel blocco `tableCreate()` su colonna `uuid`.
- fix applicato: rimosso `after()` dal create; `after()` resta nel `tableUpdate()`
  idempotente (ALTER path).
- verifica:
  ~~`migrate ... --force`~~ — **vietato**; owner `profiles` ora Fixcity; usare `php artisan migrate` senza `--force` ([dati sacri](../../../../docs/wiki/rules/data-sacred-no-destructive-db.md))
  eseguito con esito `DONE`.
- docs aggiornati: `concepts/profile-migration-uuid-contract.md`.

## [2026-04-27] governance | policy matrix adoption from Xot
- allineata la documentazione User alla matrice cross-modulo (`policy-module-matrix`).
- esplicitata raccomandazione: moduli business non identity-first -> default `XotBasePolicy`.
- mantenuto `UserBasePolicy` per dominio identity/access.

## [2026-04-27] governance | policy inheritance boundary User vs Xot
- documentata la regola decisionale su quando usare `UserBasePolicy` e quando preferire `XotBasePolicy`.
- chiarito che `UserBasePolicy` e' specializzazione dominio identity, non base universale per tutti i moduli.
- nuova pagina: `concepts/policy-inheritance-boundary.md`.

## [2026-04-27] governance | remove invalid additive migration on profiles
- rimosso `database/migrations/2026_04_27_000000_add_credits_to_profiles_table.php`
  per violazione regola "1 modello = 1 migrazione owner".
- chiarito boundary: il contratto `profiles` e' owner Fixcity; User non deve patchare schema `profiles`.
- nuova pagina: `concepts/profiles-ownership-boundary-rule.md`.

## [2026-04-20] bugfix | socialite provider page property type compatibility
- risolto fatal php su `SocialiteProviderSettingsPage` per incompatibilita tipi proprieta con classi base Filament/Xot.
- fix applicati:
  - `$view` da static a non-static
  - `$navigationGroup` tipizzato come `\UnitEnum|string|null`
  - `$navigationIcon` tipizzato come `\BackedEnum|string|null`
- validazione: il comando `php artisan make:filament-user` non va piu in fatal, ora richiede solo input obbligatori.

## [2026-04-20] governance | no label no tooltip in filament
- corretto `SocialiteProviderSettingsPage`: rimossi tutti gli override `->label(...)` sui campi provider.
- corretto `SocialProviderResource`: sostituito `->label(...)` su placeholder con `->hiddenLabel()`.
- aggiunta regola persistente in `concepts/filament-langserviceprovider-governance.md`.

## [2026-04-20] i18n | login page strings moved to user module
- regola applicata: nessuna frase italiana hardcoded nel tema.
- spostate le frasi della pagina login in `User/lang/*/auth.php` sotto `login.page.*`.
- adottata struttura a 5 elementi (`label`, `tooltip`, `placeholder`, `helper_text`, `description`) per ogni nuova chiave.
- `Themes/Sixteen/resources/views/pages/auth/login.blade.php` ora usa solo chiavi `user::auth...`.

## [2026-04-20] socialite | env-first admin guidance
- confermata preferenza operativa: credenziali social in `.env`, non in colonne dedicate utenti.
- aggiornata `SocialProviderResource` con guida visibile in form (passi + comandi cache/config).
- resi non obbligatori in UI i campi `client_id` e `client_secret` per supportare flusso env-first.
- aggiornato tutorial `concepts/socialite-admin-tutorial.md` con `php artisan optimize:clear`.

## [2026-04-20] socialite | governance + setup
- Aggiunta pagina `concepts/socialite-provider-governance.md` con regola: no colonne `google_id/facebook_id` su `users`.
- Aggiunta pagina `concepts/socialite-backoffice-google-setup.md` con procedura backoffice Filament per Google OAuth.
- Collegati i nuovi contenuti all'indice wiki modulo User.

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-20] bugfix | profiles.uuid nella migrazione canonica unica
- errore osservato: `table profiles has no column named uuid` durante insert su `Profile`.
- causa: `BaseProfile::booted()` genera `uuid`, ma una installazione aveva schema `profiles` senza colonna corrispondente.
- fix applicato:
  - confermata una sola migrazione autorevole `create_profiles_table`
  - migrazione rinominata a `2026_04_20_173500_create_profiles_table.php` per riesecuzione idempotente
  - regola documentata in `concepts/profile-migration-uuid-contract.md`

## [2026-04-27] discussion | Policy Inheritance Boundary
- Created: concepts/policy-inheritance-boundary.md (decisione architetturale)
- Updated: index.md (aggiunto cross-reference)
- Decision: Mantenere separazione UserBasePolicy vs XotBasePolicy
- Rationale: Dependency isolation, contract clarity, module boundaries, testing flexibility
- Best practices documentate: type-hint UserContract, permission dot notation, test con permessi reali
- Enhancements proposti: canAny(), canAll(), scope(), after() hooks
- Commit: docs: document policy inheritance boundary decision

## 2026-06-10 — session learnings

- Notifiche: runtime User, schema Notify; `NotificationSchema::isReadable()` per guard FO
- Folio: `name('notifications')`; vietato `area-personale.notifiche`
- `user:super-admin`: `--email` + ask + fallback WSL (no Laravel Prompts)
- Profiles: owner Fixcity `2026_06_10_123000_create_profiles_table` — vedi profile-migration-uuid-contract

## 2026-06-10 — Folio owner pattern docs

- INDEX Folio FO con cross-link Cms
- Catena notifications: Notify schema → User page → Sixteen link
