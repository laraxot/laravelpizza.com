---
title: "GetViewAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetViewAction"
qmd: "GetViewAction vista nome risolto pub_theme modulo percorso file panels actions home acts admin"
---

# GetViewAction

Risolve il nome della vista Blade da un file o dal chiamante, con priorità al tema pubblico. Codice: `app/Actions/GetViewAction.php` (classe a riga 15, `execute()` a riga 23).

## Input

- `string $tpl = ''`: suffisso opzionale di vista.
- `string $file0 = ''`: percorso del file; se vuoto si usa il chiamante.

## Output

- `view-string`: nome della vista esistente.

## Invarianti

- `GET-VIEW-INV-1` — Se esiste `pub_theme::<percorso>[.tpl]` viene restituita quella. Test: nessuno diretto (`tests/Arch/debt.php` cita la classe: non è un test).
- `GET-VIEW-INV-2` — Altrimenti `<modulo minuscolo>::<percorso>[.tpl]`, con la struttura `Modules/<M>/app/...` attesa dagli indici fissi. Test: nessuno.
- `GET-VIEW-INV-3` — Per `panels.actions.` il percorso è riscritto su `home.acts.` (admin se `inAdmin()`) e `-action` è rimosso. Test: nessuno.
- `GET-VIEW-INV-4` — Se la vista non esiste, `\Exception('View [...] not found')`. Test: nessuno.

## Effetti collaterali

Nessuno: solo `view()->exists()`.

## Errori

- `\Exception` se la vista non è trovata.

## Non fa

- Dipende da indici fissi sul percorso (`$arr[1]`, `$arr[4]`): un file fuori dalla struttura prevista produce un nome sbagliato.
