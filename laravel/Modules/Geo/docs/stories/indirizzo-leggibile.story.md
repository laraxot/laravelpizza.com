---
type: story
slug: indirizzo-leggibile
title: "Geo: full_address con i nomi al posto dei codici ISTAT"
status: done
phase: DONE
owner: Geo
created: 2026-11-11
updated: 2026-11-11
---

# Geo: full_address con i nomi al posto dei codici ISTAT

## Perché

AddressForm salva i codici ISTAT di comune, provincia e regione, ma `full_address` li stampava così come sono:
nell'area clienti di Roosko il cantiere risultava «Viale delle Nazioni 12, 39014, 39, 48122». Lo stesso testo
andava anche al geocoding (`UpdateCoordinatesFromAddressAction`).

## Fatto

- `FormatAddressAction` restituisce «Viale delle Nazioni 12, 48122 Ravenna (RA)»:
  - il comune è preso da `Locality`;
  - la sigla della provincia arriva dal file ISTAT, con una mappa in cache legata alla data di modifica del file;
  - gli indirizzi scritti per nome (geocoding, import) restano com'erano.
- `Address::full_address` e `getFullAddress()` passano da questa action.

## Verifica

- `tests/Unit/Actions/Address/FormatAddressActionTest.php` copre due casi: codici ISTAT e indirizzo per nome.
- Nel contesto dell'app (tinker) l'indirizzo di prova esce come previsto.
- PHPStan 0.

Nell'harness la suite di Geo non gira: il `TestCase` di Geo cerca la connessione `fixcity`, problema
precedente a questa story.
