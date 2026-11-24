---
title: "NotifyTheme\\Get — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\NotifyTheme\\Get"
qmd: "Get NotifyTheme tema notifica firstOrCreate traduzioni subject body_html logo view_params"
---

# NotifyTheme\Get

Recupera o crea il tema di notifica (`NotifyTheme`) per tipo, lingua e tipo di post, popolandolo dalle traduzioni al primo accesso.

## Input

- `string $name`: tipo di post (`post_type`).
- `string $type`: canale (`email`, `pdf`, ...).
- `array $view_params`: `post_id` (default 0), `lang` (default locale), `body_html` opzionale.

## Output

- `NotifyThemeData`: `from_email`, `from`, `subject` e `body_html` con i placeholder `##chiave##` sostituiti, `view_params` con `logo`, `now`, `body_html`.

## Invarianti

- `NOTIFY-THEMEGET-INV-1`: la riga e' cercata con `firstOrCreate` su `(lang, type, post_type, post_id)`. Test: `tests/Unit/Actions/NotifyTheme/GetTest.php` (dedicato, asserti non verificati).
- `NOTIFY-THEMEGET-INV-2`: `subject`, `theme` (default `ark`) e `body_html` vengono scritti solo se `null`, dalle traduzioni `<modulo>::<tipo>.<nome>.*`. Stesso test.
- `NOTIFY-THEMEGET-INV-3`: se la traduzione manca e `body_html` e' nei parametri, il corpo diventa `##body_html##`. Stesso test.
- `NOTIFY-THEMEGET-INV-4`: `view_params` viene salvato solo se la colonna e' vuota. Stesso test.
- `NOTIFY-THEMEGET-INV-5`: il logo: con tema `empty` viene costruito un tag `<img>` da `logo.path/width/height`, altrimenti usa `logo` cosi' com'e'. Stesso test.

## Effetti collaterali

- Lettura e scrittura su `notify_themes` (insert alla prima chiamata, update per campi null, update di `view_params` se vuoto).
- Nessuna coda, nessun invio.

## Errori

- Nessuna eccezione propria. Un tema di tipo `pdf` o `email` con traduzione assente salva la chiave di traduzione come testo (`trans` restituisce la chiave).

## Non fa

- Non valida `lang`.
- Non sovrascrive i campi gia' valorizzati: un cambio di traduzione non si propaga a temi esistenti.
