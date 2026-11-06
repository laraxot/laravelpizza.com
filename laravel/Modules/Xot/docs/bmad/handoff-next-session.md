---
title: "Passaggio di consegne per la prossima sessione"
type: handoff
status: active
created: 2026-10-20
updated: 2026-10-25
module: Xot
tags: [bmad, handoff, phpstan, qualita, services, livewire, test, docs]
qmd: "handoff prossima sessione ripartire domani stato verificato decisioni utente run completo guardia db story epic"
related:
  - ./epic-code-quality-ratchet.md
  - ../stories/test-database-guard.story.md
  - ../stories/docs-organization-xot.story.md
  - ../stories/debug-leftovers-cleanup-xot.story.md
  - ../stories/services-parity-audit-xot.story.md
---

# Passaggio di consegne per la prossima sessione

Scritto il 2026-10-20 sera. Le cifre sono misure del giorno e sono volatili: altre sessioni (una sessione Claude parallela, `codex`, `opencode`) editano lo stesso albero senza lock. Prima di agire rimisura con i comandi in fondo.

## Ordine permanente dell'utente

Risolvere tutti gli errori PHPStan di `cd laravel && ./vendor/bin/phpstan analyse Modules` andando alla sorgente (scopo del codice, non messaggio), in parallelo e in ordine casuale con swarm + subagent + BMAD + second brain, senza chiedere conferma; riordinare di continuo le `docs/` di moduli e temi; migliorare i prompt in `bashscripts/docs/prompts`; migliorare la qualita' del codice. Regole di prodotto emerse: nessun `*Service` (Spatie QueueableAction con `execute()`), nessuna cartella `app/Services`, niente Livewire puro (solo dentro widget Filament), niente emoji ne' em dash.

## Stato verificato (riportato da agenti, non rieseguito da me)

