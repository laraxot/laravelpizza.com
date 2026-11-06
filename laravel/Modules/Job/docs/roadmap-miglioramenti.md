---
title: "roadmap miglioramenti"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap miglioramenti"
issues: []
discussions: []
status: draft
---

# Job: cosa migliorerei se questo modulo fosse mio da domani mattina

I numeri sono già misurati e fermi in [`docs/cosa-migliorare.md`](cosa-migliorare.md)
(PHPStan 0, PHPMD `app/` 116, PHPInsights Code 88.2 / Architecture 71.4, 347
casi di test): non li rimisuro qui. Questo documento è la lettura sopra
quei numeri: quello che nessun gate automatico vede.

Non è un modulo pigro: c'è una `QueueListenWidget` e una `ClockWidget` che fanno
il lavoro sporco di mostrare cosa succede dentro le code di Laravel in tempo
reale dentro Filament. Bella idea. Ma è pieno di fantasmi di debug lasciati a
metà, e la sua cartella `docs/` è essa stessa un piccolo incidente archeologico.

## 1. I fantasmi di `dddx()` nei widget

`app/Filament/Widgets/QueueListenWidget.php` e `ClockWidget.php` hanno la
stessa identica sequenza commentata tre volte:

```php
/** dddx($message); */
// dddx($output);
// dddx($output->fetch());
```

Stesso pattern, stesso ordine, in due file diversi. Non è debug isolato: è un
copia-incolla di debug, il che significa che questi due widget condividono
probabilmente una logica comune mai estratta. La domanda vera non è "tolgo i
`dddx()`" (ovvio, sì): è "perché due widget diversi avevano bisogno di
ispezionare `$output->fetch()` nello stesso punto del ciclo di vita?". Se la
risposta è "perché fanno la stessa cosa con un comando diverso", quella è
un'astrazione che manca, non un debug da pulire.

Nota 2026-10-20: oltre alle sequenze commentate c'era un `dddx($output)` attivo in `beginStream()` di entrambi i widget (riga 90). Il
metodo, un esperimento mai funzionante e senza chiamanti, ora lancia `LogicException`; il percorso reale e' `beginProcess()`. La
duplicazione tra i due widget resta aperta. Vedi [debug-calls-removal-job](./stories/debug-calls-removal-job.story.md).

`app/Actions/ExecuteTaskAction.php:15` ha un `// TODO: Implement task
execution`: per un'Action che si chiama letteralmente "esegui il task", è
la cosa più onesta e più preoccupante che si possa scrivere in un commento.
O l'Action è morta e va rimossa, o è viva e manca l'implementazione core.
Non esiste una terza opzione confortevole.

## 2. `docs/` che si documenta due volte da sola

`00-index.md` e `00-INDEX.md` esistono entrambi. `actions.md` e `ACTIONS.md`
pure. Su un filesystem case-insensitive (Mac, la maggior parte dei setup
Windows) uno dei due letteralmente sovrascrive l'altro al checkout: la
collisione non è teorica, è già in corso silenziosamente per chiunque non
lavori su Linux puro.

E poi c'è `docs/a.git`, 66 byte, permessi `777`, contenuto:

```
gitdir: ../../../../.git/modules/laravel/Modules/Job/modules/docs
```

Questo è un relitto di un vecchio submodule Git: `docs/` doveva essere in
un'epoca precedente un repository annidato a sé stante, poi qualcuno ha fuso
la storia ma ha dimenticato di cancellare il puntatore. È innocuo (Git lo
ignora, non essendo chiamato `.git`), ma è un fossile che racconta una storia
vera: questo modulo ha già cambiato forma una volta senza che nessuno lo
scrivesse da nessuna parte. Vale la pena capire se `docs/modules` a cui punta
esiste ancora prima di cancellarlo.

## 3. Zero attrezzi per verificarsi da solo

`composer.json` ha `require: ["php"]` e `require-dev: []`. Punto. Nessun
`larastan`, nessun `pest`, nessun `phpstan-safe-rule`. Non è un giudizio sulla
qualità del codice attuale (il gate a livello di monorepo lo misura comunque,
`phpstan analyse Modules` gira sul tutto): è un giudizio sulla capacità di
Job di certificare sé stesso se un giorno finisse fuori dal monorepo, come CI
standalone sul proprio repository GitHub. Oggi non potrebbe: `vendor/bin/phpstan`
non esisterebbe nemmeno dopo un `composer install` pulito.

## 4. La visione, se devo essere eccentrico

Un modulo che si chiama "Job" e mostra code Laravel dentro Filament ha
un destino naturale che nessuno sta perseguendo: diventare il pannello di
controllo delle code per TUTTI gli altri moduli del monorepo, non solo per sé
stesso. Oggi è un modulo come gli altri con due widget carini. Potrebbe essere
l'unico posto dove chiunque, in qualsiasi modulo, guarda per sapere "cosa sta
processando il sistema in questo momento". Ma per arrivarci prima deve smettere
di avere `TODO: Implement task execution` nel cuore della sua Action
principale: non si costruisce un pannello di controllo sopra una funzione che
ammette candidamente di non fare ancora nulla.

## In ordine di rischio/sforzo

1. Rimuovere `docs/ACTIONS.md`/`00-INDEX.md` duplicati (dopo aver verificato
   quale dei due è aggiornato: non a caso, con `git log -p` su entrambi).
2. Decidere il destino di `ExecuteTaskAction::execute()`: implementare o
   eliminare, non lasciare un TODO che mente su cosa fa il modulo.
3. Estrarre la logica condivisa dietro i `dddx()` gemelli nei due widget in un
   trait o in un'Action comune, poi cancellare i commenti di debug.
4. Popolare `require-dev` (almeno `larastan/larastan`, `pestphp/pest`) così
   il modulo può certificarsi da solo, non solo come parte del monorepo.
