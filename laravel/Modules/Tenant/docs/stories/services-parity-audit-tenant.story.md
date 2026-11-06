---
title: "[STORY] Tenant: parita' di TenantService e Services/Config con le Action successore"
type: story
status: ready-for-dev
created: 2026-10-20
updated: 2026-10-20
module: Tenant
epic: ../../../../../bmad-output/epic-services-to-queueable-actions.md
tags: [services, queueable-action, parity, tenant, boot-path, config-resolver, no-services-rule, w2]
qmd: "tenant tenantservice services config resolver registry parita action successore boot path provider morph map database cartella app services"
related:
  - ./services-to-actions-tenant.story.md
  - ./tenant-services-to-actions.story.md
  - ../services-config-dead-code-retired.md
  - ../concepts/tenant-service-to-actions-migration.md
---

# [STORY] Tenant: parita' di TenantService e Services/Config con le Action successore

Fase BMAD: Dev, wave W0 (solo documentazione). Prepara la wave W2 del modulo Tenant. Nessun codice PHP e' stato toccato per scriverla.

## Richiesta

Ordine dell'utente (2026-10-20): "i services vanno tutti convertiti in spatie queable actions, capisci il perche' capisci il senso". Stato finale chiesto: la cartella `laravel/Modules/Tenant/app/Services/` non esiste. Epic: [epic-services-to-queueable-actions](../../../../../bmad-output/epic-services-to-queueable-actions.md).

## Stato misurato il 2026-10-20 alle 12:45 UTC (volatile)

