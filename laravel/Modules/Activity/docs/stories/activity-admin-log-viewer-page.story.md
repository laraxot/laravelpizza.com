---
id: story-activity-admin-log-viewer-page
slug: story-activity-admin-log-viewer-page
title: "STORY — Pagina Log nel pannello Activity: consultare i file di storage/logs senza SSH/FTP"
description: "Lato modulo Activity della story tracciata in Quaeris (quaeris-admin-log-viewer-no-ssh). Il bisogno nasce dall'invio automatico dei contatti di Quaeris, l'implementazione sta nel modulo Activity: pagina Log del pannello, con albero di cartelle, lettura dalla coda del file, ricerca, filtro per livello e download. Il contesto, le domande per il team e la ricerca di duplicati sono nella story Quaeris; qui c'è cosa vive in Activity, come è verificato e cosa resta aperto."
document_type: story
category: bmad
scope: module:Activity
github_id: module_quaeris_fila5#49
status: review
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: high
created_at: '2026-09-20'
updated_at: '2026-09-20'
tags: [bmad, story, activity, logs, log-viewer, no-ssh, filament, folio]
related:
  - ../../../Quaeris/docs/stories/quaeris-admin-log-viewer-no-ssh.md
  - ../wiki/concepts/log-viewer-page-no-ssh.md
  - ../../app/Filament/Pages/LogViewer.php
  - ../../resources/views/pages/api/log-download.blade.php
github:
  repository: https://github.com/laraxot/module_activity_fila5
  issues: https://github.com/laraxot/module_quaeris_fila5/issues/49
  discussions: https://github.com/laraxot/base_quaeris_fila5/discussions/205
---

# STORY — Pagina Log nel pannello Activity

> **Fonte del contesto:** [quaeris-admin-log-viewer-no-ssh.md](../../../Quaeris/docs/stories/quaeris-admin-log-viewer-no-ssh.md)
> (modulo Quaeris). Il lavoro tocca due moduli, quindi la story esiste in entrambi con `related:` bidirezionali. Qui non si ripete
> il contesto: solo cosa vive in Activity.

## Cosa vive in Activity

Pagina **Log** del pannello Activity, `/activity/admin/log-viewer`, voce «Log» nel gruppo «Monitoraggio».

- Pagina: [LogViewer](../../app/Filament/Pages/LogViewer.php) (estende `XotBasePage`), vista `resources/views/filament/pages/log-viewer.blade.php`
  con il partial ricorsivo `partials/log-tree-node.blade.php`.
- Download: pagina Folio [log-download.blade.php](../../resources/views/pages/api/log-download.blade.php) su `/api/log-download`
  (nessun Controller, regola «No Controllers»).
- Action in `app/Actions/Log/`, ognuna con il solo `execute()`: `ResolveLogDirectoryAction`, `ResolveLogFilePathAction`,
  `ListLogFilesAction`, `BuildLogFileTreeAction`, `ReadLogTailAction`, `ParseLogEntriesAction`, `FilterLogEntriesAction`,
  `BuildLogViewerStateAction`, `AuthorizeLogAccessAction`, `DownloadLogFileAction`.
- Dati in `app/Datas/` (Spatie Data): `LogFileData`, `LogEntryData`, `LogTailData`, `FilteredLogEntriesData`,
  `ResolvedLogFileData`, `LogTreeData`, `LogViewerStateData`. Eccezione: `app/Exceptions/InvalidLogFileException.php`.
- Traduzioni `lang/it/log_viewer.php` e `lang/en/log_viewer.php`.
- Test: `tests/Unit/Actions/Log/` e `tests/Feature/Filament/` (`LogViewerPageTest`, `LogDownloadPageTest`).
- Concept: [log-viewer-page-no-ssh.md](../wiki/concepts/log-viewer-page-no-ssh.md).

## Verifiche (2026-09-20)

- PHPStan livello max senza ignore, Pint sui soli file miei, 68 test Pest, compilazione dei tre template Blade, rendering con Livewire su
  log reali di un ambiente locale. I comandi per riprodurle sono in
  [docs/chat](../../../../../docs/chat/2026-09-20-activity-log-viewer-allineamento-linee-guida.md).

## Non verificato / scostamenti noti

- PHPMD e PHPInsights non eseguibili nell'ambiente di sviluppo (manca `laravel/tools/phpmd.phar`, PHPInsights non installato).
- Aspetto nel browser e comportamento in produzione (permesso `log.viewAny` reale, dimensione e rotazione dei file).
- **Stili in linea** nella vista, segnati con `ponytail:`: le regole dei componenti Blade dicono «no inline CSS». La via conforme è un asset
  CSS costruito con Vite (`Vite::asset('resources/css/app.css', 'assets/activity')` in un `FilamentAsset::register`, come fanno Chart e Geo),
  che richiede la build e il deploy degli asset del modulo: non verificabile qui.
- I test estendono `Tests\TestCase` della root e non il `TestCase` del modulo (`XotBaseTestCase`), perché manca
  `laravel/database/test_data.sqlite`.
- **Chiavi di traduzione:** le regole `003-translation-pattern` (`messages.{azione}`) e `008-translation-5-level-protocol` (5 livelli) si contraddicono;
  le chiavi seguono la prassi delle pagine esistenti (es. `xot::artisan-commands-manager.messages.command_completed`).
- La risorsa `/xot/admin/logs` del modulo Xot non è stata toccata: spostarla o toglierla è una decisione del team.

**Domanda aperta per il team:** in produzione gli asset Vite del modulo Activity vengono costruiti e distribuiti? Se sì, si sostituiscono gli
stili in linea con un asset CSS (regola «no inline CSS»); se no, lo scostamento va accettato esplicitamente.

