---
title: "Xot — entrypoint route no-op canonico"
type: decision
status: superseded
superseded_by: ../stories/module-route-files-exist-in-all-modules.story.md
created: 2026-11-23
updated: 2026-11-24
issues: ["#92"]
---

# ADR: entrypoint route no-op canonico

> **Superato (2026-11-24, decisione dell'utente).** `require base_path('Modules/Xot/routes/empty.php')` e' brutto,
> sbagliato e controproducente: lascia in ogni modulo un file che dipende dal percorso di un altro modulo, per un no-op
> che un file minimo fa da solo. Regola in vigore: `routes/web.php` e `routes/api.php` **devono esistere in tutti i
> moduli**, anche con il solo `<?php` (qui con `declare(strict_types=1);`, come `AI/routes/web.php` e `Job/routes/web.php`). Nessun
> `require`, nessun `empty.php` (rimosso), nessun controllo `is_file` nel provider: un file sparito deve restare un
> errore visibile. Il test `Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php` impone l'esistenza dei
> due file in ogni modulo con `RouteServiceProvider` che estende `XotBaseRouteServiceProvider`. Verificato con
> `route:list`: 505 route identiche. Il testo sotto resta come cronologia.

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

Il test `CanonicalEmptyRouteEntrypointsTest` non esiste piu'. Lo sostituisce
`Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php`, che verifica l'esistenza dei due file in ogni
modulo con provider base e di quelli che il provider carica davvero:
`cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php`.
