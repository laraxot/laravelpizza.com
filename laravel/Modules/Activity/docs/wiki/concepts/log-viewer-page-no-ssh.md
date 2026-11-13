---
title: "Pagina Log — consultare i file di storage/logs dal pannello, senza SSH/FTP"
type: concept
status: implemented-pending-production-check
module: Activity
created: 2026-09-20
updated: 2026-09-20
tags: [log, logs, log-viewer, filament, no-ssh, monitoring, storage-logs, invites]
qmd: "Activity LogViewer pagina log storage/logs senza ssh ftp file di log survey app_requests laravel.log coda tail download"
related:
  - ../../stories/activity-admin-log-viewer-page.story.md
  - ../../../../Quaeris/docs/stories/quaeris-admin-log-viewer-no-ssh.md
  - ../../../../Xot/docs/wiki/concepts/env-widget-no-ssh-env-editor.md
  - ../../../../Xot/app/Filament/Resources/LogResource.php
issues:
  - "https://github.com/laraxot/module_quaeris_fila5/issues/49"
  - "https://github.com/laraxot/base_quaeris_fila5/issues/204"
discussions:
  - "https://github.com/laraxot/base_quaeris_fila5/discussions/205"
---

# Pagina Log — leggere i file di `storage/logs` dal pannello

## Problema che risolve

Su un server di produzione senza accesso SSH/FTP i file di log (`storage/logs`) sono
irraggiungibili. La pagina [`LogViewer`](../../../app/Filament/Pages/LogViewer.php) li rende
consultabili dal pannello **Activity**: voce **Log** nel gruppo **Monitoraggio**, indirizzo
`/activity/admin/log-viewer`.

## Cosa fa

- **Elenca ricorsivamente** i file `.log` sotto `storage/logs`, comprese le sottocartelle
  (`surveys/<id survey>/app_requests_<data>.log`, `surveys/rejected/...`)
  ([`ListLogFilesAction`](../../../app/Actions/Log/ListLogFilesAction.php)).
- **Li mostra come albero di cartelle**, come in un editor, in un pannello a sinistra
  ([`BuildLogFileTreeAction`](../../../app/Actions/Log/BuildLogFileTreeAction.php)): prima le cartelle in
  ordine naturale (9, 10, 252, 1000), poi i file dal più recente; ogni cartella riporta quanti file contiene e
  il file scelto è evidenziato. All'avvio sono aperte le cartelle di primo livello (per esempio `surveys`) e
  quelle che contengono il file scelto. Lo stato aperto/chiuso è tenuto **lato server** (`LogViewer::$expanded`),
  non nel browser, così non si perde quando la pagina si aggiorna (per esempio mentre si scrive nella ricerca).
  I percorsi passati a `wire:click` usano `Js::from()`, sicuro anche con apici nel nome.
- **Legge solo la coda** del file scelto ([`ReadLogTailAction`](../../../app/Actions/Log/ReadLogTailAction.php)):
  finestra selezionabile da 128 KB a 4 MB (default 256 KB), mai il file intero. Se il file è più
  grande, la prima riga, tagliata a metà, viene scartata.
- **Divide in voci Monolog** (`[data ora] ambiente.LIVELLO: messaggio`) tenendo attaccate a ogni voce le
  righe successive, per esempio le stack trace ([`ParseLogEntriesAction`](../../../app/Actions/Log/ParseLogEntriesAction.php)).
- **Filtra** per livello e per testo, senza distinguere maiuscole/minuscole, e mostra le voci dalla più
  recente, al massimo 200 ([`FilterLogEntriesAction`](../../../app/Actions/Log/FilterLogEntriesAction.php)).
- **Scarica il file completo** da `/api/log-download?file=...`: pagina **Folio**
  ([`log-download.blade.php`](../../../resources/views/pages/api/log-download.blade.php), montata da Folio su
  `/api` con il middleware `web`) che delega a
  [`DownloadLogFileAction`](../../../app/Actions/Log/DownloadLogFileAction.php). L'Action risponde con
  `BinaryFileResponse`, letta a blocchi dal disco. Non c'è nessun Controller (regola «No Controllers»: Folio +
  Action) e non si usa un'azione Livewire: per un download Livewire legge tutto il file in memoria e lo codifica
  in base64. Risposte: 403 se non autorizzato, 404 se il file non è valido.

