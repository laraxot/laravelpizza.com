---
title: "RenderNotificationTemplateStringAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\RenderNotificationTemplateStringAction"
qmd: "RenderNotificationTemplateStringAction template placeholder doppie graffe escape data_get notifica"
---

# RenderNotificationTemplateStringAction

Sostituisce i segnaposto `{{ espressione }}` in una stringa di template con valori da un array.

## Input

- `string $template`: testo con segnaposto.
- `array $data`: valori; le chiavi annidate si leggono con notazione a punti (`data_get`).

## Output

- `string`: template con i segnaposto sostituiti. Se la regex non matcha restituisce il template originale.

## Invarianti

- `NOTIFY-RENDER-INV-1`: un'espressione che non rispetta `^\$?[A-Za-z_][A-Za-z0-9_]*(\.[A-Za-z0-9_]+)*$` viene lasciata intatta e loggata come warning. Test: `tests/Unit/Actions/RenderNotificationTemplateStringActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-RENDER-INV-2`: variabile assente o `null` viene resa come stringa vuota (warning solo per l'assente).
- `NOTIFY-RENDER-INV-3`: valori scalari o `Stringable` vengono escapati con `e()`. Stesso test.
- `NOTIFY-RENDER-INV-4`: valori non stampabili (array, oggetti) vengono resi vuoti con warning.

## Effetti collaterali

- Solo log di warning (`Log::warning`) nei casi sopra. Nessuna scrittura.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non esegue codice, filtri o helper nel template: solo lookup di chiave.
- Non gestisce il caso in cui `preg_replace_callback` fallisca: in quel caso restituisce il template originale senza segnalazione.
