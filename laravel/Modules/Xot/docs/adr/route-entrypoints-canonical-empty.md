---
title: "Xot — entrypoint route no-op canonico"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
issues: ["#92"]
---

# ADR: entrypoint route no-op canonico

## Contesto

Alcuni moduli includono `Modules/Xot/routes/empty.php` quando non espongono route proprie. Senza questo file il
bootstrap dell'applicazione fallisce prima dei test e delle richieste HTTP.

I moduli caricati da `XotBaseRouteServiceProvider` devono mantenere i propri file `routes/api.php` e `routes/web.php`,
anche quando non espongono route. Molti di questi file contenevano lo stesso boilerplate, o nessuna dichiarazione
attiva, duplicando testo senza aggiungere comportamento (Issue #92).

## Driver della decisione

- Preservare i percorsi attesi dal provider comune.
- Eliminare il boilerplate duplicato senza cambiare prefissi, middleware o nomi.
- Evitare di accorpare route di domini diversi in un modulo non owner.
- Mantenere separati i contratti attivi di ogni modulo.

## Decisione

Il file esiste in `Modules/Xot/routes/empty.php`, contiene solo il return di un array vuoto e viene riusato dagli
entrypoint dei moduli privi di route. I soli entrypoint privi di dichiarazioni attive e duplicati tra moduli delegano a
quel file: il provider continua a caricare il percorso route del modulo, e l'entrypoint canonico restituisce un array
vuoto e non registra route. Le route attive, i file speciali e `Modules/User` restano esclusi da questa
consolidazione.

## Alternative scartate

- Duplicare un file vuoto in ogni modulo: crea più fonti di verità.
- Eliminare i `require` o cancellare gli entrypoint: il provider comune li carica per percorso, amplia il cambiamento e
  non risolve il contratto comune degli entrypoint.
- Spostare route attive nel modulo Xot: violerebbe l'ownership.
- Modificare `XotBaseRouteServiceProvider`: scope più ampio e rischio sui moduli attivi.

## Conseguenze

- Il caricamento delle route è deterministico anche per i moduli senza endpoint; il file non registra route e non
  produce effetti collaterali.
- Gli entrypoint vuoti restano presenti e continuano a rispettare il contratto del provider comune.
- Il comportamento delle route attive non cambia, perché la consolidazione riguarda solo file senza dichiarazioni
  attive.
- Il test di routing deve restare aggiornato quando nasce un nuovo entrypoint vuoto o cambia l'ownership di una route.

## Conferma

`php artisan --version` deve completare il boot senza errore di file mancante.

## Verifica

`Modules/Xot/tests/Unit/Routing/CanonicalEmptyRouteEntrypointsTest.php` verifica che ogni entrypoint consolidato deleghi
al file canonico e che il file canonico non registri route:
`cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Routing/CanonicalEmptyRouteEntrypointsTest.php`.
