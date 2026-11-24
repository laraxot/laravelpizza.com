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

# Lang — cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **60**,
> Code 94.1 — **il più alto dei cinque moduli qui analizzati**, Arch 92.9,
> 251 casi test. Questo file non rimisura: legge quei numeri e ci mette
> sopra la lente.

62 file in `app/`, quattro dipendenze runtime (`mcamara/laravel-localization`,
`lara-zeus/spatie-translatable`, `rinvex/countries`,
`spatie/laravel-sluggable`), `require-dev` vuoto, un `phpstan.neon.dist` che
esiste ma — per definizione di `.dist` — non è quello effettivamente in uso
finché qualcuno non lo copia in `phpstan.neon`. Un `TODO`, un `dd()`, zero
`@phpstan-ignore`: profilo di debito basso, ma il vero problema di questo
modulo non è nel codice, è nel nome.

## 1. Un modulo chiamato "Lang" che dipende da `rinvex/countries`

`rinvex/countries` è un pacchetto di dati anagrafici paese (nomi, capitali,
valute, bandiere) — non è localizzazione stringhe, è geografia. Conviverci
dentro un modulo che si chiama "Lang" è la stessa categoria di problema
segnalata per UI (`Models`/`Services` di dominio infiltrati in un modulo di
presentazione): qui è "dati anagrafici" infiltrati in un modulo che
dovrebbe occuparsi solo di traduzione/i18n. Non è detto sia sbagliato — un
selettore di lingua spesso mostra anche la bandiera del paese — ma vale la
pena chiedersi esplicitamente se `rinvex/countries` è usato per QUEL motivo
specifico (localizzazione UI) o se è diventato il posto dove finiscono dati
anagrafici perché "un posto dove metterli serviva".

## 2. `phpstan.neon.dist` orfano

Il pattern `.dist` esiste per essere copiato (`cp phpstan.neon.dist
phpstan.neon`) e poi personalizzato per ambiente/agente. Se non è mai stato
copiato, ogni run di `phpstan analyse Modules/Lang` in isolamento (fuori dal
contesto root) sta probabilmente fallendo silenziosamente o cadendo sui
default — la stessa famiglia di problema misurata oggi su UI e Tenant
(nessuna configurazione locale = nessuna certificazione locale possibile).
Un comando, cinque minuti, e si sa se il file è ancora valido o se il
modulo è cambiato sotto di lui senza che nessuno l'abbia aggiornato.

## 3. `docs/` — 518 file, 98 famiglie di doppioni, e una cartella `archive/`
già presente

A differenza degli altri quattro moduli analizzati oggi, Lang ha già una
`docs/archive/` — qualcuno ci ha già provato, a fare ordine. Vale la pena
capire PERCHÉ quel tentativo si è fermato (query `git log --diff-filter=A --
Modules/Lang/docs/archive` per trovare chi e quando) invece di ripartire da
zero: se l'archiviazione manuale è stata abbandonata dopo N file, il motivo
è quasi certamente lo stesso di sempre — nessuno strumento a supportarla, e
il lavoro manuale non scala su 518 file.

## La visione, in una riga

Lang ha il profilo di debito più basso in valore assoluto tra i cinque
moduli di oggi, ma nasconde la domanda più interessante: cosa succede
quando un modulo nato per fare UNA cosa (tradurre stringhe) accumula
dipendenze che fanno cose adiacenti ma diverse (dati paese)? La risposta non
è "spostare tutto altrove domani mattina", è tracciare esplicitamente il
confine — così la prossima dipendenza aggiunta viene giudicata contro un
criterio scritto, non contro la sensazione di chi la sta aggiungendo quel
giorno.

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
