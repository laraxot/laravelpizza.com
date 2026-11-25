---
title: "UpdateModelSubtitleFieldAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Subtitle\\UpdateModelSubtitleFieldAction"
qmd: "UpdateModelSubtitleFieldAction salva testo sottotitoli su campo modello update fillable"
---

# UpdateModelSubtitleFieldAction

Estrae il testo di un sottotitolo e lo salva in un campo del modello. Codice: `app/Actions/Subtitle/UpdateModelSubtitleFieldAction.php:13-25`.

## Input

- `Model $model`: il modello da aggiornare.
- `string $filePath`: file XML di sottotitoli.
- `string $fieldName = 'txt'`: campo di destinazione.

## Output

- `Model`: lo stesso modello dopo `update()`.

## Invarianti

- **UPDATE-MODEL-SUBTITLE-FIELD-INV-1** — Il valore salvato è quello restituito da `ExtractSubtitlePlainTextAction`.
  Test: `tests/Unit/Actions/Subtitle/SubtitleTextActionsTest.php:46`.

## Effetti collaterali

- Un `UPDATE` sul modello tramite `update()` (eventi Eloquent inclusi).

## Errori

- Le eccezioni di `ExtractSubtitlePlainTextAction` si propagano.

## Non fa

- Se `$fieldName` non è `$fillable` il valore è scartato in silenzio, oppure lancia se `preventSilentlyDiscardingAttributes` è attivo (dipende dal modello, non verificato qui).
- Non controlla `$fieldName`.