- Dal disco: `Tenant/app/Services/` non esiste. `git -C Modules/Tenant ls-tree -r --name-only HEAD -- app/Services` e `laraxot/dev`: 0 file. Alle 10:00 `laraxot/dev` ne aveva 6: la pulizia e' arrivata con il commit `6ed6bfa` (2026-10-20 12:19 UTC), che ha tolto `TenantService.php` (386 righe) e i 5 file di `Services/Config/`.
- Nessun `MERGE_HEAD`, nessun file non risolto, `git status` pulito alle 12:34 e alle 12:48. Controprova: alle 12:34 Geo aveva `MERGE_HEAD` e 15 file non risolti (alle 12:48 non piu'), quindi il comando distingue.
- Storia di `TenantService.php`: cancellato l'8 ottobre (`ccbfc94`), riportato dal pull il 20 ottobre alle 09:07 (`40f7efe`), cancellato di nuovo alle 12:19 (`6ed6bfa`). Senza guardia il prossimo pull puo' riportarlo.

## Analisi dello scopo

`TenantService` (12 metodi `static`) era la facciata statica sulla configurazione del tenant: nome del tenant, percorso dei file, valore di config con override per tenant, lettura e salvataggio dei file di config, risoluzione del modello per nome, traduzione, elenco dei moduli. Era una copia 1:1 delle Action che oggi fanno il lavoro vero.

`Services/Config/` (5 file) era una catena di strategie: `ConfigResolverRegistry` sceglieva tra `StandardConfigResolver`, `DatabaseConfigResolver` e `MorphMapConfigResolver` in base alla chiave. Non e' mai stata collegata: il pickaxe `git log --all -S'ConfigResolverRegistry'` la trova solo in `Services/Config/`, nei docs e in due test dell'8 ottobre. Il contratto era incoerente: `ConfigResolverInterface::resolve($key, $default)`, ma `DatabaseConfigResolver::resolve($key, $extraConf)` legge il secondo argomento come array di config. Due resolver su tre chiamavano `TenantService::`; `MorphMapConfigResolver` chiamava `getModuleModels()`, funzione definita solo nel file `Xot/Helpers/Helper.php` non caricato (vedi story Xot).

## Tabella metodo del Service verso Action successore

Path verificati su disco il 2026-10-20. "Prod" = file di produzione che citano la classe in codice (esclusi la classe, test, docs, commenti); controprova dello script: `SafeStringCastAction` 164, `GetTenantNameAction` 5.

| Metodo `TenantService` | Successore | Prod |
|---|---|---|
| `getName` | `app/Actions/GetTenantNameAction.php` | 5 |
| `filePath` | `app/Actions/Config/GetTenantFilePathAction.php` | 10 |
| `config` | `app/Actions/Config/ResolveTenantConfigValueAction.php` | 9 |
| `getConfigPath` | `Xot/app/Actions/Config/GetTenantConfigPathAction.php` e `Tenant/app/Actions/Config/GetTenantConfigPathAction.php` (copie con parametro `$name` / `$key`) | 0 in codice di produzione |
| `getConfig` | `app/Actions/Config/GetTenantConfigArrayAction.php` (esiste anche in Xot) | 8 (Tenant), 0 (Xot) |
| `saveConfig` | `app/Actions/Config/SaveTenantConfigAction.php` | 7 |
| `getConfigNames` | `app/Actions/Config/GetTenantConfigNamesAction.php` | 2 |
| `modelClass` | `app/Actions/Models/ResolveTenantModelClassAction.php` | 1 |
| `model` | `app/Actions/Models/ResolveTenantModelInstanceAction.php` | 0 (4 test) |
| `localizedMarkdownPath` | `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php` | 0 (2 test) |
| `trans` | `app/Actions/Translations/TranslateTenantKeyAction.php` | 1 |
| `allModules` | `app/Actions/Modules/GetTenantModulesAction.php` | 1 |
| `Config\ConfigStringKeyFilter` (gia' rimosso l'8 ottobre) | `app/Actions/Config/FilterConfigStringKeysAction.php` | 4 |
| `Config\*Resolver` e `Registry` | nessun successore diretto: la logica `database` e `morph_map` e' nel `TenantServiceProvider` (`loadTenantDatabaseConfig`, `mergeModuleConnections`, `registerMorphMap`) | n.a. |

Consumatori vivi di `ResolveTenantConfigValueAction`: `TenantServiceProvider` (righe 53, 94, 119), `Notify/Providers/NotifyServiceProvider` (riga 34), `Cms/Providers/FolioVoltServiceProvider` (riga 74), `Cms` pagine `Appearance/Breadcrumb`, `Footer`, `Headernav`, `Geo/Adapters/HereClient`, `Geo/Actions/Here/GetHereRouteSummaryAction`, `Tenant/Actions/Models/ResolveTenantModelClassAction`.

## Difetti ereditati da verificare e correggere in W2

1. Le Action di config stanno sul boot path di tutta l'app: `ResolveTenantConfigValueAction` (config `morph_map`, `database`, `mail`, `middleware` e ogni nome restituito da `GetTenantConfigNamesAction`). Un difetto qui rompe ogni richiesta. Regola per W2: nessuna modifica senza test mirato e senza leggere prima i tre provider chiamanti.
2. `ResolveTenantConfigValueAction::execute` chiama `Config::set($group, $mergeConf)` a ogni invocazione (riga 39): muta la config globale a ogni lettura. Verificare se serve una memoizzazione e se la mutazione ripetuta e' idempotente.
3. `GetTenantConfigArrayAction` cattura ogni `Throwable` e ritorna `[]`: un file di config rotto e un file vuoto sono indistinguibili. Valutare log o eccezione tipizzata. Questo e' il comportamento del Service migrato, non una scelta recente.
4. Copie Tenant/Xot di `GetTenantConfigPathAction` e `GetTenantConfigArrayAction`: i consumatori di produzione usano quelle di Tenant (8 file per l'Array); le copie Xot hanno solo test (3 file). La copia Xot di `GetTenantConfigArrayAction` chiama la copia Xot di `GetTenantConfigPathAction`, non `GetTenantFilePathAction`. Decidere quale e' la sorgente e fare delegare o eliminare l'altra a riferimenti zero.
5. Logica di `DatabaseConfigResolver::addModuleConnections` (copia la connessione di default su ogni connessione-modulo) oggi vive in `TenantServiceProvider::mergeModuleConnections`. Confrontare le due versioni prima di dichiarare chiusa la parita': e' la parte dei resolver che avrebbe cambiato il comportamento se collegata.
6. `TenantServiceProvider::purgeConnectionWhenMigrating` legge `Request::input('act') === 'migrate'`: accoppiamento con il vecchio pannello `act=` di `ArtisanService` (vedi story Xot). Non e' un Service, ma e' un residuo dello stesso flusso.
7. `ResolveTenantModelInstanceAction` (0 consumatori, 4 test) e `GetLocalizedMarkdownPathAction` (0 consumatori, 2 test): successori senza consumatori. Non scrivere altro codice; la decisione "collegare o lasciare con nota" e' della wave W3.
8. Documenti che raccontano uno stato superato: `docs/services-config-dead-code-retired.md` parla di 4 file (`ConfigStringKeyFilter` e 3 resolver) archiviati il 2026-07-14 in `docs/archive/Services.old/`; quelli cancellati il 2026-10-20 sono altri 5 (`ConfigResolverRegistry`, `ConfigResolverInterface` e i 3 resolver). La story `services-to-actions-tenant.story.md` ha gia' una sezione "Riesuma 2026-10-20". Aggiornarli con una nota datata, senza riscrivere le righe altrui.

## Cosa non fare

- Nessuna Action nuova: ogni metodo di `TenantService` ha gia' il successore.
- Nessuna Action che incarta una relazione Eloquent.
- Non collegare `ConfigResolverRegistry` (e' codice cancellato e il suo cambio di comportamento e' provato nella story del 2026-10-08).
- Non toccare le Action di config, DB e morph map senza il test mirato del punto 1.
- Nessuna modifica a `phpstan.neon` (solo l'utente).
- Non toccare file in stato di merge (`DU`, `UD`, `UU`) finche' il merge non e' chiuso da chi lo ha avviato; prima di ogni file `rg -c '^(<<<<<<<|=======|>>>>>>>)' <file>`.
- Nessun `git add`, commit, checkout, reset, restore o stash dalle lane docs.

## Acceptance criteria

- [ ] Verificato il 2026-10-20 12:49 (da rimisurare prima della chiusura): la cartella `laravel/Modules/Tenant/app/Services/` non esiste (su disco e nell'indice del repo del modulo). Comando: `find laravel/Modules laravel/Themes laravel/app -type d -name Services -not -path '*/vendor/*'` (non stampa nessun `app/Services`; stampa ancora `Xot/tests/Unit/Services` e `Notify/tests/Unit/Services`, che non sono `app/Services`) e `git -C laravel/Modules/Tenant ls-files app/Services` vuoto. Ripetere dopo ogni pull.
- [ ] I file non-Service che la cartella conteneva sono stati eliminati dall'auto-sync (commit `6ed6bfa`, 12:19) senza rinomina: `Services/Config/*` (5 file: nessun successore diretto, la logica `database` e `morph_map` sta nel `TenantServiceProvider`) e `TenantService.php` (12 Action successore nella tabella). Confermare con `git -C laravel/Modules/Tenant show 6ed6bfa --stat` e registrare "eliminato, successore X".
- [ ] Vettori di rigenerazione (W4), solo da citare: `laravel/config/localhost/modules.php:136` (`'services' => [..., 'generate' => false]` alle 12:5x, modifica non committata) e `php artisan module:make-service` di nwidart, che crea `app/Services/<Nome>.php` senza guardare `generate`. Nessuna azione in questa story.
- [ ] Parita' registrata per ogni riga della tabella, con la lettura di `git -C Modules/Tenant show 6ed6bfa^:app/Services/TenantService.php` accanto alla Action.
- [ ] Decisione scritta sulle copie Tenant/Xot di `GetTenantConfigPathAction` e `GetTenantConfigArrayAction` (una sola sorgente).
- [ ] Confronto `mergeModuleConnections` contro `DatabaseConfigResolver::addModuleConnections` con esito scritto.
- [ ] `GetTenantConfigArrayAction` non ingoia piu' ogni `Throwable` in silenzio, oppure la story spiega perche' va bene.
- [ ] Nessun riferimento residuo: `rg -nP 'TenantService\b|Services\\Config' Modules Themes routes config tests -g '*.php' -g '!**/vendor/**'` restituisce solo commenti o docs storici motivati, con controprova su un simbolo ancora citato.
- [ ] Guardia contro la resurrezione: il ratchet `laravel/tests/Architecture/ModulesArchitectureTest.php` (test "has no Modules/*/app/Services directory", allowlist `archAllowedServicesDirs()`) copre la cartella e non va modificato ne' duplicato; la cancellazione in `laraxot/dev` per Tenant risulta avvenuta (`ls-tree` = 0 alle 12:48), da riverificare.
- [ ] PHPStan solo mirato sul perimetro toccato.

## Verifica

Da `laravel/`:

```bash
ls Modules/Tenant/app/Services 2>&1                                         # atteso: No such file or directory
git -C Modules/Tenant ls-tree -r --name-only laraxot/dev -- app/Services | wc -l   # atteso 0
git -C Modules/Tenant ls-tree -r --name-only 6ed6bfa^ -- app/Services | wc -l      # controprova: > 0 (6 il 2026-10-20)
rg -nP '\bTenantService\b|Services\\Config\\' Modules Themes routes config -g '*.php' -g '!**/vendor/**' -g '!**/tests/**'
find Modules Themes app -type d -name Services -not -path '*/vendor/*'      # atteso a fine epic: vuoto
find Modules Themes app -type d -name Actions -not -path '*/vendor/*' | wc -l   # controprova: > 0 (oggi 57)
```

## Non verificato

- Il comportamento a runtime del boot con un tenant reale (nessun test eseguito: sessione di sola documentazione).
- Se `Config::set` ripetuto abbia effetti osservabili.
- La parita' riga per riga tra `TenantService` e le Action oltre alla lettura dell'inventario.
- Gli eventuali chiamanti via stringa FQCN o config (il conteggio e' per nome di classe).