# Risoluzione conflitto XotBaseRouteServiceProvider.php

## Problema
Il file conteneva marker di conflitto git  all'interno del metodo `boot()`, con possibili duplicati o codice commentato.

## Scelta
- Sono stati rimossi tutti i marker di conflitto.
- È stato mantenuto il codice più recente e coerente con la logica del modulo.
- La chiamata a `parent::boot();` viene mantenuta dopo la configurazione di `extra_conn`.
- La sintassi e lo stile PSR-12 sono stati rispettati.

## Collegamento alla doc root
Vedi `/docs/xot_conflict_links.md` per la mappatura dei file documentati localmente e i riferimenti incrociati.
