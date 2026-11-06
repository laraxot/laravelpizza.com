---
title: "Docs Tenant: studio del codice e correzione degli ingressi (DOC-010, DOC-002)"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Tenant
tags: [docs, tenant, config, sushi, stale, docs-organizer, bmad]
qmd: "tenant docs studio 2026-10-14 GetTenantNameAction host invertito config directory SaveTenantConfigAction sushi json TenantService inesistente"
related:
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ./services-to-actions-tenant.story.md
---

# Docs Tenant: studio del codice e correzione degli ingressi

## Richiesta
Fase BMAD documentazione/qualita' (DOC-010 + DOC-002): capire come funziona davvero la multi-tenancy, correggere `README.md`, `00-INDEX.md`, `index.md` con fatti verificati, marcare come stale i docs falsi, annotare i link rotti.

## Analisi
Il "tenant" non e' una riga di database: e' una cartella `laravel/config/<host invertito>/`.
- `Actions\GetTenantNameAction` prende `SERVER_NAME` (o l'host di `APP_URL` se vuoto o `127.0.0.1`), toglie `www.`, slugga le parti e le inverte; se `config/<parti>` esiste e' il tenant, altrimenti riprova senza la parte piu' a sinistra (oltre 2 parti), poi `APP_URL`, poi `localhost`. Prova: `php artisan tenant:test` stampa `tenant name :local/fixcity`.
- `ResolveTenantConfigValueAction` fonde `config/<gruppo>.php` con `config/<tenant>/<gruppo>.php`; `TenantServiceProvider::boot()` la applica a ogni file `.php` del tenant, registra morph map e connessioni database (la connessione `tenant` esiste a runtime). `SaveTenantConfigAction` e' l'unico punto di scrittura. `GetTenantFilePathAction` rifiuta percorsi assoluti, `..` e byte nulli.
- I trait `SushiToJson`, `SushiToJsons`, `SushiToPhpArray`, `SushiToCsv` leggono righe da `config/<tenant>/database/content/<tabella>/`: e' il meccanismo con cui il Cms serve le pagine (99 JSON in `config/local/fixcity/database/content/pages/`).
- Tenant esistenti: `local/fixcity`, `eu/fixcity`, `net/futurely`, `localhost`. `com/geekpiu`, citato dall'indice, non esiste.
- Non implementati (grep): `BelongsToTenant`, global scope, `TenantService`, `TenantSwitcher`, `SetTenant`, impersonation, rotte. `BaseTenant`, `HasTenants` e il pivot `tenant_user` stanno in `Modules/User`. `Tenant::users()` e' una `hasMany`.
- Importano `Modules\Tenant`: Cms 16 file, Xot 6, User 4, Geo 3, Notify/Gdpr/Fixcity/Blog 1 ciascuno.

## Modifiche
- `README.md`: sezioni "Scopo" e "Politica" riscritte; aggiunti quick start (provato), cosa non c'e', chi lo usa, Filament e dati, test. `status` da `core-multi-tenancy` a `active`, licenza da `Proprietary` a `MIT` (come `composer.json`).
- `00-INDEX.md`: quick start, albero config, concetti (scoping non implementato), mappa delle directory (canoniche, evidence, legacy), 2 link morti annotati, `status: active`.
- `index.md`: link a Xot ripuntato a `../../Xot/docs/00-INDEX.md` (esiste); 2 link a `contributing.md` annotati.
- `docs-organizer.py stale --fix` su 6 pagine wiki (Architecture, TenantIdentification, ConfigurationDistribution e le copie in minuscolo): citano `TenantService`, sottodomini, cache Redis e `config('app.tenant_default')` che non esistono.

## Verifica
- `php artisan tenant:test` e tinker: `config_path(GetTenantNameAction)` stampa `/mnt/nas07/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity`.
- Pest `Modules/Tenant/tests/Unit/Actions` con `pest-scratch-db.sh` (`APP_CONFIG_CACHE=/nonexistent/config.php`, `DB_DATABASE_LIMESURVEY=`): 27 passati, 5 falliti, tutti `RuntimeException: Unexpected mockery expectation type` (`expectMockery`), gia' documentato nella story 2026-10-08.
- Link (eventi `unresolved` con `--busy-minutes 0`, solo i 10 file toccati): prima 5, dopo 4, tutti annotati (senza annotazione: 0). Intero modulo: 748 prima, 747 dopo. Con la metrica di `audit` (link rotti nei soli file indice) il brief indicava 95, ora 94.
- Frontmatter in dry-run: restano 181 eventi (182 prima; soprattutto `status` mancante) e 1 blocco spurio manuale in `architecture.md` riga 345, non toccati.

## Decisioni
- Nessun file spostato o cancellato; nessuna modifica al codice. Le pagine wiki false sono marcate `stale`, non riscritte.

## Aperto
- 182 file senza `status` e `architecture.md` con blocco spurio.
- `Models\Tenant` e `Domain` coesistono con il vero meccanismo a cartelle: decidere se le tabelle `tenant_settings`, `tenant_subscriptions`, `database_configs` (`tenant_id` stringa senza chiave esterna) siano ancora usate.
- 161 file del modulo con link irrisolti (`duplicate-methods-analysis.md` da solo ne ha 201).