Le voci molto lunghe (per esempio i log per survey, con una sola intestazione seguita da migliaia di
righe JSON) mostrano **inizio e fine**, con l'indicazione dei caratteri omessi al centro.

## Sicurezza

- **Percorsi:** l'unico punto che trasforma l'input dell'utente in un percorso su disco è
  [`ResolveLogFilePathAction`](../../../app/Actions/Log/ResolveLogFilePathAction.php). Accetta solo file
  `.log` il cui `realpath()` sta **dentro** `storage/logs`: `..`, percorsi assoluti, byte nulli,
  estensioni diverse e link simbolici che escono dalla cartella vengono rifiutati
  (`InvalidLogFileException`). La pagina mostra un messaggio generico che non riporta il percorso richiesto.
- **Accesso:** [`AuthorizeLogAccessAction`](../../../app/Actions/Log/AuthorizeLogAccessAction.php) consente solo ai
  **super-admin** o a chi ha il permesso `log.viewAny`. Se il permesso non esiste ancora nel database, l'accesso è
  negato senza errore. La usano sia `LogViewer::canAccess()` sia la pagina Folio del download, così la regola è una sola.
- **Sola lettura:** nessuna cancellazione o modifica dei file.
- **Dati personali:** i log dei contatti contengono email e telefoni (per esempio la voce
  `contacts.received`), e con `LOG_LEVEL=debug` vengono scritti anche i payload ricevuti. Il testo dei log
  passa sempre da `{{ }}` (escape). Tenere ristretto il permesso.

## Struttura del codice e regole del progetto applicate

Regole caricate da `bashscripts/ai/wiki/rules/` (trigger map): no-controllers, queueable-action, prefer-spatie-data,
filament-rules-summary, git-forward-only, php-array-one-key-per-line, module-agnosticism, post-edit-quality-gate.

- **Dati: oggetti Spatie Data in `app/Datas/`**, non array: `LogFileData`, `LogEntryData`, `LogTailData`,
  `FilteredLogEntriesData`, `ResolvedLogFileData`, `LogTreeData` (albero ricorsivo) e `LogViewerStateData` (stato
  della pagina).
- **Action in `app/Actions/Log/`**: tutte con `QueueableAction` e **un solo ingresso pubblico `execute()`**.
  `ResolveLogDirectoryAction`, `ResolveLogFilePathAction`, `ListLogFilesAction`, `BuildLogFileTreeAction`,
  `ReadLogTailAction`, `ParseLogEntriesAction`, `FilterLogEntriesAction`, `BuildLogViewerStateAction`,
  `AuthorizeLogAccessAction`, `DownloadLogFileAction`. La pagina resta sottile: chiama le Action.
- **Filament:** `LogViewer` estende `XotBasePage`; `getHeaderActions()` restituisce `array<string, Action>` con chiavi stringa.
- **Classi base di Xot** (Xot ha 91 classi astratte): solo `XotBasePage` è applicabile qui. Le **Action** usano il trait
  `QueueableAction` (Xot non ha una base generica: solo `BaseTranslateAction` e `BaseFormatAction`, per traduzioni e trend). I **Data**
  estendono `Spatie\LaravelData\Data` come le altre 146 classi Data del progetto (Xot non ha una base Data).
  `InvalidLogFileException` estende `InvalidArgumentException`: l'`ApplicationException` di Xot richiede `status()`/`help()`/`error()` e
  risponde come errore JSON, e qui l'errore viene trasformato in 404. Le azioni dell'header usano `Filament\Actions\Action::make`
  (la `XotBaseAction` è astratta e pensata per essere estesa). Domanda aperta: adottare `ApplicationException`?
- **HTTP:** nessun Controller; il download è una pagina Folio (vedi sopra).
- **Formato:** array PHP e file lang con una chiave per riga.
- **Scorciatoie dichiarate** con marker `ponytail:` accanto al codice: limite di 1000 file elencati e 200 voci mostrate,
  finestra di lettura massima di 4 MB, stili in linea nella vista (vedi «Scostamenti noti dalle linee guida»).
