# Story: Quality-gate closure — Modules/User (2026-09-04)

## BMAD phase
Build + Measure (standing order pillar 5 — chiusura gate qualità di modulo).

## Contesto
PHPStan era già stato misurato a 0 errori su `Modules/User` in una sessione precedente della stessa
giornata (2026-09-04), con e senza path arg, dopo un refresh `ide-helper:generate/meta/models`. Questa
story copre il resto del gate: phpmd, phpinsights (verificato non disponibile), pest, coverage, git.

## Coordinamento
- Letti `docs/chat/*.md` per note/collisioni su User prima di editare. Rilevanti:
  `swarm-sync-user-cloudstorage-ownership.md` (fix `dddx()` hot-path pregressi, non in conflitto),
  `user-profile-instanceof-two-independent-fixes.md` (`ProfileEditVoltComponent.php` — due varianti dello
  stesso fix di sicurezza già committate da un'altra sessione, file NON riaperto in questa sessione),
  `xot-blade-component-bootstrap-crash-wip.md` (bug di bootstrap condiviso, causa esterna a User, vedi
  sotto), `phpstan-quality-gate-lanes.md` (nessun `MERGE_HEAD` residuo su User al momento di questa
  sessione — verificato, già risolto).
- Lock preso su `laravel/Modules/User` (`quality-gate-2026-09-04`, agente `agent-User`) prima di ogni
  edit, rilasciato a fine sessione con `bashscripts/lock/unlock.sh`.
- All'apertura sessione, `git status` nel repo del modulo mostrava **1209 file modificati** non
  committati — drift massiccio di sessioni concorrenti, non di questa sessione (confermato non-whitespace
  con `git diff --ignore-all-space --stat`: 1131 file cambiano comunque). Nessuno di questi file toccato;
  solo i file intenzionalmente modificati da questa sessione sono stati aggiunti a `git add`.
- Durante il lavoro, `phpstan analyse Modules/User` è fallito due volte con `Application bootstrap
  failed` per colpa di `Modules/Xot/app/View/Components/_components.json` (poi anche un `_components.json`
  di `Modules/Activity`) modificati in quel momento da sessioni concorrenti con lo schema vecchio di
  `ComponentFileData` — stesso bug già diagnosticato per `Modules/Cms` in
  `docs/chat/xot-blade-component-bootstrap-crash-wip.md`. Non toccato (fuori scope, modulo/lock altrui);
  i run successivi, dopo che l'altra sessione ha corretto il proprio file, sono tornati puliti.

## Cosa è stato trovato
- `php -l` su tutti i file `.php` di `Modules/User`: nessun errore di sintassi.
- PHPStan baseline (cache pulita, con path arg): **0 errori**, 1664 file — confermato stabile dopo la
  risoluzione del race descritto sopra.
- PHPMD (`./tools/phpmd.sh Modules/User/app text ../docs/phpmd.ruleset.xml`): **524** finding.
- PHPInsights: **non installato** (`vendor/bin/phpinsights` assente) — coerente con la memoria
  second-brain "Pest 5 e phpinsights non coesistono". Passo saltato, documentato, non simulato.
- Pest (`./vendor/bin/pest -c Modules/User/phpunit.xml --no-coverage`): 840 passed / 242 failed / 26
  risky / 7 todos / 27 skipped (8981 assertions, 772.23s). Tutti i fallimenti riconducibili a cause
  preesistenti non correlate a questa sessione (vedi `docs/coverage.md` per il dettaglio verificato per
  categoria e isolato con un test mai toccato).
- Coverage: **non misurabile in modo affidabile oggi** — difetto di ambiente (`XDEBUG_MODE=coverage` non
  onorato dal processo `php` invocato da `vendor/bin/pest` in questo ambiente condiviso; solo `-d
  xdebug.mode=coverage` esplicito funziona, ma non raggiunge il processo reale che esegue i test).
  Dettaglio diagnostico completo in `docs/coverage.md`.

## Cosa è stato fatto
Fix reali applicati (nessuna soppressione via `@phpstan-ignore` o annotazioni phpmd):

1. **Codice morto — 4 `UnusedLocalVariable` rimosse** (solo su file già puliti nel working tree, per non
   sovrascrivere lavoro concorrente):
   - `app/Console/Commands/AssignRoleCommand.php`
   - `app/Http/Controllers/UpgradeController.php`
   - `app/Listeners/FailedLoginListener.php`
   - `app/Listeners/LoginListener.php`

2. **Complessità — extract-method su `app/Actions/Socialite/RetrieveSocialiteUserAction.php`:**
   `execute()` (CC 15, NPath 240) diviso estraendo la logica di estrazione del token via Reflection in un
   metodo privato `extractToken()`. Nessun cambio di comportamento. Risultato: `execute()` non più
   segnalato, `extractToken()` CC 11 (marginalmente sopra soglia, non ulteriormente scomponibile senza
   frammentare artificialmente una catena di fallback coesa). Sistemati anche i 3 `MissingImport` dello
   stesso file.

Totale: 524 → 514 finding PHPMD (vedi `docs/coverage.md` per la nota metodologica sulla verifica
per-file, necessaria per via di un'incoerenza della scansione a livello di directory durante un edit
concorrente).

Lasciati e documentati per categoria in `docs/coverage.md` (non per singolo finding): `UnusedFormalParameter`
/ `CamelCaseParameterName` (convenzione progetto `_param` nelle classi Policy), `MissingImport` residui
(file già dirty per lavoro concorrente), `NumberOfChildren` su `UserBasePolicy` (architetturale, pattern
Spatie Permission), `CouplingBetweenObjects` su `UserServiceProvider`/`ProfileEditVoltComponent`
(intrinseco al ruolo, quest'ultimo già oggetto di un fix di sicurezza lo stesso giorno — non riaperto),
`CyclomaticComplexity`/`ElseExpression` residui, `CamelCaseVariableName`/`CamelCasePropertyName` (nomi che
rispecchiano colonne DB snake_case), `ExcessiveParameterList` su DTO Spatie Laravel Data.

## Come è stato verificato
- `php -l` su tutti i file toccati: nessun errore.
- `./vendor/bin/phpstan clear-result-cache` + `analyse Modules/User` dopo ogni edit (hook automatico) e
  di nuovo a fine sessione: **0 errori**, invariato rispetto alla baseline.
- `./tools/phpmd.sh` sui singoli file toccati e sull'intero modulo: numeri riportati sopra, verificati con
  doppio controllo (scansione directory + scansione singolo file) per la discrepanza descritta.
- Pest: risultati numerici reali riportati sopra e in `docs/coverage.md`; verificato con grep mirato che
  nessuno dei 242 fallimenti riguardi i 5 file toccati da questa sessione; isolato un test **mai toccato**
  (`UserTypeTest.php`) per confermare che i fallimenti sono preesistenti e non del diff di oggi; verificato
  con test dedicato (`UserGapAttackCoverageTest.php`) che `RetrieveSocialiteUserAction` resta
  instanziabile/funzionante dopo il refactor.
- Coverage: diagnosi riproducibile (3 comandi, vedi `docs/coverage.md`) che isola la causa a livello di
  ambiente PHP/xdebug, non di codice applicativo.

## File toccati (committati da questa sessione)
- `app/Console/Commands/AssignRoleCommand.php`
- `app/Http/Controllers/UpgradeController.php`
- `app/Listeners/FailedLoginListener.php`
- `app/Listeners/LoginListener.php`
- `app/Actions/Socialite/RetrieveSocialiteUserAction.php`
- `docs/coverage.md`
- `docs/stories/user-quality-gate-2026-09-04.story.md` (questo file)
