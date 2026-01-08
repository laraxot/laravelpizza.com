# Introduzione al Use Case Bank (Event Sourcing)

Questo use case documenta la realizzazione di un sistema bancario ispirato a [larabank-aggregates](https://github.com/spatie/larabank-aggregates) di Spatie, che utilizza i pattern di event sourcing, aggregate root e proiettori per la gestione di conti correnti, transazioni e regole di business bancarie.

## Contesto
L'obiettivo è mostrare come implementare logiche bancarie robuste (limiti di saldo, notifiche, proposte di prestito) tramite eventi immutabili e aggregate che prendono decisioni in base allo storico degli eventi.

## Vantaggi
- Tracciabilità completa delle operazioni
- Facilità di audit e rollback
- Separazione tra logica di business (aggregate) e viste di lettura (proiezioni)
- Estendibilità tramite nuovi eventi e reattori

## Regole di Business Principali
- Un conto non può andare sotto -5000
- Se il limite viene raggiunto 3 volte di seguito, viene proposta un'offerta di prestito

La documentazione seguente dettaglia architettura, flussi, best practice e test per questo scenario. 
