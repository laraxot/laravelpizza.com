---
title: "Contratto — RecordMissingTranslationAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\Translation\\RecordMissingTranslationAction"
qmd: "RecordMissingTranslationAction traduzione mancante database firstOrCreate translator adapter namespace group item LANG-MISS"
---

# RecordMissingTranslationAction

Registra nel database una chiave di traduzione mancante. Codice: `app/Actions/Translation/RecordMissingTranslationAction.php:17-52`.

## Input

- `string $key`: `<namespace>::<gruppo>.<voce>`, oppure `<gruppo>.<voce>`, oppure `<gruppo>`.
- `string $locale`.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-MISS-INV-1` | Una riga per combinazione `(lang, namespace, group, item)`: `firstOrCreate` (righe 25-30). | Riferimenti in `LangCoverageBoostTest.php`, `LangCoverageGapsTest.php`, `LangHundredPercentCoverageTest.php`, `LangFinalGapsTest.php` (contenuto non letto). |
| `LANG-MISS-INV-2` | Senza `::` il namespace e' `*`; senza `.` l'`item` e' `null`. | Test: nessuno. |

## Effetti collaterali

- Una SELECT e, se assente, una INSERT sul modello `Translation`. Nessuna transazione.

## Errori

- Eccezioni del database si propagano.

## Non fa

- Non scrive nei file di lingua. Non traduce.
- Dubbio: `firstOrCreate` non e' atomico. Due richieste concorrenti possono creare duplicati se la tabella non ha un indice univoco su quelle colonne. Non verificato.
- Chiamante verificato: `Adapters/TranslatorAdapter.php`.
