---
title: "DCP-436: il traduttore registra le chiavi dinamiche di `validation.attributes`"
type: story
status: ready-for-dev
module: Lang
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, lang, translator, livewire, upload, da-riprodurre]
qmd: "lang translator adapter notifyMissingKey validation attributes livewire upload firstOrCreate translations"
related:
  - ./lang-translation-writes-and-probes.story.md
  - ../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md
---

# DCP-436: il traduttore registra le chiavi dinamiche di `validation.attributes`

## Richiesta (verbatim)

«crea tutte le bmad stories»

## Origine

Rilievo di un revisore indipendente sulla story [mobile-camera-upload](../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md) (2026-10-27). Il percorso nel codice l'ho riletto io; l'effetto sul database no.

## Evidenza

- Livewire `WithFileUploads::_uploadErrored` (vendor, righe 90-94) chiede `validation.attributes.{nome del campo}` per costruire il messaggio; il nome interno di un allegato e' diverso per ogni file (`data.images.f<chiave>`).
- `Modules/Lang/app/Adapters/TranslatorAdapter.php`, `get()` (righe 38-47): se il risultato e' uguale alla chiave chiama `notifyMissingKey()`, senza filtri di gruppo o prefisso.
- `Modules/Lang/app/Actions/Translation/RecordMissingTranslationAction.php`: `Translation::firstOrCreate` con lingua, namespace, gruppo, voce.
- Osservato il 2026-10-27: 0 righe in `fixcity_data.translations`. Non ho verificato che sia la tabella del modello `Translation`.

**Non provato**: che un upload fallito crei una riga per file. Se la tabella ha 0 righe, o la registrazione non parte o non scrive li'. Va riprodotto prima di correggere.

La story [lang-translation-writes-and-probes](./lang-translation-writes-and-probes.story.md) (ready-for-dev) riguarda il writer su file e le sonde PHPStan; questa riguarda solo la registrazione nel database e non la sostituisce.

## Acceptance criteria

1. Una chiave `validation.attributes.<nome dinamico>` non crea righe in `translations`.
2. Le chiavi reali e mancanti si registrano ancora.
3. Un errore di scrittura su `translations` non trasforma una risposta 422 o 413 in un 500.
4. Il test nuovo fallisce prima della correzione.

## Tasks

- [ ] Riprodurre su database di prova (mai su quello di sviluppo): contare le righe, chiamare `trans('validation.attributes.data.images.fprova')` in it, riconteggiare.
- [ ] Se non scrive: capire perche' (tabella, connessione, modello) e chiudere la story con la causa.
- [ ] Se scrive: filtrare per prefisso in `notifyMissingKey()` o nell'Action, con `try/catch` e log.
- [ ] Test Pest in `Modules/Lang/tests` con `pest-scratch-db.sh`.

## Owned file scope

`laravel/Modules/Lang/app/Adapters/TranslatorAdapter.php`, `laravel/Modules/Lang/app/Actions/Translation/RecordMissingTranslationAction.php`, `laravel/Modules/Lang/tests/`. Fuori scope: il vendor Livewire.

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 | Claude | stesura | nessun lavoro avviato |
