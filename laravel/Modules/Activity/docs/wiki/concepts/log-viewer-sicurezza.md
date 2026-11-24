---
title: "Lettura dei log dal pannello — come funziona e cosa garantisce"
description: "La catena Action che porta un file di storage/logs dentro il pannello, e le tre cose che impediscono a un utente del pannello di leggere qualunque file del server."
document_type: concept
module: Activity
status: active
language: it-IT
created: 2026-11-19
updated: 2026-11-19
tags: [activity, log, sicurezza, path-traversal, filament, folio]
related:
  - ../../stories/phpstan-log-tests-false-positives.story.md
issues:
  - "https://github.com/laraxot/base_quaeris_fila5/issues/227"
---

# Lettura dei log dal pannello

Serve a leggere `storage/logs` da dentro il pannello, dove non c'e' accesso SSH o FTP.
E' **sola lettura**: nessuna Action scrive, rinomina o cancella un file.

## La catena

| Chi | Che cosa fa |
|-----|-------------|
| `Filament\Pages\LogViewer` | tiene solo la scelta dell'utente: file, livello, ricerca, finestra, cartelle aperte |
| `AuthorizeLogAccessAction` | **chi** puo' leggere |
| `ListLogFilesAction` | elenca i `.log` sotto la cartella base, ricorsivo |
| `BuildLogFileTreeAction` | ne costruisce l'albero per la colonna di sinistra |
| `ResolveLogDirectoryAction` | percorso reale della cartella base (`storage/logs` salvo diversa indicazione) |
| `ResolveLogFilePathAction` | **quale** file, e la sola traduzione da input utente a percorso su disco |
| `ReadLogTailAction` | legge la **coda** del file, mai il file intero |
| `ParseLogEntriesAction` / `FilterLogEntriesAction` | righe → voci, filtro per livello e testo |
| `BuildLogViewerStateAction` | mette insieme lo stato di un render |
| `DownloadLogFileAction` | risposta di download in streaming (`BinaryFileResponse`) |

Due ingressi, stessa catena: l'azione di intestazione della pagina Filament, e — dove c'e'
il modulo Cms — la pagina Folio `pages/api/log-download` montata su `/api` col middleware
`web`.

## Garanzia 1 — chi

`AuthorizeLogAccessAction` risponde `true` solo a un `UserContract` che ha il ruolo
`super-admin` oppure il permesso `log.viewAny`. Se il permesso non esiste ancora nel
database, `PermissionDoesNotExist` viene catturata e l'accesso e' **negato**, non concesso.

Il controllo non sta solo in `canAccess()` della pagina: e' ripetuto **dentro** la closure
dell'azione di download e all'inizio della pagina Folio. E' voluto. `canAccess()` nasconde
la voce di menu, ma un metodo pubblico di un componente Livewire resta richiamabile dal
client anche quando il pulsante non e' sullo schermo.

La pagina Folio risponde 403 a un utente non autenticato invece di reindirizzare a una
rotta di login che in questo progetto potrebbe non esistere.

## Garanzia 2 — quale file

`ResolveLogFilePathAction::execute()` e' l'unico punto che costruisce un percorso da input
dell'utente. Nell'ordine:

1. percorso vuoto o con byte nullo (`\0`) → rifiutato;
2. estensione diversa da `.log` **sull'input** → rifiutato;
3. `realpath($base . '/' . $relativePath)`: risolve `..` e i link simbolici; se il percorso
   non esiste o non e' un file → rifiutato;
4. il percorso **risolto** deve iniziare con `$base . DIRECTORY_SEPARATOR` → altrimenti
   rifiutato. Il separatore nel confronto non e' un dettaglio: senza, una cartella
   `/var/log-altro` passerebbe il controllo per base `/var/log`;
5. estensione `.log` ricontrollata **sul percorso risolto** → un link simbolico chiamato
   `finto.log` che punta a `note.txt` non passa.

Conseguenze, tutte coperte da `tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php`:

- `../secret.log` e `reports/../../secret.log` → `InvalidLogFileException`;
- un percorso assoluto (`/etc/passwd`, o il percorso reale di un file che esiste davvero
  fuori dalla base) → rifiutato: diventa `base//etc/passwd`, che `realpath()` non risolve;
- `note.txt`, `non-esiste.log`, una cartella, la stringa vuota, `laravel.log\0.txt` →
  rifiutati;
- un link simbolico dentro la cartella dei log che punta fuori → rifiutato al punto 4;
- `ListLogFilesAction` ripete il controllo di contenimento sul `realPath()` di ogni file
  trovato dal Finder, cosi' un file raggiunto per link simbolico non compare neppure
  nell'elenco.

`LogViewer::selectFile()` accetta qualunque stringa dal client **apposta**: il valore non
e' fidato e viene ricontrollato a ogni lettura. `BuildLogViewerStateAction` restituisce un
errore generico che **non riporta il percorso richiesto** (c'e' un test che lo verifica) e
lascia disponibile l'elenco dei file, cosi' l'utente puo' sceglierne un altro.

## Garanzia 3 — quanto

`ReadLogTailAction` legge solo la coda del file, entro `MAX_BYTES`, e scarta la prima riga
parziale; i byte non validi UTF-8 vengono ripuliti, cosi' un log sporco non rompe la
pagina. Un `laravel.log` da gigabyte non viene mai caricato in memoria.

Il download usa `BinaryFileResponse`, che legge dal disco a blocchi: a differenza di un
download Livewire, che leggerebbe il file intero e lo codificherebbe in base64.

Nell'albero il nome del file e' testo, mai HTML, e il percorso passato a `wire:click` e'
codificato: `<u>x.log` e `it's.log` hanno un test dedicato.

## Se si tocca questa catena

I test in `tests/Unit/Actions/Log/` e in `tests/Feature/Filament/` lavorano tutti in una
cartella temporanea dentro `storage/framework/testing` — mai in `storage/logs` — e ognuno
piazza un file **fuori** dalla cartella base per provare che non sia raggiungibile. Se una
modifica rende verde un test togliendo quel file esca, la modifica e' sbagliata.

Nessuna segnalazione dell'analizzatore statico e' un buon motivo per allentare i punti
1–5: nel giro di correzioni della issue #227 le segnalazioni che cadevano qui sopra erano
tutte di tipizzazione dei test, nessuna riguardava la risoluzione del percorso.
