---
title: "BuildMailMessageAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\BuildMailMessageAction"
qmd: "BuildMailMessageAction MailMessage tema notifica subject view notify::email allegati decodeRichText"
---

# BuildMailMessageAction

Costruisce un `MailMessage` Laravel a partire dal tema di notifica risolto da `NotifyTheme\Get`. Non invia nulla.

## Input

- `string $name`: nome del tipo di post del tema (es. codice template).
- `Model $model`: sorgente dei parametri (`toArray()` unito a `$view_params`, che vincono).
- `array $view_params`: parametri extra per la vista.
- `?array $attachments`: lista di oggetti con `path`, `as`, `mime` (vedi riga 60).

## Output

- `MailMessage` con `from`, `subject`, vista `notify::email` e `view_params` contenente `body_html` e `subject` gia' decodificati.

## Invarianti

- `NOTIFY-BUILDMAIL-INV-1`: mittente = `view_params['from_email']` oppure `theme->from_email`; nome = `view_params['from']` oppure `theme->from`. Test: `tests/Unit/Actions/BuildMailMessageActionTest.php` (file dedicato, asserti per invariante non verificati).
- `NOTIFY-BUILDMAIL-INV-2`: subject = `view_params['subject']` oppure `theme->subject`, poi passato a `decodeRichText`. Stesso test.
- `NOTIFY-BUILDMAIL-INV-3`: `decodeRichText` applica `html_entity_decode` (ENT_QUOTES | ENT_HTML5); se il risultato non e' UTF-8 valido o contiene `Ã`/`Â` lo riconverte da ISO-8859-1. Test: nessuno dedicato verificato.
- `NOTIFY-BUILDMAIL-INV-4`: ogni allegato viene aggiunto con `attach($path, ['as', 'mime'])`, nell'ordine ricevuto. Test: nessuno dedicato verificato.

## Effetti collaterali

- Chiama `app(Get::class)->execute($name, 'email', $view_params)`, che puo' creare (`firstOrCreate`) e aggiornare un record `NotifyTheme` (vedi [notify-theme-get](notify-theme-get.md)).
- Nessuna scrittura diretta, nessuna coda, nessun servizio esterno.

## Errori

- Nessuna eccezione propria. Un allegato senza proprieta' `path`/`as`/`mime` produce un errore PHP al momento dell'accesso.

## Non fa

- Non invia la mail e non valida indirizzi.
- Non controlla che `$attachments[i]->path` esista su disco.
