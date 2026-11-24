---
title: "ADR — CMS e middleware possiedono la risoluzione delle pagine Folio"
type: decision
status: accepted
module: Cms
updated: 2026-11-23
---

# CMS e Folio risolvono le pagine tramite slug

## Contesto

Il front office usa pagine Folio sottili e blocchi configurati nei contenuti CMS.
Le rotte con un identificativo applicativo non sono però slug CMS distinti:
usano una pagina contenitore e delegano la visibilità del record al modulo
owner. Il Cms può essere installato senza conoscere quei moduli applicativi.

## Decisione

CMS possiede risoluzione dello slug, contenuto e middleware pagina; il tema fornisce shell e viste dei blocchi senza creare alias semantici.

Le route legacy `profile`, `user` e `users` non possono diventare un fallback pubblico:
il middleware applica la risoluzione dell'Action e restituisce 404 quando non esiste
un contenuto autorizzato. Questo mantiene il contratto di non divulgazione anche quando
la shell Folio è volutamente priva di logica di dominio.

`PageSlugMiddleware` governa la protezione dichiarata dal JSON. Il tema passa
solo i segmenti ricevuti da Folio e il data bag a `<x-page>`; non deve risolvere
direttamente `Page`, calcolare metadata, scegliere layout o introdurre rami per
login, ticket, blog o eventi.

`Modules\\Cms\\View\\Components\\Page` risolve il contenitore CMS per le rotte
dinamiche e mantiene gli identificativi applicativi nel data bag. Non trasforma
gli identificativi in slug e non decide la visibilità dei record: il blocco o
l'Action del modulo owner applica la propria policy. I metadati dinamici vengono
scritti negli attributi della richiesta prima del rendering dell'head; `Head` li
considera prima dei fallback del CMS e del tenant.

I redirect di dominio non appartengono al Cms: il modulo owner li dichiara nel
proprio middleware tramite il JSON della pagina. In questo modo il Cms resta
riutilizzabile senza Fixcity/Ticket e il tema resta una shell generica.

L'allowlist dei middleware è un punto di estensione: un modulo applicativo può
aggiungere la propria classe dal proprio service provider. La validazione resta
fail-closed, ma il Cms non deve elencare classi di domini opzionali nella
propria configurazione o nel proprio codice.

## Driver della decisione

- Evitare duplicazioni tra CMS, Folio e temi.

## Alternative scartate

- Duplicare ogni pagina CMS in una view del tema.
- Spostare il routing applicativo nei componenti visuali.
- Usare `render()` nelle pagine Folio per fare redirect o fallback CMS.
- Considerare ogni segmento numerico una pagina CMS autonoma: così si perde il
  contenitore del dominio e si duplica la politica di visibilità del modulo owner.

## Conseguenze

La stessa struttura è riusabile tra temi; gli slug e la configurazione tenant diventano parte del contratto di pagina.
Un contenitore CMS può quindi fornire il blocco e i metadati comuni a molti
record dinamici, mentre l'Action del modulo owner mantiene la privacy del record.
Quando si alleggerisce una shell, i test feature devono verificare che le
funzionalità precedenti siano ancora fornite dal middleware, dal JSON CMS,
dall'Action o dalla route del modulo owner. I test statici devono inoltre
impedire il ritorno di `render()`, query nella Blade e `@include` speciali.

## Conferma

Verificare middleware, resolver CMS e test Folio prima di aggiungere una nuova pagina.
Il contratto operativo è [page-slug-middleware.md](../contracts/page-slug-middleware.md).
