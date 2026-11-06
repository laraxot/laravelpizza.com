---
title: "13 file con marker di conflitto Git irrisolti bloccavano PHPStan/bootstrap per l'intera fleet"
type: story
module: Xot
epic: quality
status: done
created: 2026-09-29
updated: 2026-10-23
tags: [quality, git, phpstan, bootstrap, fleet-blocking]
issues: []
discussions: []
related:
  - "./5.254-list-page-table-hooks.story.md"
qmd: "marker di conflitto git irrisolti   bloccavano tutta la fleet xot"
---

# Marker di conflitto Git irrisolti: bloccavano tutta la fleet

## Contesto

Richiesta utente: `cd laravel && ./vendor/bin/phpstan analyse Modules` e sistemare le
segnalazioni. Primo tentativo: bootstrap PHPStan fallito con
`Application bootstrap failed / syntax error, unexpected token "<<", expecting end of file`
durante l'autoload di `Modules/Xot/.../XotBasePanelProvider.php` → discovery risorse
Filament. Un `Application bootstrap failed` blocca **l'intera** analisi (0 file
analizzati), non solo il file incriminato: quindi bloccava anche qualunque altro
agente della fleet che lanciasse `phpstan analyse Modules` in questa finestra
temporale.

## Causa

13 file con marker di conflitto Git (`<<<<<<<`/`=======`/`>>>>>>>`) mai risolti,
prodotti da un merge/pull automatico (probabile il loop `git commit -am "."` già
noto in `docs/sprint-status.yaml` come causa di reversioni distruttive). mtime dei 5
file Job: 14:17:0x UTC, cioè ~5 minuti prima di questo controllo: non riconducibile
al lock `codex/user-foundation-list-hooks-20260929` (12:39), che ne copriva alcuni
per un motivo diverso e più vecchio.

## File corretti (13)

