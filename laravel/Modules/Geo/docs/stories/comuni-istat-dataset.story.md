---
type: story
slug: comuni-istat-dataset
title: "Elenco completo dei comuni italiani per le select dell'indirizzo"
status: done
owner: Geo
created: 2026-11-10
updated: 2026-11-10
---

# Elenco completo dei comuni italiani per le select dell'indirizzo

## Problema

`resources/json/comuni.json` contiene 4 comuni di prova. Region, Province e Locality ne ricavano le opzioni di
Regione, Provincia, Comune e CAP dell'indirizzo (AddressForm). Risultato:
- si potevano scegliere solo Lombardia e Sicilia (piu' una voce duplicata con le virgolette);
- in Roosko un cliente non poteva registrare un cantiere in Emilia-Romagna.

Con dati completi la select del Comune andava poi in 500: `cap` e' una lista e Sushi inseriva un array
("Array to string conversion").

## Correzione

- **`resources/json/comuni-istat.json`**:
  - 7.904 comuni;
  - fonte ISTAT, formato di [matteocontrini/comuni-json](https://github.com/matteocontrini/comuni-json): `regione` e `provincia` come `{codice, nome}`, `cap` come lista.
- **`GetItalianMunicipalitiesPathAction`**:
  - usa il file completo se c'e', altrimenti `comuni.json`;
  - `comuni.json` resta per Comune e per i test che si aspettano il campione.
- **Locality**: salva i CAP come JSON (cast `array` in lettura).
- **Region, Province, Locality**:
  - cache Sushi su file, legata al file dei comuni;
  - senza la cache, ogni richiesta rileggeva 1,9 MB e reinseriva 7.904 righe in memoria.
- **`lang/{it,en}/address_form.php`**: etichette vere (Regione, Provincia, Comune, CAP, Via o piazza, Numero civico) al posto di quelle uguali al nome del campo.

## Da verificare

- La licenza dei dati ISTAT (CC BY) chiede l'attribuzione: citata qui e nel docblock dell'action.
- Aggiornare il file quando ISTAT pubblica variazioni dei comuni (fusioni, nuovi CAP).
