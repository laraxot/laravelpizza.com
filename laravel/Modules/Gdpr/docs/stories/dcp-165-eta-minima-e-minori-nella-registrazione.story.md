---
id: dcp-165
title: "DCP-165: eta' minima e minori nella registrazione e nel linguaggio dell'informativa"
type: story
epic: dc-parity-v2
status: needs-decision
priority: P2
owner: module:Gdpr
module: Gdpr
created: 2026-10-14
updated: 2026-10-14
qmd: "minori eta minima 14 anni registrazione consenso articolo 8 gdpr informativa comprensibile minore linee guida design 4.2.10 data di nascita"
related: [dcp-130, dcp-135, dcp-163]
---

# DCP-165: eta' minima e minori nella registrazione e nel linguaggio dell'informativa

## Lacuna e prova (2026-10-14)
Requisito 4.2.10 (Linee guida di design della PA, capitolo 4 «Requisiti» (versione corrente, letto il 2026-10-14)): se il servizio e' rivolto a minori, l'informativa deve essere comprensibile a un minore. Misura: nessuna regola di eta' minima per registrarsi; il profilo ha il campo `birth_date` ma il modulo di registrazione non lo chiede; nessuna menzione dei minori nei file lingua di registrazione.

## Norma
GDPR art. 8 (consenso dei minori nei servizi della societa' dell'informazione; l'Italia fissa l'eta' a 14 anni con l'art. 2-quinquies del Codice privacy: NON VERIFICATO nel registro fonti 02) e art. 12 (informazioni comprensibili per un minore). La base giuridica del servizio e' il compito di interesse pubblico (art. 6 par. 1 lett. e), non il consenso: l'art. 8 potrebbe quindi non applicarsi alla registrazione. La valutazione e' del DPO.

## Requisiti
1. Decisione scritta dell'ente: il servizio e' consentito ai minori? Con quale eta' e quali regole (assenso dei genitori)?
2. Se si limita: dichiarazione di eta' minima nella registrazione, nei termini (DCP-162) e nell'informativa, in 4 lingue.
3. Se e' aperto ai minori: versione dell'informativa in linguaggio comprensibile a un minore (sezione dedicata).
4. Nessun dato in piu' del necessario: preferire una dichiarazione di eta' a una data di nascita.

## Criteri di accettazione
- [ ] Decisione registrata nella story e nel decision log del modulo.
- [ ] Il modulo di registrazione e i testi legali dicono la stessa regola in it, en, de, es (test di parita').

## Dipendenze e priorita'
Decisione dell'ente e del DPO (needs-decision). Collegata a DCP-130 (informativa) e DCP-162 (condizioni d'uso). P2.
