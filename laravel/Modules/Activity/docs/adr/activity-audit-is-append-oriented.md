---
status: accepted
module: Activity
---

# L'audit delle attività è append-oriented

## Contesto

Activity conserva eventi, snapshot e attività per ricostruire cosa è accaduto a un soggetto.

## Decisione

Le registrazioni di audit si producono tramite le Actions e i recorder del modulo; la cronologia non viene riscritta per correggere una visualizzazione.

## Driver della decisione

- Conservare una cronologia verificabile.

## Alternative scartate

- Usare il log applicativo come unica fonte.
- Aggiornare gli eventi storici quando cambia una label.

## Conseguenze

La cronologia resta affidabile e interrogabile; le viste devono interpretare gli eventi senza mutare la fonte storica.

## Conferma

Verificare recorder, policy e test di registrazione prima di cambiare lo schema dell'audit.
