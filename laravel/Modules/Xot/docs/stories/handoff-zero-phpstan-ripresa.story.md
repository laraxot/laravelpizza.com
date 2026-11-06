---
title: Dossier di ripresa, verso zero PHPStan e sidebar admin
status: in-progress
module: none (coordinamento trasversale, nessun modulo owner)
created: 2026-10-21
---

# Dossier di ripresa, verso zero PHPStan e sidebar admin

## Stato alla chiusura

- Baseline PHPStan completa (`Modules`, cache isolata con `TMPDIR`): 1 segnalazione, in `User`
  (`UserMassSeeder::getConsoleCommand()`, `return.unusedType`). Il numero cambia: altre sessioni
  modificano gli stessi file. Rilanciare prima di credere a qualsiasi conteggio.
- Sidebar admin: causa trovata e corretta nella vista locale (`resources/views/vendor/filament-panels/livewire/sidebar.blade.php`,
  non tracciata da git). Riproduzione: con `filament:sidebar:collapsed_groups="null"` 4 errori JS, con `"[]"` 0.
  Verifica finale nel browser NON completata: il server locale era lento (load 38-50).

## Aperto, in ordine di priorita'

1. **Verifica sidebar nel browser.** Login con l'account indicato, poi controllo colonna moduli e errori JS.
   Script pronto: `/tmp/claude-1000/admincheck/verify.mjs` (Playwright, Chromium gia' installato).
   La password NON va salvata in file: passarla come variabile d'ambiente `ADMIN_PASSWORD`.
2. **`UserMassSeeder::getConsoleCommand(): ?Command`.** PHPStan propone di togliere il `?`, ma
   Laravel dichiara `Seeder::$command` come `Command|null` e i chiamanti usano gia' `?->`. Il `null`
   e' reale (seeder eseguito senza console). Non rimuovere il `?`: trovare la causa dell'inferenza.
3. **`Progressioni`, `stipendioTabellare`.** Decisione aperta nella storia
   `Modules/Ptv/docs/stories/stipendio-tabellare-relation-decision.story.md`. Proposta: la base risolve la
   classe via config registrata dal provider Progressioni, come `performanceIndividuale`.
4. **Sigma `Asz00f::scopeOfYear`.** L'override rimosso cambia il filtro per anno delle assenze in
   `Progressioni/Assenza::asz00fs()`. Nessun test lo copre: scrivere prima un test che fissi il filtro.
5. **Pest bloccato.** `Modules/Xot/tests/Support/TestDatabaseGuard.php` rifiuta le connessioni non `_test`.
   Le connessioni vengono dal profilo Tenant (`config/localhost/database.php`). Serve un profilo di test
   dove ogni connessione e' SQLite o `*_test`. Non abbassare il guard.
6. **Credenziali in `Modules/Pdnd/app/Filament/Clusters/Test/Pages/GuzzleProxyPage.php`** (password proxy e
   JWT in chiaro). Da ruotare e spostare in env: decide chi gestisce le credenziali.
7. **`laravel/package-lock.json` modificato** (allineato a `vite ^6.4.3`, da 271+/131-). Non committato:
   rivedere con `git diff`. Lo script `esbuild` postinstall non e' approvato.
8. **Log: `Expected an integer. Got: string` su `userId`** nel middleware notifiche Filament. Non indagato.
9. **Nomi `.md` con date:** 197 file nei moduli violano la convenzione. Serve un controllo automatico e una
   migrazione a gruppi come storia separata: rinominare in massa rompe i link.
10. **Config MCP:** `laravel/.mcp.json` ha ancora server duplicati di strumenti nativi (filesystem, memory,
    fetch, sequential-thinking, git, puppeteer). Decisione aperta: vedi `bmad-output/mcp-stack-review.story.md`.
11. **Lock di modulo:** ci sono ~180 file `.lock` nei moduli. Molti sono lock preesistenti del progetto, non
    residui miei: non cancellarli senza sapere chi li ha creati.

## Come riprendere

```bash
cd /var/www/_bases/base_ptvx_fila5/laravel
mkdir -p /tmp/claude-1000/phpstan-tmp-ripresa
TMPDIR=/tmp/claude-1000/phpstan-tmp-ripresa php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --no-progress
```

Cache isolata: non usare `clear-result-cache` mentre altre sessioni girano.

## Regole imparate oggi

Vedi la memoria `phpstan-zero-lezioni-operative` e `filament-sidebar-stato-gruppi-null` nel second brain.
In sintesi: un fatal maschera tutto; il tipo di una relazione e' quello del corpo; prima il consumatore,
poi lo scopo; mai allargare un tipo per far tacere PHPStan; un file condiviso va assegnato a un solo agent.

## Indice delle storie aperte

| Voce | Storia |
|---|---|
| Sidebar admin senza moduli (Xot) | `laravel/Modules/Xot/docs/stories/filament-sidebar-collapsed-groups-null.story.md` |
| UserMassSeeder, tipo nullable (User) | `laravel/Modules/User/docs/stories/user-mass-seeder-console-command-nullable.story.md` |
| stipendioTabellare, decisione (Ptv) | `laravel/Modules/Ptv/docs/stories/stipendio-tabellare-relation-decision.story.md` |
| Asz00f scopeOfYear, test (Sigma) | `laravel/Modules/Sigma/docs/stories/asz00f-scope-of-year-test.story.md` |
| Sigma findings per scopo (Sigma) | `laravel/Modules/Sigma/docs/stories/phpstan-sigma-findings-by-purpose.story.md` |
| Profilo di test tenant (Tenant) | `laravel/Modules/Tenant/docs/stories/tenant-test-connection-profile.story.md` |
| Credenziali PDND (Pdnd) | `laravel/Modules/Pdnd/docs/stories/pdnd-guzzle-credentials-to-env.story.md` |
| Risposta Guzzle (Pdnd) | `laravel/Modules/Pdnd/docs/stories/phpstan-guzzle-proxy-page-response.story.md` |
| Eccezione userId (Xot) | `laravel/Modules/Xot/docs/stories/notifications-userid-integer-exception.story.md` |
| Lock npm vite 6 (root) | `bmad-output/npm-lock-vite-6-realign.story.md` |
| Nomi .md con data (root) | `bmad-output/md-filename-date-migration.story.md` |
| Lock di modulo (root) | `bmad-output/module-lock-files-audit.story.md` |
| Config MCP (root) | `bmad-output/mcp-stack-review.story.md` |

## Ripresa 2026-10-27: baseline e causa della segnalazione residua

- Baseline `phpstan analyse Modules` (cache di default, `level: max`): 2 messaggi, entrambi in
  `Modules/User/tests/Feature/Auth/AuthFlowRedirectsTest.php:88`, `class.notFound` su
  `Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction`.
- Causa: il modulo `Gdpr` non esiste piu' in `laravel/Modules/`. Era un voce di submodule, rimossa in
  `54e7e4b937` (cleanup di `gitmodules.ini`, 634 file cancellati dal tracking). Nessuna copia su disco
  (`find /var/www`). Il test assumeva il modulo presente: rompe la registrazione per una dipendenza assente.
- Stato concorrente: alle 10:38 un'altra sessione ha rimosso il test "registration redirects to the personal area"
  da `AuthFlowRedirectsTest.php` (11 righe). Non modificato da questa sessione per non sovrapporsi.
- Lock: `Modules/User.lock` dichiara `phpstan-clusterC-user-20261021` (PID 914860) dal 2026-10-21: verificare il PID prima di riprendere.
- Decisione aperta: la registrazione ora non ha un'Action User-owned che la gestisca. Opzioni: (a) testare
  `GetPostLoginUrlAction` come destinazione post-registrazione in User; (b) spostare la logica di
  `HandleSuccessfulRegistrationAction` in User se la registrazione e' funzionalita' del modulo User. Non ripristinare
  `Gdpr` senza decisione: la sua assenza e' stata voluta dal cleanup dei submodule.
