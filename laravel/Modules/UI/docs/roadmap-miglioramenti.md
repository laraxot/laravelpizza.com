---
title: "UI — cosa migliorerei se questo modulo fosse mio per un mese"
qmd: "ui roadmap miglioramenti md"
type: note
tags: [documentation]
---

# UI — cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **67**,
> Code 91.8, Arch 92.9, 290 casi test. Questo file non rimisura: legge quei
> numeri e ci mette sopra la lente.

107 file in `app/`, due dipendenze runtime (icone: FontAwesome, Heroicons),
`require-dev` completamente vuoto e **nessun `phpstan.neon` proprio**. UI è
il modulo "solo presentazione" per definizione architetturale del progetto
(vedi la memoria "componente nel modulo del suo dominio" — se un componente
UI serve solo un dominio specifico, non appartiene qui). Eppure ha 8
`dd()`/`dddx()` e 4 `@phpstan-ignore` per 107 file: una densità di debito
per-file più alta di Xot, su un modulo che dovrebbe essere il più semplice
di tutti.

## 1. Un modulo di sola presentazione con `Datas`, `Rules`, `Services`

`app/` di UI contiene `Actions`, `Console`, `Contracts`, `Data`, `Datas`,
`Enums`, `Filament`, `Forms`, `Http`, `Models`, `Providers`, `Rules`,
`Services`, `Traits`, `View` — sia `Data` sia `Datas` (probabile residuo di
una migrazione naming mai completata, o un doppione da PSR-4-verificare
come nel caso Tenant risolto stamattina), più `Models` e `Rules` e
`Services`, che per un modulo "solo presentazione" sono odore di logica di
dominio infiltrata. La domanda da farsi modulo per modulo non è "questo
componente sta in UI", è "questo Model/Rule/Service in UI *dovrebbe* stare
in UI" — e la risposta, quasi sempre in un'architettura a moduli, è no.

## 2. Zero PHPStan proprio significa zero certificazione possibile

Torna il tema della sessione di oggi: l'utente vuole badge "risultanti da
certificazione reale", ma un modulo senza `phpstan.neon` proprio non PUO'
essere certificato in isolamento — solo dentro il contesto del monorepo
(`phpstan analyse Modules`, che gira da root). Se l'obiettivo è CI reale per
badge reali modulo-per-modulo, UI è uno dei moduli dove il lavoro non è
"aggiungere un file YAML", è prima creare `phpstan.neon` locale e popolare
`require-dev` — altrimenti il workflow CI fallisce al primo `composer
install` perché mancano `larastan`/`pest`.

## 3. `docs/` — 416 file, 70 famiglie di doppioni: più contenute delle altre,
<<<<<<< HEAD
=======
ma con una particolarità: `algolia-docsearch.md` e `algolia-docsearch.md`

>>>>>>> laraxot/dev
ma con una particolarità: `algolia-docsearch.md` e `algolia-docsearch-1.md`

Un modulo di componenti UI che documenta Algolia DocSearch (uno strumento di
ricerca documentale) due volte con nomi quasi identici è un piccolo indizio
che la disciplina "un file, un argomento, un nome" non è mai stata applicata
sistematicamente qui, nemmeno su temi non core come questo. Scala minore
rispetto a Xot/User (70 gruppi su 416 file, circa 1 su 6, contro 1 su 8 di
Xot) — segno che è comunque il candidato più economico per fare da pilota
sulla bonifica: se lo script di raggruppamento proposto per Xot funziona
bene qui, si scala agli altri.

## La visione, in una riga

UI dovrebbe essere il modulo più semplice del monorepo e invece porta debito
sproporzionato al suo peso (`Data`+`Datas`, `Models`/`Services` di dominio
infiltrati, zero config di analisi propria). Prima di aggiungere altri
componenti, vale la pena chiedersi se questo modulo sta ancora facendo solo
presentazione o se è già diventato un secondo modulo di dominio travestito.

---
*Analisi generata il 2026-09-01, dati verificati sul codice (grep/find/ls),
non sulla documentazione esistente.*
