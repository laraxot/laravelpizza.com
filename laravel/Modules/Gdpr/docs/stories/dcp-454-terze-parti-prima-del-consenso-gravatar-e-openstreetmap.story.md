---
id: dcp-454
title: "DCP-454: terze parti caricate prima del consenso (avatar Gravatar e tile OpenStreetMap): decisione"
type: story
status: needs-decision
module: Gdpr
created: 2026-11-12
updated: 2026-11-12
tags: [bmad, story, gdpr, cookie, consenso, gravatar, openstreetmap, terze-parti, csp, decisione]
qmd: "terze parti prima del consenso gravatar avatar md5 email tile openstreetmap cookie banner solo tecnici csp informativa UX-04 UX-09 DEC-69 CMT-022"
related:
  - ./dcp-445-guardia-del-cablaggio-del-banner-cookie.story.md
  - ./dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
  - ./dcp-136a-cookie-banner-stato-reale-audit-visivo.story.md
  - ../../../Fixcity/docs/stories/dcp-200-registro-unico-delle-decisioni-aperte.story.md
  - ../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md
issues: ["https://github.com/laraxot/theme_sixteen_fila5/issues/106"]
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/94", "https://github.com/laraxot/theme_sixteen_fila5/discussions/107"]
---

# DCP-454: terze parti caricate prima del consenso

Status: **da decidere** (2026-11-12). Fase BMAD: Analysis fatta (audit F, UX-04 e UX-09, 2026-11-11); nessuna modifica di comportamento. Registro: DEC-69 in DCP-200.

## Cosa succede oggi (misurato nell'audit, non rimisurato oggi)

| Servizio | Dove | Cosa parte prima di qualunque scelta del cittadino |
|---|---|---|
| `www.gravatar.com` | blog, dettaglio del ticket, header da loggato | richiesta dell'avatar: nell'HTML c'è l'**hash md5 dell'email**; il servizio terzo riceve anche IP e user agent |
| `*.tile.openstreetmap.org` | mappe | richiesta dei tile: il servizio terzo riceve IP e user agent |

La barra cookie dice «solo cookie tecnici» senza citare questi terzi. Non sono cookie: sono richieste a un servizio esterno che avvengono comunque.

## Perché non l'ho cambiato

Cambia il **comportamento** (l'avatar o la mappa non compaiono finché il cittadino non sceglie) e la **base giuridica** dichiarata nell'informativa. È una scelta del titolare con il DPO,
non del tema. Il lavoro tecnico di entrambe le strade è piccolo; sbagliare la scelta no.

## Opzioni (DEC-69)

| Opzione | Cosa cambia | Costo |
|---|---|---|
| (a) **Non chiamare il terzo finché non c'è una scelta**: iniziali locali al posto di Gravatar, segnaposto o mappa locale al posto dei tile OSM, il servizio parte dopo il consenso | nessun dato al terzo senza scelta; l'utente vede meno finché non sceglie | la mappa è una funzione centrale del wizard (passo 2): serve un'alternativa locale o un consenso esplicito per la mappa |
| (b) **Proxy lato server** per l'avatar (Gravatar visto dal solo server) | l'IP del cittadino non arriva a Gravatar, ma l'hash dell'email sì | un servizio da mantenere; cache; l'hash resta un dato personale |
| (c) **Lasciare e dichiarare**: citare Gravatar e OpenStreetMap nell'informativa, nel registro dei cookie/terze parti (DCP-136) e nella CSP | nessun cambio di funzione | dipende dalla base giuridica scelta: se è il consenso, (c) non basta |

La sessione che ha documentato l'audit indica nel rapporto «decisione CMT-022: proxy lato server o iniziali locali, oppure citarlo nell'informativa e nella CSP». Proposta di lavoro, non decisione:
(a) per Gravatar (le iniziali locali sono un costo trascurabile), (c) o consenso esplicito per i tile della mappa finché non c'è un'alternativa locale.

## Cosa NON faccio

Non tocco `GdprServiceProvider`, il banner (DCP-445) né i template che richiamano i servizi; non cambio la CSP; non modifico l'informativa.

## Criteri di accettazione (quando si decide)

- [ ] DEC-69 decisa dal titolare e dal DPO nel registro DCP-200.
- [ ] Una guardia che prova che, senza scelta, nessuna richiesta parte verso `gravatar.com` e `tile.openstreetmap.org` (o che, se si sceglie (c), l'informativa e la CSP li citano).
- [ ] La barra cookie e l'informativa dicono la stessa cosa dei terzi.
- [ ] Misura nel browser a rete tracciata: 0 richieste a domini terzi prima della scelta (se si sceglie (a)).

## Verifica

Nessuna correzione in questa story. Il comportamento descritto è quello dell'audit del 2026-11-11 e va riprodotto prima di decidere.
