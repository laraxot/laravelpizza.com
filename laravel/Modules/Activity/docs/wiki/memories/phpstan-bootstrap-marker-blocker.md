---
title: "PHPStan: bootstrap bloccato da marker Activity"
type: memory
status: active
created: 2026-09-28
tags: [phpstan, bootstrap, merge-markers, activity, multi-agent]
qmd: "phpstan Modules bootstrap Activity marker conflitto parse error remediation"
---

# PHPStan: bootstrap bloccato da marker Activity

Il 2026-09-28 `cd laravel && ./vendor/bin/phpstan analyse Modules` ha trovato 51 finding
dopo il bootstrap iniziale. I fix mirati hanno poi esposto il blocco precedente: il working
tree contiene marker di conflitto in 380 file PHP sotto Activity/Themes e 136 parse error.

Non risolvere blocchi annidati cancellando soltanto `<<<<<<<`, `=======`, `>>>>>>>`: si
concatenano due varianti e il file resta sintatticamente invalido. Prima del prossimo gate
occorre identificare il proprietario del WIP e recuperare ogni file da una revisione integra,
con confronto contenuto per contenuto. `phpstan.neon` resta immutabile.

Riesecuzione successiva: il blocco si è spostato su `Modules/Xot/helpers/Helper.php:16`
e la scansione è salita a 1.452 file PHP marcati. Questo indica una modifica concorrente
del working tree; prima di correggere occorre fermare il processo/agent che reintroduce
i marker e creare una fotografia stabile del tree.

Un tentativo successivo ha prodotto 114 finding reali, ma il tree ha nuovamente ricevuto
marker durante la remediation: il gate è tornato al bootstrap failure e la scansione ha
rilevato 211 file PHP marcati. Non eseguire altri fix paralleli finché il working tree non
resta stabile per tutta la durata di un run PHPStan.

Ultimo run: 53 errori e 10 processi PHPStan concorrenti. Sono ricomparsi file già corretti;
il conteggio è quindi non deterministico. Un gate fleet-wide richiede un solo orchestratore
e nessun writer concorrente.

Verifica finale 2026-09-28: tree stabile, PHPStan verde su 10.179 file. Il blocco di
bootstrap è superato; il Pest mirato resta non verificato per timeout/blocco ambientale.
