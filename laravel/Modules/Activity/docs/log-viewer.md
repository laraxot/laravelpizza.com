---
title: "Activity: lettura dei log dal pannello (come funziona e cosa garantisce)"
type: concept
status: active
module: Activity
created: 2026-11-19
updated: 2026-11-25
qmd: "activity log viewer sicurezza lettura pannello storage logs path traversal realpath download folio AuthorizeLogAccessAction GetLogFilePathAction ReadLogTailAction"
related:
  - ./actions.md
  - ./adr/0003-log-viewer-single-path-resolver.md
  - ./contracts/get-log-file-path-action.md
  - ./contracts/authorize-log-access-action.md
  - ./contracts/download-log-file-action.md
---

# Lettura dei log dal pannello

Serve a leggere `storage/logs` da dentro il pannello, dove non c'e' accesso SSH o FTP. E' **sola lettura**: nessuna Action scrive, rinomina o cancella un file. Fatti verificati sul codice il 2026-11-25.

## La catena

| Chi | Che cosa fa |
|---|---|
| `Filament\Pages\LogViewer` | tiene solo la scelta dell'utente: file, livello, ricerca, finestra, cartelle aperte |
| `AuthorizeLogAccessAction` | **chi** puo' leggere |
| `ListLogFilesAction` | elenca i `.log` sotto la cartella base, ricorsivo, massimo 1000 |
| `BuildLogFileTreeAction` | ne costruisce l'albero per la colonna di sinistra |
| `GetLogDirectoryAction` | percorso reale della cartella base (`storage/logs` salvo diversa indicazione) |
| `GetLogFilePathAction` | **quale** file: la sola traduzione da input utente a percorso su disco |
| `ReadLogTailAction` | legge la **coda** del file, mai il file intero |
| `ParseLogEntriesAction` / `FilterLogEntriesAction` | righe a voci, filtro per livello e testo |
| `BuildLogViewerStateAction` | mette insieme lo stato di un render (`LogViewerStateData`) |
| `DownloadLogFileAction` | risposta di download in streaming (`BinaryFileResponse`) |

Due ingressi, stessa catena: l'azione di intestazione `download` della pagina Filament e la pagina Folio `resources/views/pages/api/log-download.blade.php`, che risponde a `GET /api/log-download?file=<percorso relativo>` quando il modulo che possiede Folio la monta (Activity non monta Folio da solo, vedi [la story](./bmad/stories/folio-routing-centralization.story.md)). La pagina Filament si chiama `LogViewer`, estende la `XotBasePage` standalone, mostra le voci dell'etichetta `activity::log_viewer.*` e apre per default `laravel.log` se esiste.

## Garanzia 1: chi

`AuthorizeLogAccessAction` risponde `true` solo a un `UserContract` con il ruolo `super-admin` oppure il permesso `log.viewAny`. Se il permesso non esiste ancora nel database, `PermissionDoesNotExist` e' catturata e l'accesso e' **negato**, non concesso.

Il controllo non sta solo in `canAccess()`: e' ripetuto **dentro** la closure dell'azione di download (`abort_unless(..., 403)`) e all'inizio della pagina Folio. E' voluto: `canAccess()` nasconde la voce di menu, ma un metodo pubblico di un componente Livewire resta richiamabile dal client anche quando il pulsante non e' sullo schermo. La pagina Folio risponde 403 a un utente non autenticato invece di reindirizzare a una rotta di login che potrebbe non esistere; per un file non valido risponde 404.

## Garanzia 2: quale file

`GetLogFilePathAction::execute()` e' l'unico punto che costruisce un percorso da input dell'utente ([ADR 0003](./adr/0003-log-viewer-single-path-resolver.md)). Nell'ordine:

