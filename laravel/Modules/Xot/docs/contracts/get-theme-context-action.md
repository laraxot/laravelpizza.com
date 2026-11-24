---
title: "GetThemeContextAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Theme\\GetThemeContextAction"
qmd: "GetThemeContextAction contesto tematico stagione natale pasqua estate halloween calendario Carbon"
---

# GetThemeContextAction

Restituisce il contesto tematico della data corrente (natale, pasqua, estate, halloween, default). Codice: `app/Actions/Theme/GetThemeContextAction.php`.

## Input

- Nessuno. Usa `Carbon::now()` (fuso dell'applicazione).

## Output

- `string`: uno tra `christmas`, `easter`, `summer`, `halloween`, `default`.

## Invarianti

Priorità di valutazione: natale, pasqua, estate, halloween, poi default.

| ID | Regola | Test |
|---|---|---|
| `THEME-CTX-INV-1` | Dal 1 dicembre al 10 gennaio (inclusi) il risultato è `christmas`; ha priorità su tutti gli altri. | Test: nessuno |
| `THEME-CTX-INV-2` | Dal Venerdì Santo alla domenica di Pasqua il risultato è `easter`. Il calcolo della data usa l'algoritmo computus. Il Lunedì dell'Angelo non rientra: vedi Non fa. | Test: nessuno |
| `THEME-CTX-INV-3` | Dal 15 luglio al 31 agosto il risultato è `summer`. | Test: nessuno |
| `THEME-CTX-INV-4` | Dal 25 ottobre al 1 novembre il risultato è `halloween`. | Test: nessuno |
| `THEME-CTX-INV-5` | Fuori da questi intervalli il risultato è `default`. | Test: nessuno |

## Effetti collaterali

Nessuno. Legge solo l'orologio; nessuna scrittura, nessuna cache.

## Errori

- `getEasterDate()` lancia `\RuntimeException` se `Carbon::create` non restituisce un `Carbon` (caso non raggiungibile con anno valido).

## Non fa

- Bug: l'intervallo pasquale è `between($easter-2 giorni, $easter+1 giorno)` con orari a mezzanotte. Il Lunedì dell'Angelo alle ore diverse da 00:00:00 risulta fuori intervallo, quindi il contesto `easter` termina la domenica. Il confronto è inclusivo e l'intervallo è definito dai soli giorni; la data di Pasqua è calcolata correttamente.
- Non accetta una data come parametro: la data è sempre "adesso".
- Il commento `// Added` in testa al file non descrive alcun comportamento.
