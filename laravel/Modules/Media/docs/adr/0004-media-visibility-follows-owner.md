---
status: accepted
module: Media
qmd: "media visibility follows owner visibilità segue"
title: "La visibilità dei media segue il record owner"
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