1. percorso vuoto o con byte nullo (`\0`): rifiutato;
2. estensione diversa da `.log` **sull'input**: rifiutato;
3. `realpath($base . '/' . $relativePath)` risolve `..` e link simbolici; se il percorso non esiste o non e' un file: rifiutato;
4. il percorso **risolto** deve iniziare con `$base . DIRECTORY_SEPARATOR`: il separatore nel confronto non e' un dettaglio, senza una cartella `/var/log-altro` passerebbe il controllo per base `/var/log`;
5. estensione `.log` ricontrollata **sul percorso risolto**: un link simbolico `finto.log` che punta a `note.txt` non passa.

Conseguenze, coperte da `tests/Unit/Actions/Log/GetLogFilePathActionTest.php`:

- `../secret.log` e `reports/../../secret.log`: `InvalidLogFileException`;
- un percorso assoluto, anche se punta a un file che esiste davvero fuori dalla base: rifiutato (diventa `base//etc/passwd`, che `realpath()` non risolve);
- `note.txt`, `non-esiste.log`, una cartella, la stringa vuota, `laravel.log\0.txt`: rifiutati;
- un link simbolico dentro la cartella dei log che punta fuori: rifiutato al punto 4;
- `ListLogFilesAction` ripete il controllo di contenimento sul `realPath()` di ogni file trovato dal Finder, cosi' un file raggiunto per link simbolico non compare neppure nell'elenco.

`LogViewer::selectFile()` accetta qualunque stringa dal client **apposta**: il valore non e' fidato e viene ricontrollato a ogni lettura. `BuildLogViewerStateAction` restituisce un errore generico (`activity::log_viewer.messages.file_unavailable`) che **non riporta il percorso richiesto** (c'e' un test) e lascia disponibile l'elenco, cosi' l'utente puo' sceglierne un altro.

## Garanzia 3: quanto

`ReadLogTailAction` legge solo la coda del file: finestra di 256 KiB per default, selezionabile tra 128 KB e 4096 KB (`BuildLogViewerStateAction::WINDOW_OPTIONS_KB`), con minimo 1 KiB e massimo 4 MiB per richiesta. Scarta la prima riga se parziale e ripulisce i byte non UTF-8 (`mb_scrub`): un `laravel.log` da gigabyte non viene mai caricato in memoria. Ricerca e filtri valgono solo sulla parte letta; per cercare nell'intero file servirebbe una ricerca a blocchi (non esiste).

Le voci mostrate sono al massimo 200 per volta, le piu' recenti prima (`FilterLogEntriesAction::DEFAULT_LIMIT`), senza paginazione. Il livello e' uno di `LogLevelEnum`: EMERGENCY, ALERT, CRITICAL, ERROR, WARNING, NOTICE, INFO, DEBUG.

Il download usa `BinaryFileResponse`, letto a blocchi dal disco: a differenza di un download Livewire, che leggerebbe il file intero e lo codificherebbe in base64. Nell'albero il nome del file e' testo, mai HTML, e il percorso passato a `wire:click` e' codificato: `<u>x.log` e `it's.log` hanno un test dedicato in `tests/Feature/Filament/LogViewerPageTest.php`.

## Se si tocca questa catena

I test in `tests/Unit/Actions/Log/` e in `tests/Feature/Filament/` (`LogViewerPageTest`, `LogDownloadPageTest`) lavorano in una cartella temporanea dentro `storage/framework/testing`, mai in `storage/logs`, e ognuno piazza un file **fuori** dalla cartella base per provare che non sia raggiungibile. Se una modifica rende verde un test togliendo quel file esca, la modifica e' sbagliata. Nessuna segnalazione dell'analizzatore statico e' un buon motivo per allentare i punti 1-5: nel giro di correzioni PHPStan sui test dei log le segnalazioni erano tutte di tipizzazione dei test, nessuna riguardava la risoluzione del percorso (vedi la story [phpstan-log-tests-false-positives](./stories/phpstan-log-tests-false-positives.story.md)).

Permessi: il ruolo `super-admin` basta; per altri utenti serve creare e assegnare il permesso `log.viewAny` (il modulo non lo crea).
