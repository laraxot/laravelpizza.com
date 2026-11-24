---
title: "Contratto — DownloadLogFileAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\DownloadLogFileAction"
qmd: "contract DownloadLogFileAction activity log download file BinaryFileResponse streaming storage logs ACT-LOGDL"
---

# DownloadLogFileAction

Risposta HTTP di download per un file di log scelto dall'utente. Il percorso passa da `ResolveLogFilePathAction`.

## Input

- `string $file`: percorso relativo a `storage/logs`, come da `ResolveLogFilePathAction`.

## Output

- `BinaryFileResponse`: download con nome file = percorso relativo con `/` sostituito da `_`, `Content-Type: text/plain; charset=UTF-8`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGDL-INV-1` | Un file fuori da `storage/logs`, non `.log` o inesistente non produce risposta: viene rilanciata `InvalidLogFileException`. | `DownloadLogFileActionTest.php` («refuses files outside the log directory…») |
| `ACT-LOGDL-INV-2` | La risposta è `BinaryFileResponse`: il file è letto a blocchi dal disco, non caricato in memoria. | `DownloadLogFileActionTest.php` («returns a streamed download…») verifica il tipo di risposta |
| `ACT-LOGDL-INV-3` | Il nome del download non contiene `/`. | Test: nessuno |

## Effetti collaterali

- Nessuna scrittura. Il file viene letto quando la risposta è inviata, non in questa Action.

## Errori

- `InvalidLogFileException`, propagata da `ResolveLogFilePathAction`.

## Non fa

- Non verifica l'autorizzazione: il chiamante (`LogViewer`, riga 128) usa `AuthorizeLogAccessAction`.
- Se il file sparisce tra la risoluzione e l'invio, il comportamento è quello di Symfony (non verificato).