- PHPStan: 19 moduli a 0 errori uno alla volta (sweep delle 12:55 da me, delle 13:08 dall'altra sessione). Il baseline delle 09:00 era 1342 (1283 test, 59 produzione in 8 moduli). Il run COMPLETO `analyse Modules` e' stato ucciso dall'OOM del kernel alle 12:27 e non e' riuscito alle 12:32; l'ultimo tentativo (13:40-13:50) non e' partito per RAM insufficiente (vedi "Run completo").
- Service: nessuna `app/Services` su disco in nessun modulo, in `laravel/app` e in `Themes/Zero`; ratchet in `laravel/tests/Architecture/ModulesArchitectureTest.php` (test 3, allowlist vuota). `FileAction` (1092 righe) eliminata con i suoi test; recupero con `git show 50e2d2073:<path>`.
- Debug in produzione: tokenizer PHP a 0 sui moduli bonificati (restano solo `print_r`/`var_export` con `true`).
- Guardia DB per i test: scritta (`Modules/Xot/tests/Support/TestDatabaseGuard.php`, richiamata da `Modules/Xot/tests/CreatesApplication.php` e da `laravel/tests/TestCase.php`); 6 casi sulla funzione pura verdi, PHPStan mirato a 0. NON provata con l'app avviata.
- Docs: Xot, Lang, Cms, UI e Zero riordinati (frontmatter, indici, duplicati marcati superseded, 9 file con marker risolti dall'altra sessione). Tool dei link unificato in `bashscripts/tools/docs/docs-organizer.py` (`links --tail`, `--report`, `selftest`).
- Second brain: memoria persistente ripulita (indice, link, note di verifica); prompt 03, 11, 25, 46, 05 aggiornati.

## Non verificato

- Il run completo e le soglie `typeCoverage.*` (esistono solo sull'albero intero).
- Qualunque test: nessun Pest/PHPUnit e' stato eseguito in modo controllato; il DB di test non esiste o e' incompleto. PHPStan a 0 non dimostra che il codice funzioni.
- Che i database `quaeris_data_test`, `quaeris_user_test`, `quaeris_survey_test` siano usa-e-getta.
- `composer dump-autoload`: il classmap di `vendor` cita ancora i vecchi path (Geo, `FileAction`).
- Il remoto `laraxot/dev` (solo riferimento locale controllato, nessun `git ls-remote`).

## Possibile guasto di sicurezza da verificare per primo (User, P0)

`Modules/User/app/Models/BaseUser.php:468-480` (`setPasswordAttribute`) applica `Hash::make` solo se `strlen($value) < 32`; altrimenti salva il valore cosi' com'e', presumendo che sia gia' un hash. Il cast `hashed` e' commentato (riga ~515). Una password di 32 o piu' caratteri finirebbe in chiaro nel database e poi non permetterebbe il login. Letto nel codice dalla sessione parallela, NON riprodotto. Correzione naturale: `Hash::isHashed($value)` al posto del confronto di lunghezza. Story: `user-hash-password-solo-nelle-actions` (modulo User, sessione parallela). Ricerca dello stesso schema negli altri moduli: vedi la story o rilancia `rg -n -P 'strlen\(\$\w+\)\s*<\s*32' laravel/Modules laravel/Themes -g '*.php' -g '!**/vendor/**'`.

## Incidente sui dati dei test (da leggere)

64 invocazioni di Pest hanno girato prima dell'avviso. Tutti i DB osservati finiscono per `_test`; nessuna evidenza di contatto coi DB reali. `Modules/User/tests/Unit/Models/BaseUserTest.php:12` usa `RefreshDatabase`, quindi ha eseguito `migrate:fresh` su `quaeris_data_test` (DROP dedotto, non osservato). I file User che usano davvero `RefreshDatabase`/`DatabaseMigrations` sono 8 (UserManagementBusinessLogicTest, GetCurrentDeviceActionTest, Models/{BaseUserTest, DeviceTest, PermissionTest, ProfileTest, TeamTest, TenantTest}); MigrateDbTest, RoleTest e UserTest lo citano solo in commenti o messaggi di skip. Rischio residuo: `.env.testing` e' tracciato con credenziali reali, stesso server e stesso account con DROP; un `DB_DATABASE` esportato o un `.env.testing` mancante raggiungerebbe `quaeris_data`. Dettagli: epic di qualita' e story `test-database-guard`.

## Decisioni che aspettano l'utente

1. Account MySQL di test con grant solo su `*_test`; conferma che i DB `*_test` sono usa-e-getta. **Fatto il 2026-10-25**: `fixcity_data_test` e `fixcity_user_test` creati con lo script additivo documentato (`CREATE DATABASE IF NOT EXISTS`, nessun DROP, nessuna migrazione). Resta aperto l'account con grant ristretto.
2. `composer dump-autoload` (esegue gli script post-autoload-dump, avvia l'app).
3. Cancellare i Service anche sul remoto `laraxot/dev`, o accettare il ratchet locale.
4. Perimetro Livewire: letto come "nessun Livewire puro, FO incluso" (canone del 2026-05-28); aperto solo Volt/Folio (15 pagine in User, `profile/edit` da 714 righe).
5. ~~Installare `filament/blueprint` oppure restare sui contratti scritti a mano~~: **deciso il 2026-10-25: contratti scritti a mano.** `filament/blueprint` e il repository privato `packages.filamentphp.com` sono stati rimossi da `laravel/composer.json`: 401 sul repo, 404 su Packagist, zero citazioni nel codice. Restano i contratti in `Modules/<M>/docs/bmad/filament-blueprint.md` (13 moduli; ne mancano 5 con 202 file Filament).
6. `laravel/phpstan.neon` (solo l'umano): il blocco `parallel` e' tutto commentato (default = nproc, 18-20 worker, causa dell'OOM con run concorrenti); `Lime*.php` (50 file, 4897 righe) sono esclusi dall'analisi.
7. Se `APP_ENV=testing` e' mai impostato fuori dai test (Quaeris: rami `environment('testing')` spengono l'autorizzazione).
8. Test su sqlite o MySQL (la regola dice MySQL; 9 TestCase configurano sqlite).
9. Ruotare la password MariaDB che era in chiaro in due pagine del tema Zero (resta nella cronologia git) e le credenziali di `.env.testing`.
10. Dove vivono gli epic cross-modulo: la policy dice `bmad-output/`, l'hook `bmad-output-docs-guard.sh` lo rifiuta. L'epic `bmad-output/epic-services-to-queueable-actions.md` e' stato scritto con strumenti MCP che non passano dagli hook: decidere se spostarlo in `laravel/Modules/Xot/docs/bmad/` (e correggere i suoi due numeri sbagliati: `FileAction` 126 chiamate in 6 file di soli test, non 149 in 19).
11. Pint (301 file) e quando; 1612 file `.md` vuoti ma referenziati in Xot; ingresso canonico delle docs (`00-INDEX.md`, `INDEX.md`, `README.md`).

## Cosa fare domani, in ordine

1. Rimisura (comandi sotto). Leggi il risultato del run completo (sezione sotto). Se non c'e' un risultato valido, rifallo con RAM >= 16 GiB e nessun altro `analyse Modules` completo vivo.
2. Chiedi all'utente le decisioni 1, 2, 7, 8 (sbloccano i test) e 10.
3. Wave S1 di produzione, una lane per modulo (mai due su PHP nello stesso modulo): Notify (Esendex TLS e credenziali in query string; `cssInLine()` mancante), AI (chiavi `ai.*` assenti da `config/ai.php`), Lang (`SaveTransAction` scrive a runtime), Gdpr (registrazione e consenso nei widget -> Action); per la sessione parallela: Quaeris (bypass `environment('testing')`), User (`BaseTenant`, `Hash::make` nei widget), Setting (`mysqldump --password=` in `DownloadAction.php:42-43`).
4. Verita' dei test: solo dopo guardia verificata e DB confermato: probe `pest --test-directory=Modules/<M>/tests --list-tests`; fondere i 23 file con test reali mai eseguiti nei file con nome giusto.
5. Contratto Filament: password e registrazione nelle Action; etichette nei `lang`; 21 extends diretti verso `XotBase*`; blueprint dei 5 moduli.
6. Docs: `links --fix --tail` sui miei moduli (Xot, Cms, Lang, UI, Geo, Zero) con diff controllato; decisione sui vuoti; wiki del second brain: pilota su `rules/filament`.
7. Per ultimo: silenziamenti (69 `@phpstan-ignore`, 1106 `@var`), stile, Pint.

## Mappa delle story (indice vivo)

Le story stanno nel modulo owner, `laravel/Modules/<M>/docs/stories/`, e puntano agli epic con il campo `epic`. Per elencarle tutte:

```bash
cd /mnt/nas07/var/www/_bases/base_quaeris_fila5
rg -l --hidden -P '^epic:.*(epic-code-quality-ratchet|epic-services-to-queueable-actions)' laravel/Modules -g '*.story.md' | sort
rg -l --hidden -P '^status: ready-for-dev' laravel/Modules -g '*.story.md' | sort   # solo quelle pronte
```

Epic: `laravel/Modules/Xot/docs/bmad/epic-code-quality-ratchet.md` (qualita'), `bmad-output/epic-services-to-queueable-actions.md` (Service), `laravel/Modules/Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md` (Livewire, con la nota di verifica del 2026-10-20 sera). Controprova: lo stesso `rg` su un'epic che sai citata deve restituire almeno un file.

## Coordinamento con la sessione parallela

La sessione `base-quaeris-fila5-94` (altro processo Claude Code) ha concordato: miei Notify, AI, Lang, Xot, Cms, UI, Gdpr, Activity, Geo; suoi User, Quaeris, Setting, Media, Job, Tenant, DbForge, Limesurvey, Chart, CloudStorage. Non apre lane PHP finche' non le si scrive "run completo finito". Se e' chiusa, tutto passa a una sola sessione.

## Regole operative apprese oggi

- Un run PHPStan su piu' di ~5 file passa dalla coda `flock -w 1800 "${PHPSTAN_GATE:-/tmp/phpstan-gate.lock}" nice -n 10 ...` (prompt 11); un "Child process was killed by signal 9" e' un OOM, non un risultato.
- Trappole di shell: `find` e' una funzione su `bfs` (usa `/usr/bin/find`), `rg` salta le cartelle nascoste senza `--hidden`, zsh non divide le variabili non quotate (prompt 03).
- Massimo ~5 agenti insieme, niente polling, si riprendono con SendMessage invece di rilanciarli (memoria `swarm-size-and-polling-cost`).
- Prima di spartire il lavoro, rimisurare: in poche ore il baseline e' passato da 10053 a 1342 errori perche' un'altra sessione aveva gia' lavorato.
- Un conteggio zero va controprovato; "0 errori" scritto in una story non vale.

## Comandi per rimisurare

```bash
cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel
awk '/MemAvailable/{printf "%d GiB\n",$2/1048576}' /proc/meminfo; pgrep -c -f 'phpstan analys[e]'
/usr/bin/find Modules Themes app -type d -name Services -not -path '*/vendor/*'          # atteso: solo tests/docs, nessuna app/Services
flock -w 1800 /tmp/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress --error-format=json > /tmp/phpstan-run.json; echo $?
```

## Run completo

Esito del 2026-10-20 (13:40-13:50 UTC): NON ESEGUITO, nessun totale e nessuno 0 dichiarato. Soglia di partenza: MemAvailable >= 16 GiB e nessun altro `analyse Modules` completo vivo. MemAvailable e' arrivata al massimo a 14 GiB (13, 12, 12, 8, 12, 14 nelle sei misure da 120 s) con 94 GiB totali e 75 usati; un `llama-server` (Ollama, PID 3476315 al momento) teneva 18,4 GiB. Run completi vivi: 0. Marker di conflitto nei PHP: 0 (controprova valida). Un run completo pesa 8-11 GiB di picco (18-20 worker): con meno memoria libera del picco il kernel puo' uccidere un worker (come alle 12:27) o, peggio, il processo piu' grosso della macchina.

Per sbloccare, in ordine di costo (decide l'utente):

1. Liberare memoria: fermare per qualche minuto `llama-server`/Ollama o altri processi pesanti, poi rilanciare lo script gia' pronto `bash /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/final-run.sh` (pre-check, attesa RAM, run in coda `flock`, validazione; la cartella e' temporanea e puo' sparire: in tal caso usa i comandi della sezione "Comandi per rimisurare"); l'analisi e' in `final2-analyze.py` nella stessa cartella (solo sintassi controllata).
2. Limitare i worker in `laravel/phpstan.neon` (solo l'umano): attivare il blocco `parallel` (oggi tutto commentato, righe 12-15), per esempio `maximumNumberOfProcesses` basso: dimezza il picco.
3. Run a processo singolo con `--debug` (non provato: con `--error-format=json` stampa i nomi dei file nello stesso stdout del JSON e rompe il parsing; usare `--error-format=raw` e filtrare le righe `file:riga:`; piu' lento, ma pochi GiB). Va verificato su un modulo piccolo prima di fidarsi.

Finche' non c'e' un run valido, l'unica prova e' lo sweep per modulo (19 moduli a 0 alle 12:55 e alle 13:08) che NON copre `typeCoverage.*` ne' gli errori tra moduli.
