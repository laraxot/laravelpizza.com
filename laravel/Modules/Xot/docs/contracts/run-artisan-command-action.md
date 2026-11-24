---
title: "RunArtisanCommandAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\RunArtisanCommandAction"
qmd: "RunArtisanCommandAction esegue comando artisan Artisan::call output pre STDIN eccezione testo"
---

# RunArtisanCommandAction

Esegue un singolo comando artisan via facade e restituisce l'output avvolto in `<pre>`, oppure il messaggio dell'eccezione. Sostituisce `ArtisanService::exe()`. Codice: `app/Actions/Artisan/RunArtisanCommandAction.php:14-50`.

## Input

- `string $command`: nome del comando artisan (`execute`, riga 27).
- `array<string, bool|int|string|list<string>> $arguments`: argomenti del comando (riga 25).

## Output

- `string`: `[<pre>{output}</pre>]` in caso di successo, `[<pre>{messaggio}</pre>]` se è lanciata un'`Exception` (righe 34, 36).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-RUN-INV-1` | Prima di eseguire, se la costante `STDIN` non è definita, la definisce con `php://stdin`. Accade una sola volta per processo. | righe 29, 45-50 | Test: nessuno |
| `ARTISAN-RUN-INV-2` | Le `Exception` sono catturate e restituite come testo. Le `Error` e le altre `Throwable` non sono catturate. | righe 31-37 | Test: nessuno |
| `ARTISAN-RUN-INV-3` | Il codice di uscita del comando non è letto: un comando che fallisce senza eccezione viene riportato come output normale. | righe 32-34 | Test: nessuno |

## Effetti collaterali

Esecuzione del comando artisan (gli effetti dipendono dal comando). Definizione della costante globale `STDIN` con un handle `fopen` non chiuso esplicitamente. Nessuna transazione, nessuna coda.

## Errori

- `Exception` catturata e restituita come testo nel formato `[<pre>...</pre>]`.
- `Error` non catturata: si propaga.

## Non fa

- Non valida il nome del comando.
- Non escapa l'output: viene inserito raw dentro `<pre>`.
- Il docblock di `ensureStdin()` spiega che senza `STDIN` i comandi con conferma andrebbero in fatal in SAPI web.
- Marker `@contract` aggiunto nel docblock della classe.