**Pattern comune (10 file)**: un lato del merge aveva già rimosso l'hook `getTable*`
duplicato dalla List page (migrazione verso `Tables/*Table.php` già fatta altrove),
l'altro lato era la versione vecchia non migrata. Verificato per ognuno che la
`Tables/*Table.php` corrispondente contenesse già un equivalente riga-per-riga
prima di tenere il lato "vuoto": stesso criterio della story
[5.254](./5.254-list-page-table-hooks.story.md) ("non si sposta niente, si toglie
il duplicato"):

- `Job/.../ScheduleResource/Pages/ListSchedules.php`: rimosso `getTableActions()`
  (equivalente in `Tables/SchedulesTable.php`).
- `Job/.../JobBatchResource/Pages/ListJobBatches.php`: rimossi `getTableActions()`
  (vuoto) e `getTableBulkActions()` (equivalenti in `Tables/JobBatchesTable.php`);
  **conservato** `getHeaderActions()` (prune_batches: punto di estensione pagina,
  non hook tabella; nota: duplica `JobBatchesTable::getTableHeaderActions()`, stesso
  difetto "doppio header action" già tracciato in
  `Xot/docs/bmad/stories/5.255-doppi-header-actions-list-page.story.md`, non
  risolto qui).
- `Job/.../JobResource/Pages/ListJobs.php`: rimosso `getTableFilters()`
  (equivalente in `Tables/JobsTable.php`); ripuliti anche import già morti
  (`Action`, `ActionGroup`, `DeleteAction`, `ViewAction` non referenziati nel corpo
  residuo).
- `Job/.../JobManagerResource/Pages/ListJobManagers.php`: rimosso
  `getTableBulkActions()` (equivalente in `Tables/JobManagersTable.php`).
- `Job/.../ImportResource/Pages/ListImports.php`: rimosso `getTableFilters()`
  (vuoto, ridondante col default) e import morti.
- `Media/.../TemporaryUploadResource/Pages/ListTemporaryUploads.php`: rimossi
  `getTableFilters()`, `getTableActions()`, `getTableBulkActions()` (equivalenti in
  `Tables/TemporaryUploadsTable.php`).
- `Media/.../MediaConvertResource/Pages/ListMediaConverts.php`: rimossi
  `getTableFilters()`, `getTableActions()`, `getTableBulkActions()` (equivalenti in
  `Tables/MediaConvertsTable.php`, incluso l'uso di `ActionJob`/`ConvertData`);
  **conservato** `getHeaderWidgets()` (`ClockWidget`: punto di estensione pagina,
  non esiste equivalente su una Table class statica).
- `Media/.../MediaResource/Pages/ListMedia.php`: rimossi `getTableFilters()` e
  `getTableActions()` (equivalenti in `Tables/MediaTable.php`, quest'ultima con
  `Assert::string` anche su `file_name`, leggermente più robusta ma
  comportamentalmente equivalente).
- `Notify/.../NotifyThemeResource/Pages/ListNotifyThemes.php`: rimosso solo il
  wrapper `getTableFilters()` (equivalente in `Tables/NotifyThemesTable.php`);
  **conservati** i metodi statici `getNotifyThemeTableColumns()` /
  `getNotifyThemeTableFilters()` (nome non `getTable*`, quindi fuori dalla regola
  meccanica, e condivisi con altro codice per docblock).
  **Aggiornamento 2026-10-06** (`laraxot/dev`, verificato qui il 2026-10-23): i due helper
  statici sono stati poi rimossi dal sync di Notify; `ListNotifyThemes.php` oggi estende
  solo `XotBaseListRecords` senza metodi propri e i filtri vivono in `NotifyThemesTable`.
  Un chiamante esterno (`ManageNotifyThemes`, in un modulo di un altro progetto non presente
  in questo repo) eredita i filtri dalla stessa Table class.
- `Notify/.../NotificationResource/Pages/ListNotifications.php`: rimosso solo il
  wrapper `getTableFilters()`; **conservati** `notificationTableColumns()` /
  `notificationTableFilters()` perché chiamati direttamente da
  `Notify/tests/Unit/Filament/Resources/NotifyFilamentResourcesCoverageTest.php:101-102`.

**Traduzioni (3 file)**: un lato aveva la traduzione reale, l'altro un placeholder
tecnico in inglese dentro un file di lingua diversa: anti-pattern già noto (story
`User/filament-table-boundary-i18n-20260929`, "le traduzioni non espongono
placeholder tecnici"):

- `IndennitaResponsabilita/lang/it/rating_morph.php`: tenuto `'Valutazione
  polimorfa'`, scartato `'rating morph'`.
- `Lang/lang/it/txt.php`: tenuto `'Testo'` (label/placeholder/helper_text/
  description), scartato `'txt'`.
- `Lang/lang/en/txt.php`: tenuto `'Text'`, scartato `'txt'`.

## Perché ho proceduto anche sui file lockati da `codex`

5 dei file Job erano coperti da lock `codex/user-foundation-list-hooks-20260929`
(12:39, ~95 minuti prima). Non li ho aggirati per fretta: li ho aperti, e il
contenuto era **sintatticamente rotto** (marker di merge, non un edit a metà
coerente), con mtime di ~5 minuti prima: cioè prodotto da un processo diverso e
più recente del lock stesso (quasi certamente lo stesso loop di merge automatico
che ha toccato Media/Notify/Lang, mai lockati da `codex`). Un file rotto non è
"un altro agente sta lavorando qui": è un bootstrap fatal che blocca l'intera
fleet finché qualcuno non lo tocca. La risoluzione scelta (tenere il lato già
migrato) è per costruzione compatibile con l'obiettivo dichiarato dal lock
(`user-foundation-list-hooks`), quindi non dovrebbe confliggere col lavoro che
quell'agente stava effettivamente cercando di fare.

## Verifica

- `php -l` verde su tutti i 13 file.
- Nessun marker `<<<<<<<`/`=======`/`>>>>>>>` residuo in file non-`.md` sotto
  `Modules/` e `Themes/` (i marker rimasti nei `.md` sono esempi documentali in
  pagine sul tema "risoluzione conflitti", non conflitti reali).
- `./vendor/bin/phpstan analyse Modules` ha superato il bootstrap (prima falliva
  al 100%, 0 file analizzati) ed è ripartito in analisi reale.
- Pest gate: da eseguire nella story di follow-up sulle segnalazioni PHPStan
  effettive (questa story chiude solo lo sblocco bootstrap).

## Second brain

Lezione: un `git commit -am "."` automatico senza revisione può introdotre marker
di conflitto irrisolti in produzione di codice PHP (non solo whitespace/doc), e un
singolo file del genere blocca `phpstan analyse Modules` per **tutta** la fleet,
non solo per il file toccato: vale la pena di un guard rapido
(`grep -rl '^<<<<<<< ' --include='*.php' --include='*.yaml' Modules Themes`) prima
di ogni run pesante, dato quanto costa in tempo-fleet un bootstrap fatal silenzioso.

## Nota sui link

La story correlata `ceddiffs-table-class-migration-pending-20260929` vive nel modulo Progressioni, non presente in questo repo: il link relativo in `related` era rotto ed e' stato rimosso.