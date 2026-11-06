---
title: "DCP-428: upload temporaneo, proprieta, MIME, pulizia e rollback"
type: story
status: ready-for-dev
module: Media
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, media, upload, sicurezza, test, medialibrary, livewire]
qmd: "media upload temporaneo ownership MIME reale finfo cleanup rollback saveRelationships orfani test contratto"
related:
  - ../bmad/stories/fix-mobile-camera-upload.story.md
  - ../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md
issues: []
discussions: []
---

# DCP-428: lato server dell'upload da fotocamera

## Origine

La story di supporto [fix-mobile-camera-upload](../bmad/stories/fix-mobile-camera-upload.story.md) elenca criteri lato server tutti non spuntati, e la story madre di Fixcity dichiara che «AC server (MIME reale, cleanup, rollback, ownership) non sono stati provati». La sessione che ha fatto il lato client ha provato 200 con foto ridotte, ma non cosa succede al file dopo l'upload.

## Acceptance criteria

1. **Proprieta'**: un file temporaneo e' legato alla sessione e all'utente autenticato; un altro utente non puo' collegarlo a una propria segnalazione. Prova: due account, il secondo usa il nome temporaneo del primo, e viene rifiutato.
2. **MIME reale**: il contenuto e' verificato lato server (`finfo`, estensione `fileinfo` presente), non solo il MIME dichiarato dal client. Casi: MIME vuoto, MIME contraffatto (un file di testo con `.jpg`), estensione sbagliata, HEIC normalizzato in JPEG.
3. **Whitelist invariata**: restano `image/jpeg`, `image/png`, `application/pdf`; nessun `image/*` indiscriminato.
4. **Pulizia**: i temporanei scaduti e le conversioni fallite non restano; si descrive come e quando vengono rimossi (Livewire e Media), dopo averlo verificato, non assunto.
5. **Rollback**: se il trasferimento o `saveRelationships()` fallisce, non restano media orfani ne' una segnalazione a meta'.
6. **Oversize**: un file oltre il limite produce un errore leggibile nella lingua della pagina (chiave `validation.uploaded` o equivalente), mai la frase inglese del framework.
7. Test automatici per i criteri 1, 2, 5 e 6 nel modulo Media o Fixcity (dove sta il punto di integrazione), con nomi che descrivono il comportamento.

## Tasks

- [ ] Individuare in Media e Fixcity il punto in cui il temporaneo diventa un `Media` (Livewire `TemporaryUploadedFile` e `SpatieMediaLibraryFileUpload` di `TicketForm`).
- [ ] Scrivere i test del criterio 7; far girare con `bashscripts/tools/pest-scratch-db.sh` (mai `DB_DATABASE=:memory:`: ha creato uno schema vero nel MariaDB di sviluppo il 2026-10-27).
- [ ] Correggere cio' che i test mostrano fallire, con il minimo cambiamento.
- [ ] PHPStan sui file toccati.
- [ ] Aggiornare la checklist della story di supporto con l'esito.

## Verifica richiesta

Output reale dei test su database isolato, per un caso fallito prima e passato dopo. Il criterio 4 richiede la lettura del codice o una prova su disco, con la data dei file.

## Owned file scope

`laravel/Modules/Media/` (azioni, regole), `laravel/Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php` solo per il collegamento, test dei due moduli.

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 | Claude | stesura | nessun lavoro avviato |
