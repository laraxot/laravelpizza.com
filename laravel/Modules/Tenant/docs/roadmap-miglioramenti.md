---
title: "roadmap miglioramenti"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap miglioramenti"
issues: []
discussions: []
---

# Tenant — cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **4 —
> il più basso dei cinque moduli qui analizzati**, Code 91.8, Arch 85.7, 173
> casi test. Questo file non rimisura: legge quei numeri e ci mette sopra la
> lente. Nota: PHPMD gira già (a livello di progetto, senza bisogno di
> config locale) e trova pochissimo — è la certificazione PHPStan
> STANDALONE del modulo, quella bloccata dal `phpstan.neon` mancante di cui
> parlo sotto, non "tutti gli esami".

Questo è il modulo più onesto del monorepo, nel senso peggiore possibile:
`require` vuoto, `require-dev` vuoto, nessun `phpstan.neon`. Zero
`dd()`/`dddx()`, zero `@phpstan-ignore`, zero `TODO`/`FIXME` — non perché sia
perfetto, ma perché con 52 file in `app/` e nessuna dichiarazione di
dipendenza è probabile che nessuno lo abbia mai analizzato sul serio in
isolamento. Un modulo "silenzioso" non è un modulo pulito, è un modulo che
non ha ancora fatto rumore.

## 1. `composer.json` che non dichiara nulla è un `composer.json` che mente

`app/Filament`, `app/Models`, `app/Services` esistono e presumibilmente
usano Eloquent, Filament, forse il trait `SushiToPhpArray`/`SushiToCsv` di
Tenant stesso (l'ho appena verificato in un'altra sessione oggi: sono i
fixture-consumer di `User\SocialProvider` e `Sigma\WebService` — Tenant è
usato da altri moduli, non è periferico). Se `require` è vuoto, o le
dipendenze vengono risolte implicitamente dal root del monorepo (funziona,
ma rende impossibile una CI standalone), oppure sono dipendenze non
dichiarate che funzionano per fortuna finché l'ordine di autoload nel root
resta quello attuale. Prima cosa da fare: `composer why-not` inverso — capire
cosa `app/` importa davvero (`grep -rhoE "^use [A-Za-z\\\\]+;" app/`) e
scriverlo in `require`.

## 2. Zero debito misurabile non vuol dire zero debito

I contatori (dd, ignore, TODO) sono a zero, ma questo modulo non ha nemmeno
un `phpstan.neon` che lo misuri: è la differenza tra "il paziente sta bene"
e "non abbiamo ancora fatto gli esami". La memoria del progetto insegna
esattamente questo — "PHPMD a zero è morto: sulla root del modulo aborta
sulla prima classe anonima" — uno zero senza uno strumento configurato dietro
è un numero senza significato. Prima azione concreta, low-cost: copiare
`phpstan.neon.dist` da un modulo comparabile (Rating, dimensioni simili, ha
già `.dist`) e adattarlo, poi far girare `phpstan analyse Modules/Tenant` e
guardare cosa esce per davvero.

## 3. `docs/` — 190 file, solo 8 famiglie di doppioni: il modulo più pulito
dei cinque analizzati oggi su questo fronte

Ordine di grandezza più basso di tutti gli altri (Xot 284, User 205, UI 70,
Lang 98, Tenant 8). Se la bonifica documentale proposta per Xot/User parte
da qualche parte per costruire fiducia nel processo prima di attaccare i
moduli grandi, Tenant è il pilota naturale: pochi file, pochi doppioni,
rischio basso di rompere link in giro per il monorepo.

## La visione, in una riga

Tenant non ha debito visibile perché non ha ancora gli strumenti per
renderlo visibile. La prossima settimana giusta per questo modulo non è
scrivere feature nuove, è dargli `phpstan.neon` + `require`/`require-dev`
onesti e SCOPRIRE quanto debito c'è davvero, invece di continuare a
presumere che "zero segnalazioni" voglia dire "zero problemi".

---
title: "roadmap miglioramenti"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap miglioramenti"
issues: []
discussions: []
*Analisi generata il 2026-09-01, dati verificati sul codice (grep/find), non
sulla documentazione esistente.*
