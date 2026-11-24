---
title: "GetTransKeyByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trans\\GetTransKeyByModelClassAction"
qmd: "GetTransKeyByModelClassAction chiave traduzione modello modulo snake suffisso fields lang namespace Trans"
---

# GetTransKeyByModelClassAction

Costruisce la chiave di traduzione `modulo::modello{suffisso}` per una classe modello.

Codice: `app/Actions/Trans/GetTransKeyByModelClassAction.php:11-30`.

## Input

- `string $model_class`.
- `string $suffix`: concatenato così com'è (es. `.fields`).

## Output

`string`: `{modulo_minuscolo}::{modello_snake}{suffisso}`.

## Invarianti

- `TRANS-KEY-INV-1`: il modulo viene da `GetModuleNameByModelClassAction` in minuscolo; il modello è `class_basename` in snake (righe 20-23). Test: Nessun test dedicato.
- `TRANS-KEY-INV-2`: il suffisso è aggiunto senza normalizzazione (riga 25). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Le eccezioni di `GetModuleNameByModelClassAction` si propagano.

## Non fa

- Il modello non è pluralizzato (commento `str_plural ?` non implementato): diverso da `PdfByModelAction` che usa la stessa classe.
- Esiste una classe con lo stesso nome in `Actions/Model/` (fuori perimetro, non confrontata): il nome file usa il prefisso di sottopercorso.
- Il docblock è un segnaposto (`---.`).
