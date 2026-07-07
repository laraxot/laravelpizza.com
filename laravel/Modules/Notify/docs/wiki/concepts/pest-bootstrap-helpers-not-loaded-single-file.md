---
title: "Pest — helper di tests/Pest.php non sempre caricati per run isolate"
type: concept
module: Notify
tags: [pest, bootstrap, helpers, second-brain]
created: 2026-07-06
updated: 2026-07-06
---

# Pest — funzioni helper di `tests/Pest.php` non affidabili su run isolate

## Problema

`Modules/Notify/tests/Pest.php` definisce funzioni helper globali
(`assertListContains`, `assertReflectionTypeName`, ecc.) senza `namespace`,
pensate per essere richiamate da qualunque test del modulo. Funzionano
quando si esegue l'intera suite, ma **falliscono con "Call to undefined
function"** quando si esegue un singolo file in isolamento, es.:

```bash
./vendor/bin/pest Modules/Notify/tests/Unit/Datas/SmsDataTest.php --no-coverage
# Error: Call to undefined function assertListContains()
```

Riprodotto anche con chiamata fully-qualified (`\assertListContains(...)`),
quindi non e' un problema di risoluzione di namespace: il bootstrap
`tests/Pest.php` semplicemente non viene richiesto in quel percorso di
esecuzione. Non e' stato introdotto in questa sessione — riproducibile anche
su file mai toccati (`SmsDataTest.php`).

## Causa probabile (non confermata)

Il monorepo ha un `phpunit.xml` di root con `<testsuite name="Notify">
<directory>Modules/Notify/tests</directory></testsuite>`, quindi Pest
dovrebbe risolvere `Modules/Notify/tests/Pest.php` come bootstrap piu'
vicino. Sospetto: la cache di discovery di Pest (`.pest.cache` o simile) o
l'ordine di inclusione tra `testsuite` multipli nello stesso `phpunit.xml`
root non garantisce il caricamento del `Pest.php` di modulo quando si passa
un path specifico invece del nome della testsuite.

## Workaround adottato (non e' un fix del bootstrap)

Per gli helper usati da piu' file test nella stessa cartella/namespace,
dichiarare una funzione locale guardata:

```php
if (! function_exists(__NAMESPACE__.'\nomeHelper')) {
    function nomeHelper(...): ... { ... }
}
```

La guardia `function_exists` evita `Cannot redeclare` quando piu' file dello
stesso namespace (che finiscono per essere caricati insieme in un run
dell'intera suite) dichiarano la stessa funzione. Applicato in:

- `Modules/Notify/tests/Unit/Actions/SMS/Send{Gammu,Netfun,Twilio,Nexmo,Plivo}SMSActionTest.php`

## Da fare (non in scope di questa sessione)

Investigare la vera causa del mancato caricamento di `tests/Pest.php` su run
isolate — probabilmente richiede un test con `--debug` di Pest o ispezione
di `vendor/pestphp/pest/src/Kernel.php` per capire come risolve il bootstrap
quando gli viene passato un path di file invece che una directory/testsuite.
