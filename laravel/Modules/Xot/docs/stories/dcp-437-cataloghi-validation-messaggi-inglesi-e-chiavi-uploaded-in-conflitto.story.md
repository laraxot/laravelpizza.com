---
title: "DCP-437: cataloghi validation con messaggi inglesi e chiavi `uploaded` in conflitto"
type: story
status: ready-for-dev
module: Xot
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, xot, i18n, validation, lang]
qmd: "validation lang xot it de es english leftovers uploaded conflitto after_or_equal dimensions in_array present"
related:
  - ../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md
  - ../../../Fixcity/docs/stories/dcp-419-testo-del-limite-allegati-distingue-foto-e-pdf.story.md
---

# DCP-437: cataloghi validation con messaggi inglesi e chiavi `uploaded` in conflitto

## Richiesta (verbatim)

«crea tutte le bmad stories». Vincolo permanente dell'utente: il sito e' multilingua, mai frasi in una lingua sola nel codice.

## Evidenza (grep di oggi, 2026-10-27)

Messaggi ancora in inglese in `Modules/Xot/lang`:

| chiave | it | de | es |
|--------|----|----|----|
| `after_or_equal` | inglese (riga 9) | inglese (riga 9) | inglese (riga 9) |
| `before_or_equal` | inglese (riga 15) | inglese (riga 15) | inglese (riga 15) |
| `dimensions` | inglese (riga 29) | inglese (riga 29) | tradotto |
| `in_array` | inglese (riga 37) | inglese (riga 37) | tradotto |
| `present` | inglese (riga 64) | inglese (riga 57) | tradotto |

Chiavi `uploaded` con testi diversi in piu' cataloghi:

- `Modules/Xot/lang/it/validation.php:84`: frase intera sul file troppo grande (quella che il sito usa; la prova e' `ValidationMessagesTest`, 119 test passati oggi insieme a `TicketFormImagesLangTest`).
- `Modules/User/lang/it/validation.php:119`: «Il campo :attribute non è riuscito a caricare.»
- `Modules/Fixcity/lang/it/validation.php:128`: «:attribute non è stato caricato.»
- `Modules/User/lang/en/validation.php:51` (annidata) e `Modules/Xot/lang/en/validation.php:76`: «The :attribute failed to upload.»

**Non provato**: quali di queste chiavi nessun codice legge. Il rilievo del revisore e' che il gruppo globale `validation` non passa per il namespace `fixcity::`; va verificato con grep dei chiamanti prima di cancellare qualunque riga.

Attenzione: questi file e `ValidationMessagesTest.php` sono toccati anche da un'altra sessione (2026-10-27, 17:38). Lavorare per chiave, rileggere prima di scrivere.

## Acceptance criteria

1. Le cinque chiavi dell'elenco sono tradotte in it e de, le due `*_or_equal` anche in es, senza parole inglesi.
2. Ogni chiave `uploaded` che nessun codice legge e' rimossa o allineata; quelle lette restano con un solo testo per lingua.
3. `ValidationMessagesTest` copre le chiavi nuove con `app('translator')->hasForLocale(...)` (con `fallback_locale = it` un `trans()` da solo non scopre una chiave mancante in de ed es).
4. I messaggi gia' verificati (`uploaded`, `file`, `distinct`, `mimetypes`) non cambiano.

## Tasks

- [ ] Grep dei chiamanti di ogni chiave `uploaded` e annotare l'esito qui.
- [ ] Tradurre le chiavi, rimuovere o allineare le morte.
- [ ] Estendere il test ed eseguirlo con `pest-scratch-db.sh` (le chiavi mancanti scrivono nel database di Lang, vedi [DCP-436](../../../Lang/docs/stories/dcp-436-traduttore-registra-le-chiavi-dinamiche-di-validation-attributes.story.md)).

## Owned file scope

`laravel/Modules/Xot/lang/{it,de,es}/validation.php`, `laravel/Modules/User/lang/{it,en}/validation.php`, `laravel/Modules/Fixcity/lang/it/validation.php`, `laravel/Modules/Xot/tests/Unit/ValidationMessagesTest.php`.

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 | Claude | stesura | nessun lavoro avviato |
