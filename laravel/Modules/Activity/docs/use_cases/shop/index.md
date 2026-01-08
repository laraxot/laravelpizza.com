# Carrello della Spesa con Event Sourcing

## Introduzione

Questo caso d'uso esplora l'implementazione di un carrello della spesa utilizzando Event Sourcing in Laravel, basandosi sui progetti di Spatie. L'obiettivo è analizzare come l'Event Sourcing può essere applicato per gestire lo stato di un carrello della spesa, tracciando ogni modifica attraverso eventi.

I progetti analizzati sono:
- **Laravel Shop Main** (`/var/www/html/laravel-shop-main/`): Un'applicazione di riferimento per dimostrare il potere dell'Event Sourcing, con un carrello della spesa di base.
- **Laravel Shop Command Bus** (`/var/www/html/laravel-shop-command-bus/`): Un pacchetto che fornisce un'implementazione più strutturata del carrello con Event Sourcing.

## Obiettivo

L'obiettivo di questa documentazione è comprendere come l'Event Sourcing può essere utilizzato per gestire un carrello della spesa, con particolare attenzione a:
- Tracciabilità completa delle modifiche allo stato del carrello.
- Separazione della logica di business attraverso eventi e aggregate.
- Applicazione di questi concetti al modulo `Activity` per possibili use case come la gestione di ordini o acquisti.

## Struttura della Documentazione

- **Architettura**: Descrive la struttura di base dei progetti e come l'Event Sourcing è implementato.
- **Eventi**: Elenca gli eventi principali utilizzati per gestire il carrello.
- **Implementazione**: Guida pratica per implementare un carrello della spesa ispirato a questi progetti.
- **Confronto**: Analisi comparativa tra i due approcci di Spatie.

## Rilevanza per il Modulo Activity

Un carrello della spesa basato su Event Sourcing può essere adattato per gestire ordini o acquisti nel contesto del modulo `Activity`, ad esempio per tracciare forniture mediche o servizi acquistati da pazienti o strutture sanitarie.