- **Agnosticismo:** codice e test usano nomi di cartella generici (`reports/`); il caso d'uso reale (log per survey
  dell'invio automatico) è descritto solo in questa documentazione.

## Limiti da conoscere

- Ricerca e filtro valgono **solo sulla parte letta** (la coda). Per il file intero: «Scarica il file»
  oppure allargare «Parte da leggere».
- Il numero massimo di file elencati è 1000 e di voci mostrate 200.
- Il layout usa **stili in linea**: il pannello Activity non ha un tema Vite proprio, quindi le utility
  Tailwind non già usate da Filament non verrebbero compilate (vedi sotto: è uno scostamento dalle linee guida).
- **Verifica fatta:** test automatici (68, compresi quelli HTTP della pagina Folio del download), PHPStan livello max senza ignore,
  Pint e rendering con Livewire su log reali di un ambiente locale. **Non verificato:** l'aspetto nel browser e il comportamento in produzione (permessi reali,
  dimensione dei file, rotazione).

## Scostamenti noti dalle linee guida

Verificati dopo un secondo audit contro `bashscripts/ai/wiki/rules/` (2026-09-20). Non sono stati corretti perché richiedono
una decisione o un ambiente che qui manca:

1. **CSS in linea** (regola Blade «no inline CSS/JS», `blade-components.md`). La via conforme è un asset CSS costruito con Vite (`Vite::asset('resources/css/app.css', 'assets/activity')` in un `FilamentAsset::register`, come fanno Chart e Geo), che richiede build e deploy degli asset del modulo. Non
   verificabile in questo ambiente (nessun `public_html`, nessun asset costruito), e senza asset costruito la pagina in produzione perderebbe
   il layout. Il file che Xot registra (`assets/xot/header-actions-wrap.css`) non esiste nell'albero: non è un precedente affidabile.
   **Decisione aperta:** in produzione gli asset Vite di Activity vengono costruiti e distribuiti?
2. **TestCase dei test:** `Tests\TestCase` della root e non quello del modulo (`XotBaseTestCase`), perché manca
   `laravel/database/test_data.sqlite`.
3. **PHPMD e PHPInsights** non eseguibili nell'ambiente di sviluppo (manca `laravel/tools/phpmd.phar`, PHPInsights non installato): il quality
   gate è dimostrato solo per PHPStan (livello max) e Pint.
4. **Chiavi di traduzione:** le regole `003-translation-pattern` (`messages.{azione}`) e `008-translation-5-level-protocol` (5 livelli) si
   contraddicono. Le chiavi seguono la prassi delle pagine esistenti (es. `xot::artisan-commands-manager.messages.command_completed`).

Corretto nello stesso giro: la story ora esiste anche in Activity (`docs/stories/activity-admin-log-viewer-page.story.md`, `related:`
bidirezionale con quella di Quaeris) e le story sono registrate in `docs/implementation-artifacts/sprint-status.yaml`.

## Relazione con `/xot/admin/logs`

Esiste già [`LogResource`](../../../../Xot/app/Filament/Resources/LogResource.php) nel modulo Xot
(`/xot/admin/logs`, permessi `log.*`). Elenca solo il primo livello di `storage/logs` e legge il file
intero, quindi non mostra i log per survey. **Non è stata modificata né rimossa**: se spostarla in
Activity o toglierla è una decisione aperta del team (vedi la story).

## Test

```bash
cd laravel
vendor/bin/pest Modules/Activity/tests/Unit/Actions/Log Modules/Activity/tests/Feature/Filament/LogViewerPageTest.php --no-coverage
```

I test usano `Tests\TestCase` (root) e non `Modules\Activity\Tests\TestCase` (che estende `XotBaseTestCase`, come vuole
`module-testcase-xotbase-hierarchy.md`): è l'**unico scostamento dalle basi di Xot**. La seconda richiede il file sqlite
`laravel/database/test_data.sqlite`, assente in alcuni ambienti (un test esistente di Activity vi fallisce con
`SQLiteDatabaseDoesNotExistException`); con quel file i test vanno riportati al `TestCase` del modulo. Lavorano in
cartelle temporanee dentro `storage/framework/testing` e la pagina è provata puntando `storage_path()` lì
con `useStoragePath()`: non leggono né scrivono mai il vero `storage/logs`.
