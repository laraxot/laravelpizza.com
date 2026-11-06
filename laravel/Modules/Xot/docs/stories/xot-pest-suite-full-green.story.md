---
id: xot-pest-suite-full-green
title: "Portare la suite Pest di Xot a verde senza timeout"
type: story
status: open
priority: P0
owner: module:Xot
module: Xot
tags: [pest, test, qualita, timeout]
related: [fix-xot-unit-action-tests, fix-xot-feature-tests, fix-xot-unit-misc-tests, fix-xot-convention-tests, remove-dead-livewire-registration]
---

# Portare la suite Pest di Xot a verde senza timeout

Fase BMAD: Dev (verifica finale).

## Richiesta
Eseguire `./vendor/bin/pest Modules/Xot` fino a esito completo e verde.

## Stato
- La run completa va in timeout a 900 s dopo circa 477 righe di output (`Feature/Filament/XotBaseResourceCoverageTest` era l'ultimo test riportato).
- Il test isolato `XotBaseResourceCoverageTest` passa (13 verdi) dopo la correzione del fixture `ProbeResource`.
- Le story `fix-xot-*` dichiarano correzioni per gruppo, ma nessuna run completa le ha confermate in una sola esecuzione.

## Azioni
1. Individuare il test che blocca la suite (run con `--stop-on-failure` e timeout per file).
2. Correggere la causa, non il test: codice se il test rispetta lo scopo, test se il contratto è cambiato.
3. Rilanciare la suite completa con `timeout 900` e salvare l'esito in `laravel/Modules/Xot/docs/stories/` nella sezione Verifica.

## Verifica
- Esito Pest completo con conteggio di verdi, rossi, risky e skipped.
- PHPStan `analyse Modules/Xot`: `[OK] No errors`.
