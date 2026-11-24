---
title: "SendPushWithTemplateAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushWithTemplateAction"
qmd: "SendPushWithTemplateAction push template ticket placeholder variabili sostituzione"
---

# SendPushWithTemplateAction

Invia una push usando un template predefinito in codice (tre template `ticket_*`), con sostituzione di variabili.

## Input

- `string $templateId`: uno tra `ticket_created`, `ticket_updated`, `ticket_resolved`.
- `list<string> $tokens`, `array $variables`.

## Output

- `array<string, array>`: esito di `SendPushToDevicesAction`.

## Invarianti

- `NOTIFY-PUSHTPL-INV-1`: template sconosciuto lancia `Exception("Template <id> not found")`. Test: `tests/Unit/NotifyHighestMissCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHTPL-INV-2`: il campo `data` del template diventa il payload dati della push (default `[]`). Test: nessuno dedicato verificato.
- `NOTIFY-PUSHTPL-INV-3`: la sostituzione cerca `{{chiave}}` (righe 80-81).

## Effetti collaterali

- Invio tramite `SendPushToDevicesAction` (vedi la sua scheda).

## Errori

- `Exception` per template mancante. Errori di `PushNotificationData::from` propagano.

## Bug rilevato (da correggere, non corretto qui)

- I template usano `{ticket_title}` (righe 48, 53, 58) con una sola graffa, mentre la sostituzione cerca `{{ticket_title}}` (righe 80-81). Il titolo e il corpo arrivano alla push con il segnaposto non sostituito.

## Non fa

- Non legge template da database o file: solo array in codice.
