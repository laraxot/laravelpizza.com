---
title: "ADR — Il limite di upload annunciato e' il minimo tra PHP, Livewire e campo, letto nella richiesta web"
type: decision
module: Media
tags: [adr, media, upload, livewire, php, limiti]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Actions/Upload/GetEffectiveUploadLimitAction.php
  - ../../app/Filament/Pages/SettingPage.php
qmd: "effective upload limit web request limite"
---

# ADR: il limite di upload annunciato e' il minimo tra PHP, Livewire e campo, letto nella richiesta web

## Contesto

- Su un upload Livewire si sommano tre limiti: PHP (`upload_max_filesize`, `post_max_size`), la regola Livewire
  `temporary_file_upload.rules` (`max:12288` KB se nulla) e il `maxSize()` del campo. Vince il piu' piccolo.
- Una foto da fotocamera (3-15 MB) falliva con `validation.uploaded` (422) perche' il campo prometteva 10 MB e il PHP del web
  server ne accettava 2: il form non vedeva mai il file e l'utente non capiva perche'.
- Il PHP da CLI legge un `php.ini` diverso da FPM o dal server che riceve l'upload: un valore calcolato in un comando o in un
  test non e' quello vero.

Domanda: quale numero mostrare e far rispettare a campi e impostazioni?

## Decisione

- `GetEffectiveUploadLimitAction` restituisce in byte `min(PHP * 0,9, regola Livewire, campo)`: il 10% di margine copre
  l'involucro multipart (boundary e altri campi).
- Si chiama dentro la richiesta web: oggi `Filament/Pages/SettingPage.php` la usa come `maxValue` della dimensione massima
  degli allegati, cosi' un super-admin non puo' impostare piu' di quanto il server accetti.
- Nginx `client_max_body_size` non e' visibile da PHP: per le foto resta la riduzione nel browser
  (ADR [camera-photo-browser-resize-opt-in](camera-photo-browser-resize-opt-in.md)).

## Alternative scartate

- Usare il solo `maxSize()` del campo: e' la causa del difetto (promette piu' di quanto PHP accetti).
- Leggere `ini_get` una volta e scriverlo in config: vale per il processo che lo legge (spesso il CLI), non per FPM.
- Alzare i limiti del server: azione del proprietario dell'hosting, non del codice; non elimina la discrepanza quando cambiano.

## Conseguenze

- Pro: il numero mostrato e' quello che passa davvero; un solo punto di calcolo.
- Contro: il limite di nginx resta invisibile; se e' sotto quello di PHP, l'errore e' un 413 prima di PHP.
- Chi aggiunge un campo di upload con `maxSize()` grande deve limitarlo con questa Action, non con un numero scritto a mano.

## Verifica

- `Modules/Media/tests/Unit/Actions/Upload/GetEffectiveUploadLimitActionTest.php`: mai oltre PHP*0,9, margine multipart,
  limite del campo piu' piccolo rispettato, regola Livewire (array e stringa), default 12 MB.