**Registro:** la story è registrata in `docs/implementation-artifacts/sprint-status.yaml` come `quaeris-admin-log-viewer-no-ssh` (`review`).

## Tasks/Subtasks

- [x] Pagina, Action, Data, download Folio e traduzioni nel modulo Activity
- [x] Test, PHPStan, documentazione
- [ ] Verificare la pagina in produzione e nel browser
- [ ] Con `laravel/database/test_data.sqlite` presente, riportare i test al `TestCase` del modulo (`XotBaseTestCase`)
- [ ] Sostituire gli stili in linea con un asset CSS (Vite) quando la build degli asset di Activity è disponibile
- [ ] Eseguire PHPMD e PHPInsights in un ambiente che li ha (`phpmd.phar` e PHPInsights)
- [ ] Decidere cosa fare di `/xot/admin/logs` (spostare, duplicare o rimuovere)

## Update 2026-09-21

PHPStan livello max su `Modules/Activity` segnalava 27 errori reali, tutti nei test della pagina Log introdotta da
questa story (nessuno nel codice applicativo). Fix per causa reale, nessun `@phpstan-ignore`/baseline/`mixed`/cast
di comodo:

- **`pest.expectation.redundant` (13 occorrenze, 6 file)** — `expect(...)->toBeInstanceOf(...)` e `->toBeInt()`
  ridondanti perché il tipo era già certo staticamente (i tipi di ritorno nativi delle Action e delle proprietà
  Spatie Data lo dimostrano: `LogFileData::$modifiedAt` è `int` non nullable, `DownloadLogFileAction::execute()`
  ritorna `BinaryFileResponse`, ecc.). Rimossa l'asserzione ridondante, tenute quelle che verificano un valore vero.
- **`Response::getFile()` non esiste (2 occorrenze)** — non era un metodo mancante: `$response->baseResponse` è
  tipizzato `Symfony\Component\HttpFoundation\Response` (la classe base), mentre `getFile()` vive solo su
  `BinaryFileResponse`. Pest `expect()->toBeInstanceOf()` non restringe il tipo per PHPStan (a differenza di
  PHPUnit `assertInstanceOf`, il cui bridge `phpstan/phpstan-phpunit` non è installato). Fix con una vera guardia
  `if (! $x instanceof BinaryFileResponse) { $this->fail(...); }` prima di chiamare `getFile()`.
- **Mockery return-type sbagliato (7 occorrenze)** — `Mockery::mock(UserContract::class, Authenticatable::class)`
  viene tipizzato da PHPStan come semplice `Mockery\MockInterface`, non come l'interfaccia passata. Visto che
  `UserContract` estende già `Authenticatable`, un solo mock basta; annotato con
  `/** @var Mockery\MockInterface&UserContract $user */` subito dopo `Mockery::mock()`, convenzione già in uso in
  tutto il repo (verificata con grep su altri moduli), non un modo per forzare un tipo diverso da quello reale.
- **`theCodingMachineSafe.function` (7 occorrenze, 3 file)** — `touch()`, `realpath()`, `symlink()` senza
  `use function Safe\...`. Per `touch()`/`realpath()` senza fallback e' bastato l'import. Per `symlink()`, usato con
  pattern `if (! @symlink(...)) { $this->markTestSkipped(...); }` (l'ambiente potrebbe non supportare i link
  simbolici), la variante Safe lancia eccezione invece di ritornare `false`: riscritto in `try { symlink(...); }
  catch (Safe\Exceptions\FilesystemException) { $this->markTestSkipped(...); }`.
- **`argument.type` su `array_map`** — `ListLogFilesActionTest.php` assegnava a `$this->paths` (proprietà dinamica
  Pest) una closure con parametro nativo `array $files`; un PHPDoc `@param list<LogFileData>` sopra
  `$this->paths = function(...)` non viene agganciato dal parser PHPStan/Pest al nodo Closure (stesso limite già
  noto per `@return` su `TestCaseDynamicPropertyTypeExtension`). Sostituita con una funzione di livello superiore
  `listedLogFilePaths(array $files): array` (stesso pattern già usato da `treeLogFile()` in
  `BuildLogFileTreeActionTest.php`), con PHPDoc `@param`/`@return` regolarmente rispettato su una funzione
  top-level.

Verifica: `./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1` → 0 errori. 68 test Pest del modulo
(`tests/Unit/Actions/Log/*`, `tests/Feature/Filament/LogDownloadPageTest`, `LogViewerPageTest`) tutti verdi
(217 assertion). Pint eseguito solo sui file toccati (mai `--dirty` su questo repo condiviso).

File toccati (solo test, nessun codice applicativo):
`tests/Feature/Filament/LogDownloadPageTest.php`, `tests/Feature/Filament/LogViewerPageTest.php`,
`tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php`, `tests/Unit/Actions/Log/BuildLogFileTreeActionTest.php`,
`tests/Unit/Actions/Log/BuildLogViewerStateActionTest.php`, `tests/Unit/Actions/Log/DownloadLogFileActionTest.php`,
`tests/Unit/Actions/Log/ListLogFilesActionTest.php`, `tests/Unit/Actions/Log/ParseAndFilterLogEntriesActionTest.php`,
`tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php`.

## GitHub (tracciamento)

Il tracciamento sta nel repo Quaeris (il bisogno nasce lì) e nella root. L'implementazione è in `module_activity_fila5`.

| Risorsa | Ruolo | Link |
|---|---|---|
| Issue (modulo Quaeris) | lavoro tracciabile | https://github.com/laraxot/module_quaeris_fila5/issues/49 |
| Issue (root, mirror) | mirror | https://github.com/laraxot/base_quaeris_fila5/issues/204 |
| Discussion (root) | scelte e domande per il team | https://github.com/laraxot/base_quaeris_fila5/discussions/205 |
