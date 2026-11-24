---
title: "ADR — La visibilità dei media segue il record owner"
type: decision
status: accepted
module: Media
updated: 2026-11-24
---

# La visibilità dei media segue il record owner

## Contesto

Gli allegati possono essere temporanei, privati, condivisi o pubblici e non costituiscono un dominio autonomo.

## Decisione

Media valida e conserva file tramite i contratti del record ospitante; ownership e policy del dominio owner determinano la visibilità.

## Driver della decisione

- Evitare esposizione involontaria di dati allegati.

## Alternative scartate

- Rendere ogni upload pubblico per default.
- Delegare l'autorizzazione alla sola estensione MIME.

## Conseguenze

Gli allegati rispettano il contesto applicativo; ogni integrazione deve verificare ownership, MIME, dimensione e storage.

## Conferma

Verificare policy del record owner e test di upload e visibilità.

## Verifica

- `Modules/Media/app/Actions/SaveAttachmentsAction.php`: salva gli allegati sul record ospitante (`HasMedia`), non su un
  dominio Media autonomo.
- `Modules/Media/tests/Unit/MediaPolicyBehaviorTest.php`: le policy `Media` e `TemporaryUpload` decidono per permessi
  espliciti, con bypass solo per `super-admin`.
- Non esiste un test che provi la visibilità ereditata dal record owner (ownership, MIME, dimensione): da scrivere.
