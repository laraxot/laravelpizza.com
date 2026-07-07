---
title: "Product Brief: LaravelPizza.com"
status: final
created: 2026-07-07
updated: 2026-07-07
---

# Product Brief: LaravelPizza.com

## Executive Summary

LaravelPizza.com è la conversione e l'elevazione del sito originale [laravelpizza.com](https://laravelpizza.com/) in una piattaforma per la community italiana degli sviluppatori Laravel: uno spazio dove scoprire, organizzare e partecipare a meetup, costruito interamente su Laravel 12 moderno (Folio + Volt + Filament + Livewire) secondo la metodologia proprietaria "Laraxot".

Il progetto ha una doppia natura, entrambe centrali e non negoziabili: è un **prodotto reale** per la community dei meetup Laravel italiani, ed è al tempo stesso una **vetrina tecnica open-source** — un caso di studio dal vivo che dimostra un'architettura modulare estrema (PHPStan livello 10, zero controller tradizionali, CMS JSON-driven) capace di attrarre sviluppatori e contributori al codice.

Oggi il progetto esiste solo in sviluppo locale, guidato praticamente da un solo autore (515 commit) con supporto AI. Il brief serve a fissare cosa serve per portarlo a un primo rilascio pubblico credibile su entrambi i fronti: community reale e vetrina open-source.

## Il Problema

Chi organizza o partecipa a meetup Laravel in Italia oggi si affida a strumenti generici e frammentati (Meetup.com, gruppi Telegram/Discord, form Google) che non sono pensati per la specificità di una community tecnica: niente vetrina del codice sorgente, nessuna integrazione con il proprio stack, nessuna occasione di "eat your own dog food" mostrando Laravel best-practice agli stessi partecipanti.

Parallelamente, chi vuole imparare pattern Laravel moderni avanzati (Folio, Volt, Filament, architettura modulare, PHPStan a livello massimo) fatica a trovare **un progetto reale, non giocattolo**, che li applichi tutti insieme in modo coerente e documentato.

[ASSUMPTION] Il costo dello status quo è soprattutto opportunità mancata: senza una piattaforma dedicata, i meetup Laravel italiani restano isolati tra loro e il framework "Laraxot" non ha una dimostrazione pubblica che ne provi il valore a nuovi adottanti.

## La Soluzione

Una piattaforma di meetup community-driven — scoperta eventi pubblica, registrazione, gestione admin via Filament, contenuti gestiti via CMS JSON senza deploy — che è essa stessa costruita e documentata come un progetto open-source esemplare.

Le due dimensioni si rinforzano a vicenda: più la piattaforma è usata dai meetup reali, più diventa un caso di studio credibile; più il codice è pulito e ben documentato, più attrae contributori che a loro volta migliorano il prodotto per gli utenti reali.

## Cosa la Rende Diversa

- **Doppio scopo dichiarato ed esplicito**: a differenza di una piattaforma di eventi generica, ogni scelta tecnica è anche un contenuto didattico/dimostrativo (es. XotBase pattern, `belongsToManyX`, Folio+Volt "no controller").
- **Disciplina architetturale radicale**: PHPStan livello 10, zero errori, un solo file di migrazione per tabella, nessuna estensione diretta di classi Filament — regole raramente rispettate con questo rigore in progetti reali di questa scala.
- [ASSUMPTION] Il vantaggio competitivo non è la velocità di esecuzione né una tecnologia proprietaria segreta, ma la **coerenza e la disciplina documentativa** (400+ regole `.cursor/rules/`, docs per modulo) che rende il progetto riutilizzabile come riferimento da altri team, non solo leggibile.

## A Chi Si Rivolge

**Utente primario — Sviluppatore/organizzatore di meetup Laravel in Italia**: vuole scoprire eventi vicino a sé, iscriversi rapidamente, ed eventualmente vedere/contribuire al codice che alimenta il sito stesso. Successo per lui: trova un evento, si iscrive senza attrito, e — se curioso — trova un repo leggibile e ben strutturato.

**Utente secondario — Sviluppatore Laravel alla ricerca di pattern avanzati** (community open-source più ampia, non necessariamente italiana): vuole vedere Folio+Volt+Filament+architettura modulare applicati a un progetto reale e navigabile. Successo per lui: capisce il pattern leggendo codice e docs, e magari apre una PR.

[ASSUMPTION] Utente terziario — organizzatori di altri meetup tech (non solo Laravel) che vogliono "clonare" l'approccio come riferimento per il proprio gruppo.

## Criteri di Successo

A 3-6 mesi dal primo rilascio pubblico, il progetto ha successo se, insieme:

- **Adozione reale**: almeno un meetup Laravel italiano usa la piattaforma per un evento reale end-to-end (pubblicazione evento → iscrizioni → partecipazione).
- **Vetrina attiva**: il repository riceve interesse esterno misurabile — star, fork, o almeno una contribuzione/issue da un contributore non affiliato al team originale.
- I requisiti funzionali v1 già tracciati in `.planning/REQUIREMENTS.md` (ADMN, EVNT, REGS, CMSP, LOCL, QUAL) sono completati e verificati.
- [ASSUMPTION] Qualità tecnica mantenuta: PHPStan livello 10, zero errori, e copertura test Pest come da obiettivo Track B in `.planning/PROJECT.md`, poiché la credibilità come vetrina dipende dal mantenimento di questi standard, non solo dal loro raggiungimento iniziale.

## Ambito

**Dentro per la v1** (da `.planning/REQUIREMENTS.md`):
- Admin Filament per eventi, venue, performer, sponsor, iscrizioni
- Scoperta pubblica eventi (lista, dettaglio, filtro per città/data) senza autenticazione
- Flusso di registrazione con conferma email e limite capienza
- Pagine pubbliche CMS-driven da JSON (no deploy per aggiornare contenuti)
- Localizzazione IT/EN completa
- Conformità: cookie consent, WCAG 2.1 AA, SEO/JSON-LD

**Fuori scope per la v1** (esplicito, da `.planning/REQUIREMENTS.md`):
- Pagamenti/biglietti a pagamento (Stripe/Apple Pay) — rimandato a v2
- Profili utente con storico partecipazioni, profili pubblici performer — rimandato a v2
- Chat in tempo reale, app native, live streaming, OAuth esterno — esclusi esplicitamente

## Visione

Se ha successo, LaravelPizza.com diventa il punto di riferimento de facto per organizzare meetup Laravel in Italia, e allo stesso tempo un progetto open-source citato come esempio di architettura Laravel modulare disciplinata — al punto che altri team Laraxot o community tech (non necessariamente Laravel) lo usano come starter kit per i propri eventi.

[ASSUMPTION] Nel medio termine (2-3 anni), il framework "Laraxot" dimostrato qui potrebbe generalizzarsi in un vero e proprio starter-kit riusabile per community tech di qualsiasi tipo, con questo progetto come reference implementation storica.
